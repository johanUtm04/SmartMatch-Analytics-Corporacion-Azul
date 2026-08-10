<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('surface_type', ['liso', 'rugoso', 'general']);
            $table->decimal('consumption_per_m2', 4, 2);
            $table->decimal('min_coverage_m2', 5, 2);
            $table->decimal('max_coverage_m2', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_performances');
    }
};