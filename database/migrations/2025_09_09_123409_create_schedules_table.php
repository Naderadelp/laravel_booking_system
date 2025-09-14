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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->date('start_at');
            $table->date('ends_at');
            $table->time('monday_start_at')->nullable();
            $table->time('monday_ends_at')->nullable();
            $table->time('tuesday_start_at')->nullable();
            $table->time('tuesday_ends_at')->nullable();
            $table->time('wednesday_start_at')->nullable();
            $table->time('wednesday_ends_at')->nullable();
            $table->time('thursday_start_at')->nullable();
            $table->time('thursday_ends_at')->nullable();
            $table->time('sunday_start_at')->nullable();
            $table->time('sunday_ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
