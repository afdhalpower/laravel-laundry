<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("activity_logs", function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs("actor"); // user or null
            $table->string("action", 50); // created, updated, deleted
            $table->morphs("subject"); // order, payment, etc
            $table->text("description")->nullable();
            $table->json("old_values")->nullable();
            $table->json("new_values")->nullable();
            $table->timestamp("created_at")->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("activity_logs");
    }
};
