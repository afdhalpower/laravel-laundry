<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_order', 20)->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->date('tgl_masuk');
            $table->date('tgl_selesai')->nullable();
            $table->enum('status', [
                'diterima', 'dicuci', 'dikeringkan', 'disetrika',
                'dilipat', 'siap', 'diantar', 'selesai'
            ])->default('diterima');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
