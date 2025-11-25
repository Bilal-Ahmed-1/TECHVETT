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
        Schema::create('accepted_rejected_candidates', function (Blueprint $table) {
            $table->id();
            $table->string('total_candidate');
            $table->unsignedBigInteger('user_id');
            $table->string('field_or_job_role');
            $table->string('candidate_name');
            $table->enum('progress', ['Accepted', 'Rejected']);
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accepted_rejected_candidates');
    }
};
