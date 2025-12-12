<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    // 🔗 Tên bảng tương ứng
    protected $table = 'chitiet_donhang';

    // 🔑 Khóa chính
    protected $primaryKey = 'id';

    // ⏱️ Cho phép timestamps
    public $timestamps = true;

    // 🔐 Các trường có thể gán giá trị hàng loạt (mass assignable)
    protected $fillable = [
        'donhang_id',
        'sanpham_id',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    // 🔁 Mối quan hệ: Chi tiết đơn hàng thuộc về 1 đơn hàng
    public function donhang()
    {
        return $this->belongsTo(DonHang::class, 'donhang_id', 'id');
    }

    // 🔁 Mối quan hệ: Chi tiết đơn hàng thuộc về 1 sản phẩm
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id', 'masp');
    }
}
