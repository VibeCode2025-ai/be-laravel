<?php

namespace App\Http\Controllers;

use App\Models\BinhLuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinhLuanController extends Controller
{
    public function index()
    {
        return BinhLuan::with('user:id,fullname,username', 'sanpham:masp,tensp')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getByProduct($sanpham_id)
    {
        $comments = BinhLuan::with('user:id,fullname')
            ->where('sanpham_id', $sanpham_id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($comments);
    }

    // Thêm bình luận mới
    public function store(Request $request)
    {
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,masp',
            'noidung' => 'required|string',
        ]);

        $comment = BinhLuan::create([
            'user_id' => Auth::id(),
            'sanpham_id' => $request->sanpham_id,
            'noidung' => $request->noidung,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function destroy($id)
    {
        $comment = BinhLuan::find($id);

        if (! $comment) {
            return response()->json(['message' => 'Không tìm thấy bình luận'], 404);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Xóa bình luận thành công',
            'id' => $id,
        ]);
    }

    public function getByUser($userId)
    {
        $comments = BinhLuan::with('sanpham:id,tensp')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($comments);
    }

    public function getByUserAdmin($userId)
    {
        $comments = BinhLuan::with([
            'sanpham:masp,tensp',
            'user:id,fullname',
        ])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($comments);
    }
}
