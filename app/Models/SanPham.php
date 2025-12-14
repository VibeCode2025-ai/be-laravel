<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
      use HasFactory;

    protected $table = 'sanpham';
    protected $primaryKey = 'masp';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'tensp', 'anhdaidien', 'chuyenmuc_id', 'mota','hang_id','danhmuc_id',
        'hinhanhkhac1','thongso', 'giamoi', 'giacu', 'trangthai'
    ];
    public function hang()
    { 
        return $this->belongsTo(Hang::class, 'hang_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danhmuc_id');
    }
     public function ChuyenMuc()
    {
        return $this->belongsTo(ChuyenMuc::class, 'chuyenmuc_id');
    }
    

    public function chiTietDonHang()
    {
        return $this->hasMany(CTDH::class, 'sanpham_id', 'masp');
    }

protected $casts = [
    'giamoi' => 'decimal:2',
    'giacu' => 'decimal:2',
];
}
