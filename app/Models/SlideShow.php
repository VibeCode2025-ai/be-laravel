<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    use HasFactory;

    protected $table = 'slideshow';

    protected $primaryKey = 'STT';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'tenfile',
        'trangthai',
    ];
}
