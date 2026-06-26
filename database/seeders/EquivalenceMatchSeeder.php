<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class EquivalenceMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cemixProduct = DB::table('products')
            ->where('sku', 'CX-IMPH-5Y')
            ->first();

        $sikaProduct = DB::table('products')
            ->where('sku', 'SK-ATIH-5Y')
            ->first();

        if (!$cemixProduct || !$sikaProduct) {
            throw new Exception('Required products were not found. Run ProductTableSeeder first.');
        }

        DB::table('equivalence_matches')->updateOrInsert(
            [
                'own_product_id' => $cemixProduct->id,
                'competitor_product_id' => $sikaProduct->id,
            ],
            [
                'match_type' => 'direct',
                'gama' => 'Gama Baja',
                'technical_segmentation' => 'Impermeabilizantes de Techo - Líquidos',
                'strategic_analysis' => 'Sika juega con ventaja de volumen aquí: entrega 19 litros contra los 18 litros de Cemix. Si el precio de ambos es similar, Sika se puede llevar al cliente por costo efectivo por m². Cemix debe defenderse con ajuste de precio, disponibilidad, respaldo técnico o argumento de marca.',
                'priority' => 1,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}