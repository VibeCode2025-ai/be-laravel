<?php
// database/migrations/xxxx_xx_xx_create_pending_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->string('txn_ref', 100)->unique(); // ORD123456789_abc...
            $table->json('data');                     // Dữ liệu đơn hàng
            $table->timestamp('expires_at');          // Hết hạn sau 30 phút
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};