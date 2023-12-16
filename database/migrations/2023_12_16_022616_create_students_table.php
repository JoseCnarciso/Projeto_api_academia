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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->string('email')->required()->unique();
            $table->date('date_birth')->required();
            $table->string('cpf',14)->required()->unique();
            $table->string('contact',20)->required();
            $table->string('city',50)->required();
            $table->string('neighborhood',50)->required();
            $table->string('number',30)->required();
            $table->string('street',30)->required();
            $table->string('state',2)->required();
            $table->string('cep',20)->required();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
