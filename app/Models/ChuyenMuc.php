<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenMuc extends Model
{
    use HasFactory;
    protected $table = 'chuyenmuc';
    public $timestamps = false;
    protected $fillable = [
        'tenchuyenmuc',
        'trangthai',
    ];

    
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'chuyemuc_id');
    }
}
