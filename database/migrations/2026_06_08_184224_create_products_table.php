<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('sku')->unique(); // ERP code
            $table->string('erp_name'); 
            $table->string('technical_name'); 
            $table->integer('guarantee_years'); // 3, 5, 6, 7, 8
            $table->decimal('volume_liters', 5, 2); // 18.00 o 19.00
            $table->string('base_type'); // Acrílica, Llanta reciclada, etc.
            $table->boolean('is_fibrated')->default(false);
            $table->boolean('requires_separate_primer')->default(false); // Case Cemix 7 years
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};