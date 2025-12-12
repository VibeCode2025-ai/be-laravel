<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('binhluan', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('sanpham_id');
        $table->Integer('user_id');
        $table->text('noidung');
        $table->timestamps();

        // Khóa ngoại
        $table->foreign('sanpham_id')->references('masp')->on('sanpham')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('taikhoan')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binhluan');
    }
};
