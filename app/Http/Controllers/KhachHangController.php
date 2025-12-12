<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhachHangController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'ten_khachhang' => 'required|string|max:255',
            'email' => 'required|email',
            'sdt' => 'required|string|max:15',
            'diachi' => 'required|string',
            'phuong_thuc_thanh_toan' => 'required|string',
            'giohang' => 'required|array',
            'giohang.*.sanpham_id' => 'required|integer',
            'giohang.*.so_luong' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $tongTien = 0;
            $chiTiet = [];

            foreach ($request->giohang as $item) {

                $sanpham = SanPham::findOrFail($item['sanpham_id']);

                $soLuong = intval($item['so_luong']);
                $gia = intval($sanpham->giamoi);   
                $thanhTien = $gia * $soLuong;

                $tongTien += $thanhTien;

                $chiTiet[] = [
                    'sanpham' => $sanpham,
                    'so_luong' => $soLuong,
                    'don_gia' => $gia,
                    'thanh_tien' => $thanhTien,
                ];
            }

            $donhang = DonHang::create([
                'user_id' => auth()->id(),
                'ten_khachhang' => $request->ten_khachhang,
                'email' => $request->email,
                'sdt' => $request->sdt,
                'diachi' => $request->diachi,
                'tong_tien' => $tongTien,
                'ghi_chu' => $request->ghi_chu ?? null,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                'trang_thai' => 'Chờ xử lý',
            ]);

            foreach ($chiTiet as $item) {
                ChiTietDonHang::create([
                    'donhang_id' => $donhang->id,
                    'sanpham_id' => $item['sanpham']->masp,
                    'so_luong' => $item['so_luong'],
                    'don_gia' => $item['don_gia'],
                    'thanh_tien' => $item['thanh_tien'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Đặt hàng thành công!',
                'donhang_id' => $donhang->id,
                'donhang' => DonHang::with(['chiTietDonHang.sanpham'])->find($donhang->id),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Đặt hàng thất bại',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


//         public function createPayment(Request $request)
// {
//     $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
//     $vnp_HashSecret = config('vnpay.vnp_HashSecret');
//     $vnp_Url        = config('vnpay.vnp_Url'); 
//     $vnp_ReturnUrl  = config('vnpay.vnp_ReturnUrl');

//     $vnp_TxnRef = 'ORD' . time();
//     $vnp_Amount = intval($request->amount) * 100;

//     $inputData = [
//         "vnp_Version"    => "2.1.0",
//         "vnp_Command"    => "pay",
//         "vnp_TmnCode"    => $vnp_TmnCode,
//         "vnp_Amount"     => $vnp_Amount,
//         "vnp_CurrCode"   => "VND",
//         "vnp_TxnRef"     => $vnp_TxnRef,
//         "vnp_OrderInfo"  => "Thanh toán hóa đơn #" . $vnp_TxnRef,
//         "vnp_OrderType"  => "other",
//         "vnp_ReturnUrl"  => $vnp_ReturnUrl,
//         "vnp_IpAddr"     => $request->ip(),
//         "vnp_CreateDate" => date('YmdHis'),
//         "vnp_Locale"     => "vn",
//     ];

//     ksort($inputData);

//     $query = "";
//     $hashData = "";

//     foreach ($inputData as $key => $value) {
//         $encodedValue = $value === '' ? '' : urlencode($value);

//         $query .= urlencode($key) . "=" . urlencode($value) . '&';
//         $hashData .= $key . "=" . $encodedValue . '&'; // Sửa ở đây: urlencode cho hash
//     }

//     $query = rtrim($query, '&');
//     $hashData = rtrim($hashData, '&');

//     $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

//     return response()->json([
//         "payment_url" => $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash
//     ]);
// }

//    public function return(Request $request)
// {
//     $inputData = $request->all();
//     $vnp_HashSecret = config('vnpay.vnp_HashSecret');
//     $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';

//     unset($inputData['vnp_SecureHash']);
//     unset($inputData['vnp_SecureHashType']);

//     ksort($inputData);

//     // B3: Tạo hashData ĐÚNG chuẩn VNPAY (urlencode từng value)
//     $hashData = '';
//     foreach ($inputData as $key => $value) {
//         if (strpos($key, 'vnp_') === 0) { // Chỉ lấy vnp_
//             $hashData .= $key . '=' . urlencode($value) . '&';
//         }
//     }
//     $hashData = rtrim($hashData, '&'); // Xóa & cuối

//     // B4: Tạo chữ ký
//     $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);

//     // B5: So sánh
//     if ($secureHashCheck === $vnp_SecureHash) {
//         if ($inputData['vnp_ResponseCode'] == '00') {
//             return "Thanh toán thành công! Mã GD: " . ($inputData['vnp_TxnRef'] ?? '');
//         }
//         return "Thanh toán thất bại! Mã lỗi: " . ($inputData['vnp_ResponseCode'] ?? '');
//     }

//     return "Chữ ký không hợp lệ!";
// }


    public function getOrdersByUser($id)
    {
        $donhangs = DonHang::with('chiTietDonHang.sanpham')
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($d) {
                return [
                    'id' => $d->id,
                    'code' => 'DH' . str_pad($d->id, 5, '0', STR_PAD_LEFT),
                    'created_at' => $d->created_at,
                    'status' => $d->trang_thai,
                    'total_price' => $d->tong_tien,

                    'ten_khachhang' => $d->ten_khachhang,
                    'email' => $d->email,
                    'sdt' => $d->sdt,
                    'diachi' => $d->diachi,
                    'phuong_thuc_thanh_toan' => $d->phuong_thuc_thanh_toan,

                    'chitiet' => $d->chiTietDonHang->map(function ($ct) {
                        return [
                            'id' => $ct->id,
                            'product_name' => $ct->sanpham->tensp ?? 'Sản phẩm đã xoá',
                            'thumbnail' => $ct->sanpham->anhdaidien ?? null,
                            'don_gia' => $ct->don_gia,
                            'so_luong' => $ct->so_luong,
                            'thanh_tien' => $ct->don_gia * $ct->so_luong,
                        ];
                    }),
                ];
            });

        return response()->json($donhangs);
    }


    public function getOrderDetail($id)
    {
        $donhang = DonHang::with(['chiTietDonHang.sanpham'])->findOrFail($id);

        return response()->json([
            'id' => $donhang->id,
            'code' => 'DH' . str_pad($donhang->id, 5, '0', STR_PAD_LEFT),
            'created_at' => $donhang->created_at,
            'status' => $donhang->trang_thai,
            'total_price' => $donhang->tong_tien,

            'ten_khachhang' => $donhang->ten_khachhang,
            'email' => $donhang->email,
            'sdt' => $donhang->sdt,
            'diachi' => $donhang->diachi,
            'phuong_thuc_thanh_toan' => $donhang->phuong_thuc_thanh_toan,

            'chitiet' => $donhang->chiTietDonHang->map(function ($ct) {
                return [
                    'id' => $ct->id,
                    'gia' => $ct->don_gia,
                    'soluong' => $ct->so_luong,
                    'thanhtien' => $ct->thanh_tien,
                    'sanpham' => [
                        'masp' => $ct->sanpham->masp,
                        'tensp' => $ct->sanpham->tensp,
                        'anhdaidien' => $ct->sanpham->anhdaidien,
                        'mota' => $ct->sanpham->mota,
                        'giamoi' => $ct->sanpham->giamoi,
                    ]
                ];
            }),
        ]);
    }
    
}
