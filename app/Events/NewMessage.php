<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->user_id);
    }

    public function broadcastAs()
    {
        return 'NewMessage'; // Không có dấu chấm
    }

  public function broadcastWith()
{
    return [
        'id' => $this->message->id,
        'user_id' => $this->message->user_id,
        'message' => $this->message->message,
        'is_admin' => (bool) $this->message->is_admin,
        'user_name' => $this->message->is_admin
            ? 'Hỗ trợ'
            : ($this->message->user?->fullname ?? "Khách #{$this->message->user_id}"),
        'created_at' => $this->message->created_at?->toISOString(), // ← SỬA TẠI ĐÂY
    ];
}
}