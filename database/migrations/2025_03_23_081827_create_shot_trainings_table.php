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
        Schema::create('shot_trainings', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('overall_shot_id')->constrained('overall_shots')->onDelete('cascade');
            $table->integer('shotmade');
            $table->integer('attempt');
            // $table->time('duration');
            $table->enum('location', ['Right Corner', 'Left Corner', 'Top', 'Right Wing', 'Left Wing', 'Top Of The Key', 'Right Short Corner', 'Left Short Corner', 'Right Elbow', 'Left Elbow']);
            $table->double('accuracy', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shot_training');
    }
};
