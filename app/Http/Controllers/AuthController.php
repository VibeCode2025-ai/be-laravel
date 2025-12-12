<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    // đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:taikhoan',
            'password' => 'required|min:6',
            'fullname' => 'required',
            'email' => 'required|email|unique:taikhoan',
            'sdt' => 'required|int|digits:10',
            'diachi' => 'required',
        ]);

        $user = TaiKhoan::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'sdt' => $request->sdt,
            'diachi' => $request->diachi,
            'email' => $request->email,
            'hoatdong' => 1,
            'loaiTK' => 2,
            'trangthai' => 1,
        ]);

        return response()->json([
            'message' => 'Đăng ký khách hàng thành công!',
            'user' => $user,
        ], 201);
    }

    // đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = TaiKhoan::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu'], 401);
        }

        $user->hoatdong = 1;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Chỉ validate các trường người dùng được phép chỉnh sửa
        $request->validate([
            'fullname' => 'nullable|string|max:255',
            'sdt' => 'nullable|string|max:10',
            'diachi' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:taikhoan,email,'.$user->username.',username',
        ]);

        // Lấy dữ liệu từ request (chỉ lấy các trường cần)
        $data = array_filter($request->only(['fullname', 'sdt', 'diachi', 'email']));

        // Nếu không có trường nào được gửi => báo lỗi
        if (empty($data)) {
            return response()->json([
                'message' => 'Không có thông tin nào được thay đổi.',
            ], 400);
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return response()->json([
            'message' => 'Cập nhật thông tin thành công',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            $user->hoatdong = 0;
            $user->save();

            return response()->json(['message' => 'Đăng xuất thành công']);
        }

        return response()->json(['message' => 'Không tìm thấy user'], 404);
    }
}
