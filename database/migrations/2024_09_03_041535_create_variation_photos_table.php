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
        Schema::create('variation_photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->foreignId('variation_id')->constrained('product_variations', 'variation_id')->onDelete('cascade');
            $table->string('directory');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_photos');
    }
};
