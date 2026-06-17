<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Limpieza absoluta de tablas para evitar duplicación o basura
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_performances')->truncate();
        DB::table('product_prices')->truncate();
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Inserción de Marcas Líderes
        $cemixId = DB::table('brands')->insertGetId([
            'name' => 'CEMIX',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $sikaId = DB::table('brands')->insertGetId([
            'name' => 'SIKA',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 3. Inserción Quirúrgica del Producto: CEMIX IMPERCOOL HOGAR
        $cemixProductId = DB::table('products')->insertGetId([
            'brand_id' => $cemixId,
            'sku' => 'CX-IMPH-5Y',
            'erp_name' => 'IMPERCOOL HOGAR 18 LT',
            'technical_name' => 'IMPERCOOL® HOGAR BLANCO / ROJO',
            'guarantee_years' => 5,
            'volume_liters' => 18.00,
            'base_type' => 'Acrílica con tecnología aislante',
            'is_fibrated' => false,
            'requires_separate_primer' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Precio base estimado sugerido por marketing para simulación inicial
        DB::table('product_prices')->insert([
            'product_id' => $cemixProductId,
            'price' => 600.00, // Punto medio entre $550 y $650 de ficha técnica
            'currency' => 'MXN',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Rendimiento formal: 18L cubren entre 16m² y 18m² (Consumo promedio ~1.05L por m²)
        DB::table('product_performances')->insert([
            'product_id' => $cemixProductId,
            'surface_type' => 'general',
            'consumption_per_m2' => 1.05, 
            'min_coverage_m2' => 16.00,
            'max_coverage_m2' => 18.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // 4. Inserción Quirúrgica del Producto: SIKA IRON HOME
        $sikaProductId = DB::table('products')->insertGetId([
            'brand_id' => $sikaId,
            'sku' => 'SK-ATIH-5Y',
            'erp_name' => 'SIKA ACRIL TECHO-005 IRON HOME CUBETA 19 L',
            'technical_name' => 'Sika® Acril Techo® -005 Iron Home',
            'guarantee_years' => 5,
            'volume_liters' => 19.00,
            'base_type' => 'Acrílica con tecnología acrílico-estirenada',
            'is_fibrated' => false,
            'requires_separate_primer' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('product_prices')->insert([
            'product_id' => $sikaProductId,
            'price' => 620.00, // Punto medio entre $550 y $650 de ficha técnica
            'currency' => 'MXN',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Rendimiento formal: 19L rinden exactamente 19m² (Consumo plano de 1.00L por m²)
        DB::table('product_performances')->insert([
            'product_id' => $sikaProductId,
            'surface_type' => 'general',
            'consumption_per_m2' => 1.00,
            'min_coverage_m2' => 19.00,
            'max_coverage_m2' => 19.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}