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
        Schema::create('stage3_results', function (Blueprint $table) {
            $table->id();
    $table->longText('transcript');
    $table->float('score')->default(0);
    $table->string('rating')->default('N/A');
    $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage3_results');
    }
};
