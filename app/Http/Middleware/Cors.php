<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $origin = $request->headers->get('origin');

        // DANH SÁCH DOMAIN ĐƯỢC PHÉP
        $allowedOrigins = [
            'http://localhost:3000',
            'http://127.0.0.1:3000',
            // Thêm domain production sau
        ];

        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); // BẮT BUỘC
        $response->headers->set('Vary', 'Origin'); // THÊM DÒNG NÀY

        return $response;
    }
}