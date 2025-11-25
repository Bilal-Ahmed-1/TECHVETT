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
         Schema::create('test_score', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('name');
        $table->string('field');
        $table->string('jobrole');
        $table->string('experience')->nullable();

        $table->integer('stage1')->nullable(); // from test_results.correct
        $table->integer('stage2')->nullable(); // from stage2_results.correct
        $table->integer('stage3')->nullable(); // from stage3_results.score

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_score');
    }
};
