<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
       public function index()
    {
        return response()->json(DanhMuc::all());
    }

    // ✅ Lấy chi tiết danh mục
    public function show($id)
    {
        $danhMuc = DanhMuc::find($id);

        if (!$danhMuc) {
            return response()->json(['message' => 'Không tìm thấy danh mục'], 404);
        }

        return response()->json($danhMuc);
    }



    // 🟢 Lấy sản phẩm theo danh mục
    public function getSanphamByDanhmuc($id)
    {
        $sanPhams = SanPham::where('danhmuc_id', $id)->get();

        if ($sanPhams->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm.'], 404);
        }

        return response()->json($sanPhams);
    }

    // 🟢 Thêm danh mục (có hỗ trợ upload ảnh)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tendanhmuc' => 'required|string|max:255',
            'mota' => 'nullable|string',
            'hinhanh' => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('public/img', $fileName);
            $validated['hinhanh'] = $fileName;
        }

        $danhMuc = DanhMuc::create($validated);

        return response()->json([
            'message' => '✅ Tạo danh mục thành công!',
        ], 201);
    }

    // 🟡 Cập nhật danh mục
 public function update(Request $request, $id)
{
    $danhMuc = DanhMuc::find($id);

    if (!$danhMuc) {
        return response()->json(['message' => 'Không tìm thấy danh mục'], 404);
    }

    $validated = $request->validate([
        'tendanhmuc' => 'sometimes|string|max:255|unique:danhmuc,tendanhmuc,' . $id,
        'mota' => 'nullable|string',
        'hinhanh' => 'nullable|file|image|max:2048',
    ]);

    // 🟢 Nếu có file mới → upload và cập nhật
    if ($request->hasFile('hinhanh')) {
        $file = $request->file('hinhanh');
        $fileName =$file->getClientOriginalName(); // đặt tên tránh trùng
        $file->storeAs('public/img', $fileName);
        $validated['hinhanh'] = $fileName;

        // ❌ Nếu có ảnh cũ thì xóa để tránh rác
        if ($danhMuc->hinhanh && \Storage::exists('public/img/' . $danhMuc->hinhanh)) {
            \Storage::delete('public/img/' . $danhMuc->hinhanh);
        }
    } else {
        // 🚫 Không có file mới → giữ nguyên ảnh cũ
        unset($validated['hinhanh']);
    }

    $danhMuc->update($validated);

    return response()->json([
        'message' => '✅ Cập nhật danh mục thành công!',
    ]);
}   

    // 🟥 Xóa danh mục
    public function destroy($id)
    {
        $danhMuc = DanhMuc::find($id);

        if (!$danhMuc) {
            return response()->json(['message' => 'Không tìm thấy danh mục'], 404);
        }

        $danhMuc->delete();

        return response()->json(['message' => '🗑️ Xóa danh mục thành công!']);
    }
}
