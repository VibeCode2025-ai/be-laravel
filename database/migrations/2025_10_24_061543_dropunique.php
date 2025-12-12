<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            $table->dropUnique(['tendanhmuc']);
        });
    }

    public function down(): void
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            $table->string('tendanhmuc')->unique()->change();
        });
    }
};