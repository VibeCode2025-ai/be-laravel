<?php

namespace App\Http\Controllers;

use App\Models\KhoDetail;
use App\Models\Kho;
use Illuminate\Http\Request;

class KhoDetailController extends Controller
{
    public function index()
    {
        $data = KhoDetail::with(['sanpham', 'nhacungcap'])
            ->orderByDesc('id')
            ->get();

        return response()->json($data);
    }

    public function show($id)
    {
        $row = KhoDetail::with(['sanpham', 'nhacungcap'])->findOrFail($id);
        return response()->json($row);
    }

    public function nhapKhoChiTiet(Request $request)
    {
        $validated = $request->validate([
            'masp' => 'required|exists:sanpham,masp',
            'id_ncc' => 'nullable|exists:nha_cung_cap,id',
            'soluong_nhap' => 'required|integer|min:1',
            'gia_mua' => 'nullable|numeric|min:0',
            'ngay_san_xuat' => 'nullable|date',
            'han_su_dung' => 'nullable|date',
            'ngay_bao_hanh' => 'nullable|date',
            'han_bao_hanh' => 'nullable|date',
            'ghi_chu' => 'nullable|string',
        ]);

        $lot = KhoDetail::create([
            'masp' => $validated['masp'],
            'id_ncc' => $validated['id_ncc'] ?? null,
            'soluong_nhap' => $validated['soluong_nhap'],
            'gia_mua' => $validated['gia_mua'] ?? 0,
            'ngay_san_xuat' => $validated['ngay_san_xuat'] ?? null,
            'ngay_bao_hanh' => $validated['ngay_bao_hanh'] ?? null,
            'han_bao_hanh' => $validated['han_bao_hanh'] ?? null,
            'ghi_chu' => $validated['ghi_chu'] ?? null,
        ]);

        $kho = Kho::firstOrCreate(
            ['id_sanpham' => $validated['masp']],
            ['soluong_nhap' => 0, 'soluong_ton' => 0, 'soluong_daban' => 0]
        );

        $kho->soluong_nhap += $validated['soluong_nhap'];
        $kho->soluong_ton  += $validated['soluong_nhap'];
        $kho->save();

        // 3️⃣ Trả về kết quả
        return response()->json([
            'lot' => $lot->fresh(['sanpham', 'nhacungcap']),
            'kho_tong' => $kho
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $row = KhoDetail::findOrFail($id);

        $validated = $request->validate([
            'id_ncc' => 'nullable|exists:nha_cung_cap,id',
            'soluong_nhap' => 'nullable|integer|min:0',
            'gia_mua' => 'nullable|numeric|min:0',
            'ngay_san_xuat' => 'nullable|date',
            'ngay_bao_hanh' => 'nullable|date',
            'han_bao_hanh' => 'nullable|date',
            'ghi_chu' => 'nullable|string',
        ]);

        if (isset($validated['soluong_nhap'])) {
            $diff = $validated['soluong_nhap'] - $row->soluong_nhap;
            $kho = Kho::firstOrCreate(
                ['id_sanpham' => $row->masp],
                ['soluong_nhap' => 0, 'soluong_ton' => 0, 'soluong_daban' => 0]
            );

            $kho->soluong_nhap += $diff;
            $kho->soluong_ton  += $diff;
            $kho->save();
        }

        $row->update($validated);

        return response()->json($row);
    }

    public function destroy($id)
    {
        $row = KhoDetail::findOrFail($id);

        $kho = Kho::firstOrCreate(
            ['id_sanpham' => $row->masp],
            ['soluong_nhap' => 0, 'soluong_ton' => 0, 'soluong_daban' => 0]
        );

        $kho->soluong_nhap -= $row->soluong_nhap;
        $kho->soluong_ton  -= $row->soluong_nhap;
        $kho->save();

        $row->delete();

        return response()->json(['message' => 'Đã xoá lô kho']);
    }

    public function getByProduct($masp)
    {
        $data = KhoDetail::with(['sanpham', 'nhacungcap'])
            ->where('masp', $masp)
            ->orderByDesc('id')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Không có chi tiết kho'], 404);
        }

        return response()->json($data);
    }
}
