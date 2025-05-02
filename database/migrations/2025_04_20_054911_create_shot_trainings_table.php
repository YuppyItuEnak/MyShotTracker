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
            $table->foreignId('overall_shot_id')->nullable()->constrained('overall_shots')->onDelete('cascade');

            $table->integer('shotmade')->default(0); // Jumlah bola masuk yang terbaca sensor
            $table->integer('attempt');              // Target attempt dari user
            $table->string('duration')->nullable();
            $table->enum('location', [
                'Right Corner',
                'Left Corner',
                'Top',
                'Right Wing',
                'Left Wing',
                'Right Short Corner',
                'Left Short Corner',
                'Right Elbow',
                'Left Elbow',
                'Top Of The Key',
                'Freethrow'
            ]);
            $table->double('accuracy', 5, 2)->default(0); // Akurasi hasil training
            $table->boolean('is_active')->default(true);
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
