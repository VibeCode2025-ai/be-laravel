<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotification;
class GoogleController extends Controller
{
public function loginWithGoogle()
{
    try {
        $idToken = request()->token;

        // Xác thực token Google
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->userFromToken($idToken);

        // Tạo hoặc tìm user
        $user = TaiKhoan::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'fullname'  => $googleUser->name ?? '',
                'username'  => $googleUser->email,
                'password'  => bcrypt(uniqid()),
                'hoatdong'  => 1,
                'loaiTK'    => 2,
                'trangthai' => 1,
            ]
        );

        // Cập nhật trạng thái hoạt động
        $user->hoatdong = 1;
        $user->save();

        // Gửi email thông báo đăng nhập
        try {
            if ($user->email) {
                Mail::to($user->email)->send(new LoginNotification($user));
            }
        } catch (\Exception $mailError) {
            \Log::error("Email login (Google) failed: " . $mailError->getMessage());
        }

        // Tạo token Sanctum
        $token = $user->createToken('google_api_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);

    } catch (\Exception $e) {
        \Log::error("Google login failed: " . $e->getMessage());

        return response()->json([
            'error' => 'Invalid Google token'
        ], 401);
    }
}

}
