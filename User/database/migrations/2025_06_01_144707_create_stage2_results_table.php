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
        Schema::create('stage2_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total');
            $table->integer('correct');
            $table->integer('wrong');
            $table->json('answers')->nullable(); // Store detailed answers as JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stage2_results');
    }
};
