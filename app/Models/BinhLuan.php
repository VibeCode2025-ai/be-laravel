<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    use HasFactory;

    protected $table = 'binhluan';

    protected $fillable = ['sanpham_id', 'user_id', 'noidung'];

    public function user()
    {
        return $this->belongsTo(TaiKhoan::class, 'user_id', 'id');
    }

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id', 'masp');
    }
}
