<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;
class Kho extends Model
{
    use HasFactory;

    protected $table = 'kho';

    protected $primaryKey = 'id';
    public $timestamps = true; 

    protected $fillable = [
        'id_sanpham',
        'soluong_nhap',
        'soluong_ton',
        'soluong_daban',
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'id_sanpham', 'masp');
    }
}
