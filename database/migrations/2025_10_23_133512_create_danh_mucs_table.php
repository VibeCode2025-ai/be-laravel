<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('danhmuc', function (Blueprint $table) {
            $table->id();
            $table->string('tendanhmuc')->unique(); // Tên danh mục
            $table->text('mota')->nullable(); // Mô tả danh mục
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danhmuc');
    }
};
