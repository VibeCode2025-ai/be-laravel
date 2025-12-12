<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
    protected $table = 'danhmuc';

   protected $fillable = [
    'tendanhmuc',
    'mota',
    'hinhanh',
];

   
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'danhmuc_id');
    }
}
