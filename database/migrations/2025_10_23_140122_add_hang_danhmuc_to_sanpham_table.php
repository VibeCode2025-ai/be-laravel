<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->foreignId('hang_id')->nullable()->constrained('hang')->onDelete('set null');
            $table->foreignId('danhmuc_id')->nullable()->constrained('danhmuc')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->dropForeign(['hang_id']);
            $table->dropForeign(['danhmuc_id']);
            $table->dropColumn(['hang_id', 'danhmuc_id']);
        });
    }
};
