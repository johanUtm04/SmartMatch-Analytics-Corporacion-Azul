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
        Schema::create('equivalence_matches', function (Blueprint $table) {
            $table->id();

            // Our brand product: usually Cemix / Impercool
            $table->foreignId('own_product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // Competitor product: usually Sika
            $table->foreignId('competitor_product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            // Example: direct, indirect, monopoly_temporal, no_equivalent
            $table->string('match_type')->default('direct');

            // Example: Gama Baja, Gama Media, Premium, Alta Duración
            $table->string('gama')->nullable();

            // Example: Impermeabilizantes de Techo - Líquidos
            $table->string('technical_segmentation')->nullable();

            // Text from your Excel analysis column
            $table->longText('strategic_analysis')->nullable();

            // Useful for sorting inside the dashboard
            $table->unsignedTinyInteger('priority')->default(1);

            // To enable or disable a match without deleting it
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['own_product_id', 'competitor_product_id'], 'unique_equivalence_match');
            $table->index('match_type');
            $table->index('gama');
            $table->index('technical_segmentation');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalence_matches');
    }
};