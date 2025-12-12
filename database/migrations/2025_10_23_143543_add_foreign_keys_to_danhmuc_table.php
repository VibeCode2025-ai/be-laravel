<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            $table->unsignedBigInteger('hang_id')->nullable()->after('id');

            // Tạo khóa ngoại liên kết đến bảng hang
            $table->foreign('hang_id')->references('id')->on('hang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            $table->dropForeign(['hang_id']);
            $table->dropColumn('hang_id');
        });
    }
};


