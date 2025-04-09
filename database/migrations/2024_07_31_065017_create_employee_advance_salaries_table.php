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
        Schema::create('employee_advance_salaries', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key with auto increment
            $table->unsignedBigInteger('emp_id'); // Foreign key to employee
            $table->integer('advance_date')->nullable(); // Nullable advance date
            $table->unsignedInteger('advance_amount')->nullable(); // Nullable advance amount
            $table->text('note')->nullable(); // Nullable note
            $table->timestamps();

            $table->foreign('emp_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_advance_salaries');
    }
};
