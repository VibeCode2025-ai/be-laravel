<?php

namespace App\Http\Controllers;

use App\Models\ChuyenMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class ChuyenMucController extends Controller
{
    // ✅ Lấy tất cả chuyên mục
    public function index()
    {
        return response()->json(ChuyenMuc::all());
    }

    // ✅ Lấy 1 chuyên mục
    public function show(ChuyenMuc $chuyenmuc)
    {
        return response()->json($chuyenmuc);
    }

    // ✅ Lấy sản phẩm theo chuyên mục
    public function getSanPhamByChuyenMuc($id)
    {
        $sanPhams = SanPham::where('chuyenmuc_id', $id)->get();

        if ($sanPhams->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy sản phẩm.'
            ], 404);
        }

        return response()->json($sanPhams);
    }

  public function store(Request $request)
{
    $request->validate([
        'tenchuyenmuc' => 'required|string|max:255',
    ]);

    $cm = ChuyenMuc::create([
        'tenchuyenmuc' => $request->tenchuyenmuc,
        'trangthai' => 1,
    ]);

    return response()->json(['message' => 'Thêm thành công', 'data' => $cm]);
}

public function update(Request $request, $id)
{
    $cm = ChuyenMuc::findOrFail($id);

    $cm->update([
        'tenchuyenmuc' => $request->tenchuyenmuc,
    ]);

    return response()->json(['message' => 'Cập nhật thành công']);
}

public function destroy($id)
{
    ChuyenMuc::findOrFail($id)->delete();
    return response()->json(['message' => 'Xóa thành công']);
}
}
