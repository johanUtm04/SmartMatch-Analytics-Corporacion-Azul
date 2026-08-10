<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('erp_name');
            $table->string('technical_name');
            $table->integer('guarantee_years');
            $table->decimal('volume_liters', 5, 2);
            $table->string('base_type');
            $table->boolean('is_fibrated')->default(false);
            $table->boolean('requires_separate_primer')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};