<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->enum('surface_type', ['liso', 'rugoso', 'general']); // Handles the Sika glitch
            $table->decimal('consumption_per_m2', 4, 2); // Theoretical consumption (L/m²)
            $table->decimal('min_coverage_m2', 5, 2); // Minimum coverage per bucket
            $table->decimal('max_coverage_m2', 5, 2); // Maximum coverage per bucket
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('product_performances');
    }
};
