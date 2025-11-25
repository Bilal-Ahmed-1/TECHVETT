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
        Schema::create('upcoming_activities', function (Blueprint $table) {
            $table->id();
            $table->string('total_candidate');
            $table->unsignedBigInteger('user_id');
            $table->string('field_or_job_role');
            $table->string('meeting_with_candidate_name');
            $table->time('time');
            $table->enum('meeting_type', ['Online', 'Offline']);
            $table->enum('condition_of_meeting', ['Scheduled', 'Postponed', 'Completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upcoming_activities');
    }
};
