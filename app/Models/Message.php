<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Bảng
    protected $table = 'messages'; // Rõ ràng hơn

    // Tắt timestamps nếu không dùng
    public $timestamps = true; // hoặc false nếu không có cột

    // Cho phép mass assignment
    protected $fillable = [
        'user_id',
        'message',
        'is_admin',
    ];

    // Cast kiểu dữ liệu
    protected $casts = [
        'is_admin' => 'boolean',
        'created_at' => 'datetime:H:i d/m',
        'updated_at' => 'datetime:H:i d/m',
    ];

    // Quan hệ với TaiKhoan (không phải User)
    public function user()
    {
        return $this->belongsTo(TaiKhoan::class, 'user_id', 'id');
    }

    // Tự động thêm tên người gửi (rất cần cho frontend)
    protected $appends = ['user_name'];

    public function getUserNameAttribute()
    {
        return $this->user?->fullname 
            ?? $this->user?->username 
            ?? "User #{$this->user_id}";
    }

    // (Tùy chọn) Format tin nhắn ngắn
    public function getShortMessageAttribute()
    {
        return \Str::limit($this->message, 50);
    }
}