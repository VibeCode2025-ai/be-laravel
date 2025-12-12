<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChuyenMucController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HangController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\KhoController;
use App\Http\Controllers\KhoDetailController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\SlideShowController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\VnPayController;
use App\Http\Controllers\NhaCungCapController;
use Illuminate\Support\Facades\Route;

// Đăng ký, đăng nhập,cập nhật, đăng xuất
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google', [GoogleController::class, 'loginWithGoogle']);
// khách hàng
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout', [KhachHangController::class, 'store']);
    Route::get('/checkout/user/{id}', [KhachHangController::class, 'getOrdersByUser']);
    Route::get('/checkout/detail/{id}', [KhachHangController::class, 'getOrderDetail']);
    // khách hàng bình luận
    Route::post('/comments', [BinhLuanController::class, 'store']);
    Route::post('/payment/vnpay/create', [VnPayController::class, 'createPayment']);

});
Route::get('/payment/vnpay/return', [VnPayController::class, 'return'])->middleware('web');
Route::get('/comments/{sanpham_id}', [BinhLuanController::class, 'getByProduct']);
Route::post('/chatbot', [ChatbotController::class, 'chat']);
// Sản phẩm
Route::get('/sanpham/search', [SanPhamController::class, 'search']);
Route::get('/sanpham', [SanPhamController::class, 'index']);
Route::get('/sanpham/{sanpham}', [SanPhamController::class, 'show'])
    ->name('sanpham.chitiet');
// index + menu
Route::get('/sanpham/chuyenmuc/{chuyenmuc}', [SanPhamController::class, 'getChuyenmuc']);
Route::get('/sanpham/hang/{hang}', [SanPhamController::class, 'getHang']);
Route::get('/sanpham/hang/{hang}', [SanPhamController::class, 'getHang']);
// Danh muc
Route::get('/danhmuc', [DanhMucController::class, 'index']);
Route::get('/danhmuc/{danhmuc}', [DanhMucController::class, 'show']);
Route::get('/danhmuc/sanpham/{danhmuc}', [DanhMucController::class, 'getSanphamByDanhmuc']);
// chuyen muc
Route::get('/chuyenmuc/sanpham/{chuyenmuc}', [ChuyenMucController::class, 'getSanPhamByChuyenMuc']);
Route::get('/chuyenmuc', [ChuyenMucController::class, 'index']);
Route::get('/chuyenmuc/{chuyenmuc}', [ChuyenMucController::class, 'show']);
// hãng
Route::get('/hang', [HangController::class, 'index']);
Route::get('/hang/{hang}', [HangController::class, 'show']);
Route::get('/hang/sanpham/{hang}', [HangController::class, 'getSanPhamByHang']);
Route::get('/hang/{hang}/danhmuc', [DanhMucController::class, 'getDanhMucByHang']);
// SlideShow
Route::get('/slideshow', [SlideShowController::class, 'index']);
Route::get('/slideshow/{STT}', [SlideShowController::class, 'show']);
// kho
Route::get('/chat/users', [ChatController::class, 'getChatUsers']);
Route::get('/messages/{userId}', [ChatController::class, 'getMessages']);
Route::post('/send', [ChatController::class, 'send']);
// kho
Route::get('/kho', [KhoController::class, 'index']);
Route::get('/kho/{id}', [KhoController::class, 'show']);
Route::get('/kho/sp/{masp}', [KhoController::class, 'getByProduct']);

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/themhang', [HangController::class, 'store']);
    Route::put('/updatehang/{id}', [HangController::class, 'update']);
    Route::delete('/xoahang/{id}', [HangController::class, 'destroy']);

    Route::post('/themchuyenmuc', [ChuyenMucController::class, 'store']);
    Route::put('/updatechuyenmuc/{id}', [ChuyenMucController::class, 'update']);
    Route::delete('/xoachuyenmuc/{id}', [ChuyenMucController::class, 'destroy']);

    Route::post('/themdanhmuc', [DanhMucController::class, 'store']);
    Route::put('/updatedanhmuc/{id}', [DanhMucController::class, 'update']);
    Route::delete('/xoadanhmuc/{id}', [DanhMucController::class, 'destroy']);

    Route::post('/sanpham', [SanPhamController::class, 'store']);
    Route::put('/updatesanpham/{id}', [SanPhamController::class, 'update']);
    Route::delete('/xoasanpham/{id}', [SanPhamController::class, 'destroy']);

    // Bình luận
    Route::get('/comments', [BinhLuanController::class, 'index']);
    Route::put('/comments/{id}/status', [BinhLuanController::class, 'updateStatus']);
    Route::delete('/comments/xoa/{id}', [BinhLuanController::class, 'destroy']);
    Route::get('/comments/user/{userId}', [BinhLuanController::class, 'getByUserAdmin']);
    // don hang
    Route::get('/donhang', [DonHangController::class, 'index']);
    Route::get('/donhang/{id}', [DonHangController::class, 'show']);
    Route::put('/donhang/{id}/status', [DonHangController::class, 'updateStatus']);
    // nha cung cap
    Route::get('/nhacungcap', [NhaCungCapController::class, 'index']);
    Route::post('/nhacungcap/them', [NhaCungCapController::class, 'store']);
    Route::get('/nhacungcap/{id}', [NhaCungCapController::class, 'show']);
    Route::put('/nhacungcap/update/{id}', [NhaCungCapController::class, 'update']);
    Route::delete('/nhacungcap/xoa/{id}', [NhaCungCapController::class, 'destroy']);
    // chi tiet kho
    Route::get('/kho/chitiet', [KhoDetailController::class, 'index']);
    Route::get('/kho/chitiet/{id}', [KhoDetailController::class, 'show']);
    Route::post('kho/chitiet/nhap', [KhoDetailController::class, 'nhapKhoChiTiet']);
    Route::put('kho/chitiet/update/{id}', [KhoDetailController::class, 'update']);
    Route::delete('kho/chitiet/xoa/{id}', [KhoDetailController::class, 'destroy']);
    Route::get('/kho/chitiet/product/{masp}', [KhoDetailController::class, 'getByProduct']);
    // account
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::get('/accounts/{id}', [AccountController::class, 'show']);
    Route::put('/accounts/{id}', [AccountController::class, 'update']);
    Route::put('/accounts/{id}/password', [AccountController::class, 'updatePassword']);
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy']);
    // slideshow
    Route::post('/slides', [SlideshowController::class, 'store']);
    Route::put('/slides/{id}', [SlideshowController::class, 'update']);
    Route::delete('/slides/{id}', [SlideshowController::class, 'destroy']);
    // stats
    Route::get('/stats', [StatsController::class, 'index']);
    Route::get('/stats/revenue', [StatsController::class, 'revenueByMonth']);
});
