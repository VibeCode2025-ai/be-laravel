<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taikhoan', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('password', 255);
            $table->string('fullname');
            $table->string('sdt', 20)->nullable();
            $table->string('diachi')->nullable();
            $table->string('email')->unique();
            $table->boolean('hoatdong')->default(1);
            $table->integer('loaiTK')->default(2);
            $table->boolean('trangthai')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taikhoan');
    }
};
