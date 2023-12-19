<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->required();
            $table->unsignedBigInteger('exercise_id')->required();
            $table->integer('repetitions')->required();
            $table->float('weight')->required();
            $table->integer('break_time')->required();
            $table->enum('day', ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO'])->default('SEGUNDA');
            $table->text('observations')->required();
            $table->integer('time')->required();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('exercise_id')->references('id')->on('exercises');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
