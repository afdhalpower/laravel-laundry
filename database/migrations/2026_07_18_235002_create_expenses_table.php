<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("expenses", function (Blueprint $table) {
            $table->id();
            $table->string("judul");
            $table->text("deskripsi")->nullable();
            $table->string("kategori", 50);
            $table->decimal("jumlah", 12, 0);
            $table->date("tgl_pengeluaran");
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("expenses");
    }
};
