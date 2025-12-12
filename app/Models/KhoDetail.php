<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;
use App\Models\NhaCungCap;
class KhoDetail extends Model
{
    use HasFactory;

    protected $table = 'kho_detail';

    protected $fillable = [
        'masp',
        'id_ncc',
        'soluong_nhap',
        'gia_mua',
        'ngay_san_xuat',
        'ngay_bao_hanh',
        'han_bao_hanh',
        'ghi_chu',
    ];

    // Quan hệ với sản phẩm
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'masp', 'masp');
    }

    // Quan hệ với nhà cung cấp
    public function nhacungcap()
    {
        return $this->belongsTo(NhaCungCap::class, 'id_ncc', 'id');
    }
}
