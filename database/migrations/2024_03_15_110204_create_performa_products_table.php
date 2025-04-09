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
        Schema::create('performa_products', function (Blueprint $table) {
            $table->id();
            $table->string('performa_id')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('uom')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('total_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performa_products');
    }
};
