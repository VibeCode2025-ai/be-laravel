<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NhaCungCapController extends Controller
{
    /**
     * Danh sách nhà cung cấp
     */
    public function index()
    {
        return response()->json(NhaCungCap::all(), 200);
    }

    /**
     * Tạo nhà cung cấp mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'sdt' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string|max:500',
        ]);

        $ncc = NhaCungCap::create($validated);

        return response()->json([
            'message' => 'Tạo nhà cung cấp thành công',
            'data' => $ncc
        ], 201);
    }

    /**
     * Lấy thông tin 1 nhà cung cấp
     */
    public function show($id)
    {
        $ncc = NhaCungCap::find($id);

        if (!$ncc) {
            return response()->json(['message' => 'Không tìm thấy nhà cung cấp'], 404);
        }

        return response()->json($ncc, 200);
    }

    /**
     * Cập nhật nhà cung cấp
     */
    public function update(Request $request, $id)
    {
        $ncc = NhaCungCap::find($id);

        if (!$ncc) {
            return response()->json(['message' => 'Không tìm thấy nhà cung cấp'], 404);
        }

        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'sdt' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string|max:500',
        ]);

        $ncc->update($validated);

        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $ncc
        ], 200);
    }

    /**
     * Xóa nhà cung cấp
     */
    public function destroy($id)
    {
        $ncc = NhaCungCap::find($id);

        if (!$ncc) {
            return response()->json(['message' => 'Không tìm thấy nhà cung cấp'], 404);
        }

        $ncc->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
