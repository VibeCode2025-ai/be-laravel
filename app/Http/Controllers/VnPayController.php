<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\PendingOrder;
use App\Models\SanPham;
use App\Models\Kho;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VnPayController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            $request->validate([
                
                'ten_khachhang' => 'required|string|max:255',
                'email' => 'required|email',
                'sdt' => 'required|string|max:15',
                'diachi' => 'required|string',
                'giohang' => 'required|array|min:1',
                'giohang.*.sanpham_id' => 'required|integer|exists:sanpham,masp',
                'giohang.*.so_luong' => 'required|integer|min:1',
                'giohang.*.don_gia' => 'required|numeric|min:0',
                'tong_tien' => 'required|numeric|min:1000',
            ]);

            // TẠO TXN_REF DUY NHẤT
            $txnRef = 'ORD' . time() . '_' . Str::random(40);

            // LƯU VÀO DATABASE
            PendingOrder::create([
                'txn_ref' => $txnRef,
                'data' => array_merge($request->only([
                    'ten_khachhang', 'email', 'sdt', 'diachi', 'ghi_chu', 'giohang'
                ]), [
                    'user_id' => auth()->id() 
                ]),
                'expires_at' => now()->addMinutes(30),
            ]);

            $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
            $vnp_HashSecret = config('vnpay.vnp_HashSecret');
            $vnp_Url        = config('vnpay.vnp_Url');
            $vnp_ReturnUrl  = config('vnpay.vnp_ReturnUrl');

            $vnp_Amount = intval($request->tong_tien) * 100;

            $inputData = [
                "vnp_Version"    => "2.1.0",
                "vnp_Command"    => "pay",
                "vnp_TmnCode"    => $vnp_TmnCode,
                "vnp_Amount"     => $vnp_Amount,
                "vnp_CurrCode"   => "VND",
                "vnp_TxnRef"     => $txnRef,
                "vnp_OrderInfo"  => "Thanh toan don hang",
                "vnp_OrderType"  => "other",
                "vnp_ReturnUrl"  => $vnp_ReturnUrl,
                "vnp_IpAddr"     => $request->ip(),
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_Locale"     => "vn",
            ];

            ksort($inputData);
            $hashData = '';
            foreach ($inputData as $key => $value) {
                $hashData .= $key . '=' . urlencode($value) . '&';
            }
            $hashData = rtrim($hashData, '&');
            $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            $query = http_build_query($inputData);
            $finalUrl = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash;

            return response()->json([
                "payment_url" => $finalUrl
            ]);

        } catch (\Exception $e) {
            \Log::error('VNPAY Error: ' . $e->getMessage());
            return response()->json(['message' => 'Lỗi hệ thống'], 500);
        }
    }

    public function return(Request $request)
{
    $vnp_TxnRef = $request->query('vnp_TxnRef');
    if (!$vnp_TxnRef) {
        return "Thiếu vnp_TxnRef!";
    }

    // LẤY DỮ LIỆU TỪ DB
    $pending = PendingOrder::where('txn_ref', $vnp_TxnRef)
        ->where('expires_at', '>', now())
        ->first();

    if (!$pending) {
        return "Không tìm thấy dữ liệu đơn hàng hoặc đã hết hạn!";
    }

    $order = $pending->data;

    // ✅ LẤY USER ID TỪ ORDER (KHÔNG DÙNG auth())
    $userId = $order['user_id'] ?? null;
    if (!$userId) {
        $pending->delete();
        return "User ID không hợp lệ!";
    }

    // KIỂM TRA CHỮ KÝ
    $vnp_HashSecret = config('vnpay.vnp_HashSecret');
    $inputData = $request->all();
    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);

    $hashData = '';
    foreach ($inputData as $key => $value) {
        if (strpos($key, 'vnp_') === 0) {
            $hashData .= $key . '=' . urlencode($value) . '&';
        }
    }
    $hashData = rtrim($hashData, '&');
    $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    if ($secureHashCheck !== $vnp_SecureHash || $inputData['vnp_ResponseCode'] !== '00') {
        $pending->delete();
        return "Thanh toán thất bại!";
    }

    // TẠO ĐƠN HÀNG
    try {
        DB::beginTransaction();

        $donhang = DonHang::create([
            'user_id' => $userId, // ✅ SỬA ĐÚNG
            'ten_khachhang' => $order['ten_khachhang'],
            'email' => $order['email'],
            'sdt' => $order['sdt'],
            'diachi' => $order['diachi'],
            'ghi_chu' => $order['ghi_chu'] ?? null,
            'tong_tien' => $inputData['vnp_Amount'] / 100,
            'phuong_thuc_thanh_toan' => 'vnpay',
            'trang_thai' => 'đã xác nhận',
            'vnp_txn_ref' => $vnp_TxnRef,
        ]);

        foreach ($order['giohang'] as $item) {
             $kho = Kho::where('id_sanpham', $item['sanpham_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$kho) {
                    DB::rollBack();
                    return "Sản phẩm {$item['sanpham_id']} chưa có trong kho!";
                }

                if ($kho->soluong_ton < $item['so_luong']) {
                    DB::rollBack();
                    return "Không đủ tồn kho cho sản phẩm {$item['sanpham_id']}!";
                }

                $kho->soluong_ton -= $item['so_luong'];
                $kho->soluong_daban += $item['so_luong'];
                $kho->save();

            ChiTietDonHang::create([
                'donhang_id' => $donhang->id,
                'sanpham_id' => $item['sanpham_id'],
                'so_luong' => $item['so_luong'],
                'don_gia' => $item['don_gia'],
                'thanh_tien' => $item['don_gia'] * $item['so_luong'],
            ]);
        }

        DB::commit();

        // XÓA DỮ LIỆU TẠM
        $pending->delete();

        return redirect()->away(env('FRONTEND_URL') . '/thanh-toan-thanh-cong?donhang=' . $donhang->id);

    }catch (\Exception $e) {
        DB::rollBack();
        \Log::error('VNPAY RETURN ERROR', [
            'message' => $e->getMessage()
        ]);
        return "Lỗi hệ thống!";
    }
}
}