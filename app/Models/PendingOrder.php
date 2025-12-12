<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    protected $fillable = ['txn_ref', 'data', 'expires_at'];
    protected $casts = [
        'data' => 'array',
        'expires_at' => 'datetime',
    ];
}