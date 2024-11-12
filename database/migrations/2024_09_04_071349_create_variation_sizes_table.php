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
        Schema::create('variation_sizes', function (Blueprint $table) {
            $table->id('variation_size_id');
            $table->foreignId('photo_id')->constrained('variation_photos', 'photo_id')->onDelete('cascade');
            $table->string('size');
            $table->decimal('price', 8);
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_sizes');
    }
};
