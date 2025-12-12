<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Lấy danh sách tài khoản
    public function index()
    {
        $users = TaiKhoan::select('id', 'username', 'fullname', 'email', 'sdt', 'diachi', 'hoatdong', 'loaiTK', 'trangthai')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($users);
    }

    public function show($id)
    {
        $user = TaiKhoan::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy tài khoản'], 404);
        }

        return response()->json($user);
    }



    // Cập nhật tài khoản
    public function update(Request $request, $id)
    {
        $user = TaiKhoan::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy tài khoản'], 404);
        }

        $user->update([
            'fullname' => $request->fullname ?? $user->fullname,
            'email' => $request->email ?? $user->email,
            'sdt' => $request->sdt ?? $user->sdt,
            'diachi' => $request->diachi ?? $user->diachi,
            'loaiTK' => $request->loaiTK ?? $user->loaiTK,
            'trangthai' => $request->trangthai ?? $user->trangthai,
        ]);

        return response()->json(['message' => 'Cập nhật tài khoản thành công']);
    }

    // Admin đổi mật khẩu
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = TaiKhoan::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy tài khoản'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Thay đổi mật khẩu thành công']);
    }

    // Xóa tài khoản
    public function destroy($id)
    {
        $user = TaiKhoan::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy tài khoản'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Xóa tài khoản thành công']);
    }
}