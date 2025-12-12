<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'target_user_id' => 'required_if:is_admin,1|integer', // Bắt buộc nếu là admin
        ]);

        $authUser = auth('sanctum')->user();
        $isAdmin = $authUser && $authUser->loaiTK == 1;

        if ($isAdmin) {
            // Admin gửi tin CHO khách
            $userId = $request->target_user_id; // ID của khách
            $userName = 'Hỗ trợ'; // Không cần tên khách
        } else {
            // Khách gửi tin
            if ($authUser) {
                $userId = $authUser->id;
                $userName = $authUser->fullname;
            } else {
                $guestId = $request->user_id ?? null;
                $guest = $guestId ? TaiKhoan::find($guestId) : null;

                if (! $guest) {
                    $guest = TaiKhoan::create([
                        'username' => 'guest_'.Str::random(6),
                        'password' => bcrypt(Str::random(16)),
                        'fullname' => 'Khách vãng lai',
                        'email' => 'guest'.time().'@temp.com',
                        'hoatdong' => 1,
                        'trangthai' => 1,
                        'loaiTK' => 0,
                    ]);
                }
                $userId = $guest->id;
                $userName = $guest->fullname;
            }
        }

        $msg = Message::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_admin' => $isAdmin ? 1 : 0,
        ]);

        broadcast(new NewMessage($msg));

        return response()->json([
            'success' => true,
            'message' => $msg->load('user'),
            'user_id' => $userId,
            'user_name' => $isAdmin ? 'Hỗ trợ' : $userName,
        ]);
    }

    /**
     * Lấy toàn bộ tin nhắn theo user_id
     */
    public function getMessages($userId)
    {
        $messages = Message::where('user_id', $userId)
            ->with('user:id,fullname,username')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages->map(function ($msg) {
            $isAdmin = (bool) $msg->is_admin;

            return [
                'id' => $msg->id,
                'user_id' => $msg->user_id,
                'message' => $msg->message,
                'is_admin' => $isAdmin,
                'user_name' => $isAdmin
                    ? null
                    : ($msg->user?->fullname ?? "Khách #{$msg->user_id}"),
                'created_at' => $msg->created_at
                    ? $msg->created_at->format('H:i d/m')
                    : null, // Tránh Invalid Date
            ];
        }));
    }

    /**
     * Danh sách người dùng có tin nhắn + tin cuối + TÊN
     */
    public function getChatUsers()
    {
        // Chỉ lấy những user_id KHÔNG phải admin
        return Message::selectRaw('user_id, MAX(created_at) as max_created_at')
            ->where('is_admin', 0) // LOẠI BỎ TIN NHẮN ADMIN
            ->groupBy('user_id')
            ->orderByDesc('max_created_at')
            ->get()
            ->map(function ($row) {
                $user = TaiKhoan::find($row->user_id);
                $last = Message::where('user_id', $row->user_id)
                    ->where('is_admin', 0) // Chỉ lấy tin cuối của khách
                    ->orderBy('created_at', 'desc')
                    ->first();

                return [
                    'id' => $row->user_id,
                    'name' => $user?->fullname
                        ?? $user?->username
                        ?? "Khách #{$row->user_id}",
                    'last_message' => $last?->message ?? '',
                    'last_time' => $last?->created_at?->format('H:i d/m') ?? '',
                ];
            });
    }
}
