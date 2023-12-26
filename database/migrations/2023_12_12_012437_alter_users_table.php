<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id');
            $table->string('cpf', 14)->unique();
            $table->date('date_birth');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('cpf');
            $table->dropColumn('date_birth');
        });
    }
};
