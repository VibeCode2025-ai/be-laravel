<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'donhang';
    protected $casts = [
    'tong_tien' => 'float',
];

    protected $fillable = [
        'user_id',
        'ten_khachhang',
        'email',
        'sdt',
        'diachi',
        'thanhpho',
        'huyen',
        'xa',
        'tong_tien',
        'phuong_thuc_thanh_toan',
        'ghi_chu',
        'trang_thai',
    ];

    /**
     * 🔗 Một đơn hàng thuộc về một người dùng
     */
    public function user()
    {
        return $this->belongsTo(TaiKhoan::class, 'user_id', 'id');
    }

    /**
     * 🔗 Một đơn hàng có nhiều chi tiết đơn hàng
     */
    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhang_id', 'id');
    }


}
