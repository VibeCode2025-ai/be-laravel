<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'nha_cung_cap';

    protected $fillable = [
        'ten',
        'email',
        'sdt',
        'dia_chi',
        'ghi_chu',
    ];

    // Quan hệ với kho_detail
    public function khoDetails()
    {
        return $this->hasMany(\App\Models\KhoDetail::class, 'id_ncc', 'id');
    }
}
