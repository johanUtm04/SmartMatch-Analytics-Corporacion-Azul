<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::pluck('id', 'name');

        foreach ($this->products() as $data) {
            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'brand_id' => $brands[$data['brand']],
                    'erp_name' => $data['erp_name'],
                    'technical_name' => $data['technical_name'],
                    'guarantee_years' => $data['guarantee_years'],
                    'volume_liters' => $data['volume_liters'],
                    'base_type' => $data['base_type'],
                    'is_fibrated' => $data['is_fibrated'],
                    'requires_separate_primer' => $data['requires_separate_primer'],
                ]
            );

            $product->prices()->updateOrCreate(
                ['registered_at' => $data['price']['registered_at']],
                [
                    'price' => $data['price']['amount'],
                    'currency' => $data['price']['currency'],
                ]
            );

            $product->performances()->updateOrCreate(
                ['surface_type' => $data['performance']['surface_type']],
                [
                    'consumption_per_m2' => $data['performance']['consumption_per_m2'],
                    'min_coverage_m2' => $data['performance']['min_coverage_m2'],
                    'max_coverage_m2' => $data['performance']['max_coverage_m2'],
                ]
            );
        }
    }

    /**
     * Catálogo fase 1: línea de impermeabilizantes de techo Cemix vs Sika.
     */
    private function products(): array
    {
        return [
            [
                'sku' => 'CX-IMPH-18L',
                'brand' => 'CEMIX',
                'erp_name' => 'IMPERCOOL HOGAR 18 LT',
                'technical_name' => 'IMPERCOOL® HOGAR BLANCO / ROJO',
                'guarantee_years' => 5,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 600.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:39'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.05, 'min_coverage_m2' => 16.00, 'max_coverage_m2' => 18.00],
            ],
            [
                'sku' => 'CX-IMPH-FIB-3Y-19L',
                'brand' => 'CEMIX',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 3 AÑOS',
                'technical_name' => 'IMPERCOOL® HOGAR FIBRATADO 19 LT 3 AÑOS',
                'guarantee_years' => 3,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1180.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:39'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 19.00, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'CX-IMPH-FIB-5Y-19L',
                'brand' => 'CEMIX',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 5 AÑOS',
                'technical_name' => 'IMPERCOOL CEMIX 5 AÑOS FIBRATADO',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1560.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:39'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 19.00, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'CX-IMPH-ECO-5Y-19L',
                'brand' => 'CEMIX',
                'erp_name' => 'CEMIX IMPERCOOL ECOLOGICO BLANCO 5 AÑOS',
                'technical_name' => 'CEMIX IMPERCOOL® ECOLÓGICO 19 LITROS',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica ecológica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1420.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:39'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 19.00, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'CX-IMPH-FIB-7Y-19L',
                'brand' => 'CEMIX',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 7 AÑOS',
                'technical_name' => 'CEMIX IMPERCOOL® FIBRATADO 7 AÑOS 19 LITROS',
                'guarantee_years' => 7,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada alta duración',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1850.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:39'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 19.00, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'SK-ATIH-005-19L',
                'brand' => 'SIKA',
                'erp_name' => 'SIKA ACRIL TECHO-005 IRON HOME CUBETA 19 L',
                'technical_name' => 'Sika® Acril Techo® -005 Iron Home',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 600.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:40'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 19.00, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'SK-AT3PRO-18L',
                'brand' => 'SIKA',
                'erp_name' => 'SIKA ACRIL TECHO 3 PRO CUBETA 18L',
                'technical_name' => 'Sika® Acril Techo® -3 PRO',
                'guarantee_years' => 3,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1250.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:40'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.40, 'min_coverage_m2' => 12.00, 'max_coverage_m2' => 13.80],
            ],
            [
                'sku' => 'SK-AT5ULTRA-18L',
                'brand' => 'SIKA',
                'erp_name' => 'ACRIL TECHO 5 ULTRA CUBETA 18L',
                'technical_name' => 'Sika® Acril Techo® -5 Ultra',
                'guarantee_years' => 5,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1690.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:40'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.20, 'min_coverage_m2' => 12.00, 'max_coverage_m2' => 18.00],
            ],
            [
                'sku' => 'SK-ATGREEN-19L',
                'brand' => 'SIKA',
                'erp_name' => 'SIKA ACRIL TECHO GREEN POWER CUBETA 19L',
                'technical_name' => 'Sika® Acril Techo Green Power 19 LITROS',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica ecológica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 1980.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:40'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 12.70, 'max_coverage_m2' => 19.00],
            ],
            [
                'sku' => 'SK-ATPOWER-6-8Y-19L',
                'brand' => 'SIKA',
                'erp_name' => 'SIKA ACRIL TECHO POWER 6 AÑOS / 8 AÑOS CUBETA 19L',
                'technical_name' => 'Sika® Acril Techo Power 6 Y 8 AÑOS 19 LITROS',
                'guarantee_years' => 8,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica alta duración',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
                'price' => ['amount' => 2150.00, 'currency' => 'MXN', 'registered_at' => '2026-06-26 19:58:40'],
                'performance' => ['surface_type' => 'general', 'consumption_per_m2' => 1.00, 'min_coverage_m2' => 17.20, 'max_coverage_m2' => 19.00],
            ],
        ];
    }
}