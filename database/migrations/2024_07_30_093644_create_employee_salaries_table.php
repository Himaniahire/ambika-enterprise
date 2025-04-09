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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('com_id');
            $table->unsignedBigInteger('emp_id');
            $table->integer('total_present');
            $table->integer('total_leave');
            $table->integer('total_ot');
            $table->decimal('deduct_advance', 10, 2);
            $table->decimal('salary', 10, 2);
            $table->decimal('additional_amount', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('com_id')->references('id')->on('register_companies');
            $table->foreign('emp_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
