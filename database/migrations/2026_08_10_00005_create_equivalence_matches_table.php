<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equivalence_matches', function (Blueprint $table) {
            $table->id();

            // Nullable desde el inicio (equivale al dump original + su
            // migración posterior "make_own_product_nullable").
            $table->foreignId('own_product_id')
                ->nullable()
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('competitor_product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            $table->string('match_type')->default('direct');
            $table->string('gama')->nullable();
            $table->string('technical_segmentation')->nullable();
            $table->longText('strategic_analysis')->nullable();
            $table->unsignedTinyInteger('priority')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['own_product_id', 'competitor_product_id'], 'unique_equivalence_match');
            $table->index('match_type');
            $table->index('gama');
            $table->index('technical_segmentation');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equivalence_matches');
    }
};