<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class TaiKhoan extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'taikhoan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'fullname',
        'sdt',
        'diachi',
        'email',
        'hoatdong',
        'loaiTK',
        'trangthai',
    ];

    protected $hidden = [
        'password',
    ];

    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'user_id', 'id');
    }
}


