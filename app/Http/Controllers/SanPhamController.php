<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SanPhamController extends Controller
{
   public function index()
    {
        $products = SanPham::with([
            'danhmuc:id,tendanhmuc',
            'hang:id,tenhang',
            'Chuyenmuc:id,tenchuyenmuc'
        ])->get();

        return response()->json($products);
    }

    /**
     * ✅ Lấy chi tiết 1 sản phẩm
     */
    public function show($id)
    {
        $product = SanPham::with(['danhmuc', 'hang', 'Chuyenmuc'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        return response()->json($product);
    }

public function store(Request $request)
{
    $validatedData = $request->validate([
        'tensp' => 'required|string|max:255',
        'anhdaidien' => 'nullable|file|image|max:2048',
        'mota' => 'nullable|string',
        'giamoi' => 'required|numeric',
        'giacu' => 'required|numeric',
        'trangthai' => 'required|boolean',
        'hang_id' => 'required|exists:hang,id',
        'danhmuc_id' => 'required|exists:danhmuc,id',
        'chuyenmuc_id' => 'nullable|exists:chuyenmuc,id',
    ]);

    // ✅ Xử lý upload file
    if ($request->hasFile('anhdaidien')) {
        $file = $request->file('anhdaidien');

        // ✅ Lấy tên file gốc (giữ nguyên tên)
        $fileName = $file->getClientOriginalName();

        // ✅ Lưu file vào storage/app/public/img
        $file->storeAs('public/img', $fileName);

        // ✅ Gán vào validatedData
        $validatedData['anhdaidien'] = $fileName;
    }

    $sanPham = SanPham::create($validatedData);

    return response()->json([
        'message' => 'Thêm sản phẩm thành công!',
        'data' => $sanPham
    ], 201);
}

   
      // Cập nhật sản phẩm
   public function update(Request $request, $id)
{
    $sanPham = SanPham::find($id);

    if (!$sanPham) {
        return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
    }

    // ✅ Validation chính xác
    $validatedData = $request->validate([
        'tensp' => 'sometimes|string|max:255',
        'mota' => 'nullable|string',
        'giamoi' => 'nullable|numeric',
        'giacu' => 'nullable|numeric',
        'trangthai' => 'nullable|boolean',
        'hang_id' => 'nullable|exists:hang,id',
        'danhmuc_id' => 'nullable|exists:danhmuc,id',
        'chuyenmuc_id' => 'nullable|exists:chuyenmuc,id',
        'anhdaidien' => 'nullable|file|image|max:2048',
    ]);

    // ✅ Upload ảnh mới (nếu có)
    if ($request->hasFile('anhdaidien')) {
        $file = $request->file('anhdaidien');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/img', $fileName);
        $validatedData['anhdaidien'] = $fileName;
    }

    // ✅ Cập nhật dữ liệu
    $sanPham->update($validatedData);

    return response()->json([
        'message' => '✅ Cập nhật sản phẩm thành công!',
        'data' => $sanPham
    ]);
}

    // Xóa sản phẩm
    public function destroy($id)
    {
        $sanPham = SanPham::find($id);

        if (!$sanPham) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        $sanPham->delete();

        return response()->json(['message' => 'Xóa sản phẩm thành công!']);
    }


    //search sản phẩm
  public function search(Request $request)
{
    $query = trim($request->input('query', ''));
    if ($query === '') {
        return response()->json([]);
    }

    $normalizedQuery = $this->normalizeString($query);

    $products = SanPham::all();

    // ✅ Lọc theo tên hoặc chữ cái đầu
    $results = $products->filter(function ($product) use ($normalizedQuery) {
        $name = $this->normalizeString($product->tensp);
        $initials = $this->getInitials($product->tensp);

        return Str::contains($name, $normalizedQuery) ||
               Str::startsWith($initials, $normalizedQuery);
    });

    // ✅ Nếu người dùng chỉ nhập 1 ký tự → ưu tiên thương hiệu bắt đầu bằng chữ đó
    if (mb_strlen($normalizedQuery) === 1) {
        $results = $results->sortBy(function ($product) use ($normalizedQuery) {
            $brand = $this->normalizeString($product->hangsx ?? '');
            $name = $this->normalizeString($product->tensp);

            // Nếu tên hoặc hãng bắt đầu bằng chữ cái nhập vào → ưu tiên lên đầu
            if (Str::startsWith($brand, $normalizedQuery) || Str::startsWith($name, $normalizedQuery)) {
                return 0; // Ưu tiên
            }
            return 1; // Bình thường
        })->values();
    }

    return response()->json($results->values());
}
    private function getInitials($str)
{
    // Bỏ dấu và chuẩn hóa
    $normalized = $this->normalizeString($str);

    // Lấy chữ cái đầu của từng từ
    $words = explode(' ', $normalized);
    $initials = '';
    foreach ($words as $w) {
        if ($w !== '') {
            $initials .= $w[0];
        }
    }

    return $initials;
}
    /**
     * Chuẩn hóa chuỗi: bỏ dấu, bỏ khoảng thừa, chuyển lowercase
     */
    private function normalizeString($str)
    {
        $str = mb_strtolower(trim($str));
        $str = preg_replace('/\s+/', ' ', $str); // gộp khoảng trắng
        $unicode = [
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        ];

        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/($accent)/u", $nonAccent, $str);
        }

        return $str;
    }
    
}