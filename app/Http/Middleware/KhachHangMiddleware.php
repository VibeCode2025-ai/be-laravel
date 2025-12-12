<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KhachHangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Bạn chưa đăng nhập'
            ], 401);
        }

        if ((int) $user->loaiTK !== 2) {
            return response()->json([
                'message' => 'Bạn không có quyền truy cập',
                'loaiTK' => $user->loaiTK
            ], 403);
        }

        return $next($request);
    }
}
