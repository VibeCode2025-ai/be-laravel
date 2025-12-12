<?php

namespace App\Http\Controllers;

use App\Models\SlideShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SlideShowController extends Controller
{
    public function index()
    {
        return response()->json(Slideshow::all());
    }

    public function show($STT)
    {
        $slide = Slideshow::find($STT);
        if (! $slide) {
            return response(null, 404);
        }

        return response()->json($slide);
    }

    // POST /api/slideshow
    public function store(Request $request)
    {
        $request->validate([
            'tenfile' => 'required|image|mimes:jpg,jpeg,png,webp|max:5048',
            'trangthai' => 'required|boolean',
        ]);

        $file = $request->file('tenfile');
        $filename = $file->getClientOriginalName();

        // Lưu vào storage/app/public/img → ra ngoài là public/storage/img
        $file->storeAs('img', $filename, 'public');

        $slide = SlideShow::create([
            'tenfile' => $filename,
            'trangthai' => $request->trangthai,
        ]);

        return response()->json($slide, 201);
    }

    // PUT/PATCH /api/slideshow/{id}
    public function update(Request $request, $STT)
    {
        $slide = SlideShow::find($STT);

        if (! $slide) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        $dataUpdate = [];

        // Nếu có thay ảnh
        if ($request->hasFile('tenfile')) {
            $request->validate([
                'tenfile' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
            ]);

            // Xóa ảnh cũ
            if ($slide->tenfile) {
                Storage::disk('public')->delete('img/'.$slide->tenfile);
            }

            $file = $request->file('tenfile');
            $filename = $file->getClientOriginalName();

            $file->storeAs('img', $filename, 'public');
            $dataUpdate['tenfile'] = $filename;
        }

        // Cập nhật trạng thái nếu có gửi lên
        if ($request->has('trangthai')) {
            $dataUpdate['trangthai'] = $request->trangthai;
        }

        $slide->update($dataUpdate);

        return response()->json($slide);
    }

    // DELETE /api/slideshow/{id}
    public function destroy($STT)
    {
        $slide = SlideShow::find($STT);

        if (! $slide) {
            return response()->json(['message' => 'Không tìm thấy'], 404);
        }

        // Xóa file ảnh
        if ($slide->tenfile) {
            Storage::disk('public')->delete('img/'.$slide->tenfile);
        }

        $slide->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
