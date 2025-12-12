<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\Kho;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    // ✅ Danh sách đơn hàng
    public function index()
    {
        $donhang = DonHang::with([
            'chiTietDonHang.sanpham' => function ($query) {
                $query->select('masp', 'tensp', 'anhdaidien');
            }
        ])
        ->select(
            'id',
            'ten_khachhang',
            'sdt',
            'tong_tien',
            'phuong_thuc_thanh_toan',
            'trang_thai',
            'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return response()->json($donhang);
    }

    // ✅ Chi tiết đơn hàng
    public function show($id)
    {
        $donhang = DonHang::with([
            'chiTietDonHang.sanpham' => function ($query) {
                $query->select('masp', 'tensp', 'anhdaidien');
            }
        ])
        ->select(
            'id',
            'ten_khachhang',
            'email',
            'sdt',
            'diachi',
            'tong_tien',
            'phuong_thuc_thanh_toan',
            'ghi_chu',
            'trang_thai',
            'created_at'
        )
        ->findOrFail($id);

        return response()->json($donhang);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
    'trang_thai' => 'required|in:chờ xử lý,đã xác nhận,đang giao,đã hoàn thành,đã hủy'
]);
        $donhang = DonHang::with('chiTietDonHang')->find($id);

        if (!$donhang) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng'], 404);
        }

        $old = mb_strtolower(trim($donhang->trang_thai));
        $new = mb_strtolower(trim($request->trang_thai));

        if ($old !== 'đã xác nhận' && $new === 'đã xác nhận') {

            DB::beginTransaction();

            try {
              foreach ($donhang->chiTietDonHang as $item) {

    $kho = Kho::where('id_sanpham', $item->sanpham_id)
        ->lockForUpdate()
        ->first();

    if (!$kho) {
        DB::rollBack();
        return response()->json([
            'error' => "Sản phẩm ID {$item->sanpham_id} chưa có trong kho"
        ], 422);
    }

    if ($kho->soluong_ton < $item->so_luong) {
        DB::rollBack();
        return response()->json([
            'error' => "Không đủ tồn kho cho sản phẩm ID {$item->sanpham_id} để xử lý đơn"
        ], 422);
    }

    $kho->soluong_ton   -= $item->so_luong;
    $kho->soluong_daban += $item->so_luong;
    $kho->save();
}

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Lỗi xử lý tồn kho'], 500);
            }
        }

        // ✅ Cập nhật trạng thái đơn
        $donhang->trang_thai = $new;
        $donhang->save();

        return response()->json([
            'message' => 'Cập nhật trạng thái thành công!',
            'data' => $donhang->only('id', 'trang_thai')
        ]);
    }
    public function getByUser($userId)
{
    return DonHang::where('user_id', $userId)
        ->select('id', 'tong_tien', 'trang_thai', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();
}
}

