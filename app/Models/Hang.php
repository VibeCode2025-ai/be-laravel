<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hang extends Model
{
    use HasFactory;

    protected $table = 'hang';

    protected $fillable = [
        'tenhang',
        'hinhanh'
    ];


    
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'hang_id');
    }
}
