<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\KhoDetail;
use App\Models\SanPham;
use App\Models\Kho;
use Illuminate\Http\Request;

class KhoController extends Controller
{
    // Danh sách tồn kho
 public function index()
{
    $data = Kho::with(['sanpham:masp,tensp,anhdaidien'])
        ->orderByDesc('id')
        ->get();

    return response()->json($data);
}
    // Xem 1 dòng
    public function show($id)
    {
        $row = Kho::with('sanpham:masp,tensp,anhdaidien')->findOrFail($id);
        return response()->json($row);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sanpham'   => 'required|exists:sanpham,masp',
            'soluong_nhap' => 'required|integer|min:0',
            'soluong_ton'  => 'required|integer|min:0',
        ]);

        if (Kho::where('id_sanpham', $validated['id_sanpham'])->exists()) {
            return response()->json(['message' => 'Sản phẩm đã có trong kho'], 422);
        }

        $validated['soluong_daban'] = 0;

        $row = Kho::create($validated);

        return response()->json($row, 201);
    }

    public function update(Request $request, $id)
    {
        $row = Kho::findOrFail($id);

        $validated = $request->validate([
            'soluong_nhap'  => 'nullable|integer|min:0',
            'soluong_ton'   => 'nullable|integer|min:0',
            'soluong_daban' => 'nullable|integer|min:0',
        ]);

        $row->update($validated);

        return response()->json($row);
    }

    // Xoá một dòng kho
    public function destroy($id)
    {
        $row = Kho::findOrFail($id);
        $row->delete();

        return response()->json(['message' => 'Đã xoá']);
    }

public function nhapKho(Request $request)
{
    $validated = $request->validate([
        'id_sanpham' => 'required|exists:sanpham,masp',
        'soluong_nhap' => 'required|integer|min:1',
        'id_ncc' => 'nullable|exists:nha_cung_cap,id', 
        'gia_mua' => 'nullable|numeric|min:0',
    ]);

    DB::transaction(function () use ($validated, &$kho) {

        $kho = Kho::firstOrCreate(
            ['id_sanpham' => $validated['id_sanpham']],
            ['soluong_nhap' => 0, 'soluong_ton' => 0, 'soluong_daban' => 0]
        );

        $qty = $validated['soluong_nhap'];
        $kho->soluong_nhap += $qty;
        $kho->soluong_ton  += $qty;
        $kho->save();

        $lot = KhoDetail::where('masp', $validated['id_sanpham'])
            ->where('soluong_ton', '>', 0)
            ->first();

        if ($lot) {
            $lot->soluong_nhap += $qty;
            $lot->soluong_ton   += $qty;
            if (isset($validated['gia_mua'])) $lot->gia_mua = $validated['gia_mua'];
            $lot->save();
        } else {
            KhoDetail::create([
                'masp' => $validated['id_sanpham'],
                'id_ncc' => $validated['id_ncc'] ?? null,
                'soluong_nhap' => $qty,
                'soluong_ton' => $qty,
                'gia_mua' => $validated['gia_mua'] ?? 0,
                'ngay_san_xuat' => now(),
                'ngay_bao_hanh' => now(),
                'han_bao_hanh' => now()->addYear(),
                'ghi_chu' => 'Tự động tạo từ kho tổng'
            ]);
        }
    });

    return response()->json(
        $kho->fresh('sanpham:masp,tensp,anhdaidien')
    );
}
public function getByProduct($masp)
{
    $row = Kho::where('id_sanpham', $masp)
        ->with('sanpham:masp,tensp,anhdaidien')
        ->first();

    if (!$row) {
        return response()->json(['message' => 'Không có kho'], 404);
    }

    return response()->json($row);
}
}
