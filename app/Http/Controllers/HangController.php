<?php

namespace App\Http\Controllers;
use App\Models\Hang;
use App\Models\DanhMuc;
use App\Models\Sanpham;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HangController extends Controller
{
     public function index()
    {
        $hangs = Hang::all();
        return response()->json($hangs);
    }

    public function show($id)
    {
        $hang = Hang::find($id);
        if (!$hang) {
            return response()->json(['message' => 'Không tìm thấy hãng'], 404);
        }

        return response()->json($hang);
    }

    
    public function getSanPhamByHang($hang){
        $sanPhams = SanPham::where('hang_id', $hang)->get();
         if ($sanPhams->isEmpty()) {
        return response()->json([
            'message' => 'Không tìm thấy sản phẩm.'
        ], 404);
    }
        return response()->json($sanPhams);
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'tenhang' => 'required|string|max:255|unique:hang,tenhang',
        'hinhanh' => 'nullable|file|image|max:2048',
    ]);

    if ($request->hasFile('hinhanh')) {
        $file = $request->file('hinhanh');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/img', $fileName);
        $validated['hinhanh'] = $fileName;
    } else {
        $validated['hinhanh'] = null;
    }

    $hang = Hang::create($validated);

    return response()->json([
        'message' => '✅ Tạo hãng thành công!',
        'data' => $hang,
    ], 201);
}

public function update(Request $request, $id)
{
    $hang = Hang::find($id);

    if (!$hang) {
        return response()->json(['message' => 'Không tìm thấy hãng'], 404);
    }

    $validated = $request->validate([
        'tenhang' => 'sometimes|string|max:255|unique:hang,tenhang,' . $id,
        'hinhanh' => 'nullable|file|image|max:2048',
    ]);

    if ($request->hasFile('hinhanh')) {
        if ($hang->hinhanh && Storage::exists('public/img/' . $hang->hinhanh)) {
            Storage::delete('public/img/' . $hang->hinhanh);
        }

        $file = $request->file('hinhanh');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/img', $fileName);
        $validated['hinhanh'] = $fileName;
    }

    $hang->update($validated);

    return response()->json([
        'message' => '✅ Cập nhật hãng thành công!',
        'data' => $hang,
    ]);
}

    //  Xóa hãng
    public function destroy($id)
    {
        $hang = Hang::find($id);

        if (!$hang) {
            return response()->json(['message' => 'Không tìm thấy hãng'], 404);
        }

        $hang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa hãng thành công!',
        ]);
    }

}
