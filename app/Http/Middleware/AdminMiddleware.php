<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{  
  public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();
    if (!$user) {
        return response()->json(['message' => 'Không có user (chưa login hoặc token sai)'], 401);
    }

    if ((int)$user->loaiTK !== 1) {
        return response()->json(['message' => 'Bạn không có quyền (Admin only)', 'loaiTK' => $user->loaiTK], 403);
    }

    return $next($request);
}
}
