<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // ⚡ 1. Tổng doanh thu
        $tongDoanhThu = DonHang::where('trang_thai', 'đã xác nhận')
            ->sum('tong_tien');

        $tongDonHang = DonHang::count();

        $nguoiDungMoi = TaiKhoan::where('loaiTK', 'user')
            ->where('hoatdong', 1)
            ->where('trangthai', 1)
            ->count();

        $sanPhamBanChay = ChiTietDonHang::select(
            'sanpham_id',
            DB::raw('SUM(so_luong) as tong_ban'),
            DB::raw('SUM(thanh_tien) as doanh_thu')
        )
            ->with(['sanpham:masp,tensp,anhdaidien,giamoi'])
            ->groupBy('sanpham_id')
            ->orderByDesc('tong_ban')
            ->take(5)
            ->get();

        return response()->json([
            'doanh_thu' => $tongDoanhThu,
            'tong_don_hang' => $tongDonHang,
            'nguoi_dung_moi' => $nguoiDungMoi,
            'san_pham_ban_chay' => $sanPhamBanChay,
        ]);
    }

    // Biểu đồ doanh thu theo tháng
    public function revenueByMonth()
    {
        $data = DonHang::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(tong_tien) as total')
        )
            ->where('trang_thai', 'đã xác nhận')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($data);
    }
}
