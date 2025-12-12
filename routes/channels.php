<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    // Admin được vào mọi kênh
    if ($user && $user->loaiTK == 1) {
        return true;
    }

    // Khách chỉ vào được kênh của mình
    return (int) $user->id === (int) $userId;
});