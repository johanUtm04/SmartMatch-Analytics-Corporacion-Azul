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
        // 1. Limpiar datos previos para evitar duplicados si lo corren varias veces
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_performances')->truncate();
        DB::table('product_prices')->truncate();
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Insertar Marcas y recuperar sus IDs
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

        // 3. Mapeo estructurado de las 5 cubetas finalistas de tus fichas de Canva
        $productsData = [
            // --- GAMA COMERCIAL: 3 AÑOS ---
            [
                'brand_id' => $cemixId,
                'sku' => 'CX-IMP-3Y',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 3 AÑOS',
                'technical_name' => 'IMPERCOOL® FIBRATADO 3 AÑOS',
                'guarantee_years' => 3,
                'volume_liters' => 19.0,
                'base_type' => 'Acrílica',
                'is_fibrated' => true,
                'price' => 1250.00,
                'performances' => [
                    ['surface_type' => 'general', 'consumption_per_m2' => 1.0, 'min_coverage_m2' => 19.0, 'max_coverage_m2' => 19.0]
                ]
            ],
            [
                'brand_id' => $sikaId,
                'sku' => 'SK-A3P-3Y',
                'erp_name' => 'SIKA ACRIL TECHO 3 ULTRA 18 LT',
                'technical_name' => 'Sika® Acril Techo®-3 Pro',
                'guarantee_years' => 3,
                'volume_liters' => 18.0,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'price' => 1390.00,
                'performances' => [
                    ['surface_type' => 'liso', 'consumption_per_m2' => 1.3, 'min_coverage_m2' => 13.8, 'max_coverage_m2' => 13.8],
                    ['surface_type' => 'rugoso', 'consumption_per_m2' => 1.5, 'min_coverage_m2' => 12.0, 'max_coverage_m2' => 12.0]
                ]
            ],

            // --- GAMA MEDIA / ECO: 5 AÑOS ---
            [
                'brand_id' => $cemixId,
                'sku' => 'CX-IMP-ECO-5Y',
                'erp_name' => 'CEMIX IMPERCOOL ECOLÓGICO 19 LT 5 AÑOS',
                'technical_name' => 'IMPERCOOL® ECOLÓGICO 5 AÑOS',
                'guarantee_years' => 5,
                'volume_liters' => 19.0,
                'base_type' => 'Acrílica y caucho reciclado',
                'is_fibrated' => false,
                'price' => 1420.00,
                'performances' => [
                    ['surface_type' => 'general', 'consumption_per_m2' => 1.0, 'min_coverage_m2' => 19.0, 'max_coverage_m2' => 19.0]
                ]
            ],
            [
                'brand_id' => $sikaId,
                'sku' => 'SK-GP-5Y',
                'erp_name' => 'SIKA ACRIL TECHO GREEN POWER 19 LT',
                'technical_name' => 'Sika® Acril Techo Green Power',
                'guarantee_years' => 5,
                'volume_liters' => 19.0,
                'base_type' => 'Acrílica con microesferas',
                'is_fibrated' => true,
                'price' => 1980.00,
                'performances' => [
                    ['surface_type' => 'liso', 'consumption_per_m2' => 1.0, 'min_coverage_m2' => 19.0, 'max_coverage_m2' => 19.0],
                    ['surface_type' => 'rugoso', 'consumption_per_m2' => 1.5, 'min_coverage_m2' => 12.7, 'max_coverage_m2' => 12.7]
                ]
            ],

            // --- GAMA ALTA: 7 AÑOS ---
            [
                'brand_id' => $cemixId,
                'sku' => 'CX-IMP-7Y',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 7 AÑOS',
                'technical_name' => 'IMPERCOOL® FIBRATADO 7 AÑOS',
                'guarantee_years' => 7,
                'volume_liters' => 19.0,
                'base_type' => 'Acrílica con fibras de polipropileno',
                'is_fibrated' => true,
                'price' => 1850.00,
                'performances' => [
                    ['surface_type' => 'general', 'consumption_per_m2' => 1.0, 'min_coverage_m2' => 19.0, 'max_coverage_m2' => 19.0]
                ]
            ]
        ];

        // 4. Ciclo de inserción relacional automatizado
        foreach ($productsData as $p) {
            // Insertar el producto base
            $productId = DB::table('products')->insertGetId([
                'brand_id' => $p['brand_id'],
                'sku' => $p['sku'],
                'erp_name' => $p['erp_name'],
                'technical_name' => $p['technical_name'],
                'guarantee_years' => $p['guarantee_years'],
                'volume_liters' => $p['volume_liters'],
                'base_type' => $p['base_type'],
                'is_fibrated' => $p['is_fibrated'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insertar su precio actual en la tabla pivote de costos históricos
            DB::table('product_prices')->insert([
                'product_id' => $productId,
                'price' => $p['price'],
                'currency' => 'MXN',
                'registered_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insertar sus métricas de rendimiento (Manejando los rangos elásticos o fijos)
            foreach ($p['performances'] as $perf) {
                DB::table('product_performances')->insert([
                    'product_id' => $productId,
                    'surface_type' => $perf['surface_type'],
                    'consumption_per_m2' => $perf['consumption_per_m2'],
                    'min_coverage_m2' => $perf['min_coverage_m2'],
                    'max_coverage_m2' => $perf['max_coverage_m2'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}