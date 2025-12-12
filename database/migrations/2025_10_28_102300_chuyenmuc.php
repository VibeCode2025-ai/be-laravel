<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            // 🆕 Thêm cột chuyenmuc_id
            $table->unsignedBigInteger('chuyenmuc_id')->nullable()->after('danhmuc_id'); // thêm sau cột id

            // 🔗 Tạo khóa ngoại liên kết đến bảng chuyemuc
            $table->foreign('chuyenmuc_id')
                  ->references('id')
                  ->on('chuyenmuc')
                  ->onDelete('set null'); // hoặc 'cascade' nếu muốn xóa sản phẩm khi xóa chuyên mục
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sanpham', function (Blueprint $table) {
            // 🧹 Xóa khóa ngoại và cột
            $table->dropForeign(['chuyenmuc_id']);
            $table->dropColumn('chuyenmuc_id');
        });
    }
};
