<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarketingMatrixSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            /**
             * Clean old matrix data.
             * We use delete(), not truncate(), because truncate inside a transaction
             * can cause: "There is no active transaction".
             */
            DB::table('equivalence_matches')->delete();
            DB::table('product_performances')->delete();
            DB::table('product_prices')->delete();
            DB::table('products')->delete();
            DB::table('brands')->delete();

            $cemixBrandId = $this->brandId('CEMIX', $now);
            $sikaBrandId = $this->brandId('SIKA', $now);

            /**
             * ============================================================
             * CEMIX / IMPERCOOL PRODUCTS
             * ============================================================
             */

            $this->productId($cemixBrandId, [
                'sku' => 'CX-IMPH-18L',
                'erp_name' => 'IMPERCOOL HOGAR 18 LT',
                'technical_name' => 'IMPERCOOL® HOGAR BLANCO / ROJO',
                'guarantee_years' => 5,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 600.00, 1.05, 16.00, 18.00, $now);

            $this->productId($cemixBrandId, [
                'sku' => 'CX-IMPH-FIB-3Y-19L',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 3 AÑOS',
                'technical_name' => 'IMPERCOOL® HOGAR FIBRATADO 19 LT 3 AÑOS',
                'guarantee_years' => 3,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
            ], 1180.00, 1.00, 19.00, 19.00, $now);

            $this->productId($cemixBrandId, [
                'sku' => 'CX-IMPH-FIB-5Y-19L',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 5 AÑOS',
                'technical_name' => 'IMPERCOOL CEMIX 5 AÑOS FIBRATADO',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
            ], 1560.00, 1.00, 19.00, 19.00, $now);

            $this->productId($cemixBrandId, [
                'sku' => 'CX-IMPH-ECO-5Y-19L',
                'erp_name' => 'CEMIX IMPERCOOL ECOLOGICO BLANCO 5 AÑOS',
                'technical_name' => 'CEMIX IMPERCOOL® ECOLÓGICO 19 LITROS',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica ecológica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 1420.00, 1.00, 19.00, 19.00, $now);

            $this->productId($cemixBrandId, [
                'sku' => 'CX-IMPH-FIB-7Y-19L',
                'erp_name' => 'CEMIX IMPERCOOL FIBRATADO 19 LT 7 AÑOS',
                'technical_name' => 'CEMIX IMPERCOOL® FIBRATADO 7 AÑOS 19 LITROS',
                'guarantee_years' => 7,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica fibratada alta duración',
                'is_fibrated' => true,
                'requires_separate_primer' => false,
            ], 1850.00, 1.00, 19.00, 19.00, $now);


            /**
             * ============================================================
             * SIKA PRODUCTS
             * ============================================================
             */

            $this->productId($sikaBrandId, [
                'sku' => 'SK-ATIH-005-19L',
                'erp_name' => 'SIKA ACRIL TECHO-005 IRON HOME CUBETA 19 L',
                'technical_name' => 'Sika® Acril Techo® -005 Iron Home',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 600.00, 1.00, 19.00, 19.00, $now);

            $this->productId($sikaBrandId, [
                'sku' => 'SK-AT3PRO-18L',
                'erp_name' => 'SIKA ACRIL TECHO 3 PRO CUBETA 18L',
                'technical_name' => 'Sika® Acril Techo® -3 PRO',
                'guarantee_years' => 3,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 1250.00, 1.395, 12.00, 13.80, $now);

            $this->productId($sikaBrandId, [
                'sku' => 'SK-AT5ULTRA-18L',
                'erp_name' => 'ACRIL TECHO 5 ULTRA CUBETA 18L',
                'technical_name' => 'Sika® Acril Techo® -5 Ultra',
                'guarantee_years' => 5,
                'volume_liters' => 18.00,
                'base_type' => 'Acrílica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 1690.00, 1.20, 12.00, 18.00, $now);

            $this->productId($sikaBrandId, [
                'sku' => 'SK-ATGREEN-19L',
                'erp_name' => 'SIKA ACRIL TECHO GREEN POWER CUBETA 19L',
                'technical_name' => 'Sika® Acril Techo Green Power 19 LITROS',
                'guarantee_years' => 5,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica ecológica',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 1980.00, 1.00, 12.70, 19.00, $now);

            $this->productId($sikaBrandId, [
                'sku' => 'SK-ATPOWER-6-8Y-19L',
                'erp_name' => 'SIKA ACRIL TECHO POWER 6 AÑOS / 8 AÑOS CUBETA 19L',
                'technical_name' => 'Sika® Acril Techo Power 6 Y 8 AÑOS 19 LITROS',
                'guarantee_years' => 8,
                'volume_liters' => 19.00,
                'base_type' => 'Acrílica alta duración',
                'is_fibrated' => false,
                'requires_separate_primer' => false,
            ], 2150.00, 1.00, 17.20, 19.00, $now);


            /**
             * ============================================================
             * REAL MATRIX MATCHES FROM THE IMAGES
             * ============================================================
             */

            $this->match(
                'CX-IMPH-18L',
                'SK-ATIH-005-19L',
                'direct',
                'Gama Hogar / 5 años',
                'Impermeabilizantes de techo - Acrílicos',
                'Comparación de entrada entre Impercool Hogar 18 L y Sika Acril Techo -005 Iron Home 19 L. Cemix ofrece 16 a 18 m² por cubeta, mientras Sika declara 19 m² por cubeta. La lectura comercial debe considerar precio, volumen, rendimiento y que el costo estimado puede variar por el uso de malla.',
                1,
                $now
            );

            $this->match(
                'CX-IMPH-FIB-3Y-19L',
                'SK-AT3PRO-18L',
                'direct',
                'Gama 3 años / Comercial',
                'Impermeabilizantes de techo - Acrílicos fibratados',
                'Cemix tiene una ventaja fuerte en rendimiento y costo por m²: 19 m² por cubeta contra 12.0 a 13.8 m² de Sika. Aunque Sika tiene un precio mayor, su cobertura menor eleva el costo por m².',
                2,
                $now
            );

            $this->match(
                'CX-IMPH-FIB-5Y-19L',
                'SK-AT5ULTRA-18L',
                'direct',
                'Gama 5 años / Media',
                'Impermeabilizantes de techo - Acrílicos fibratados',
                'Cemix Fibratado 5 años mantiene una lectura competitiva por costo por m² frente a Sika Acril Techo 5 Ultra. La defensa comercial debe enfocarse en rendimiento por cubeta, precio efectivo y desempeño aplicado.',
                3,
                $now
            );

            $this->match(
                'CX-IMPH-ECO-5Y-19L',
                'SK-ATGREEN-19L',
                'direct',
                'Gama ecológica / Sustentable',
                'Impermeabilizantes de techo - Acrílicos ecológicos',
                'Comparación directa en línea ecológica de 19 litros. Cemix presenta menor precio y menor costo estimado por m² frente a Sika Green Power, por lo que puede defenderse con argumento de ahorro, rendimiento y enfoque sustentable.',
                4,
                $now
            );

            $this->match(
                'CX-IMPH-FIB-7Y-19L',
                'SK-ATPOWER-6-8Y-19L',
                'direct',
                'Alta duración / Premium',
                'Impermeabilizantes de techo - Acrílicos alta duración',
                'Comparación de alta duración. Cemix Fibratado 7 años compite contra Sika Acril Techo Power 6 y 8 años. Sika puede presionar desde garantía, pero Cemix conserva una oportunidad comercial por costo por m² y rendimiento.',
                5,
                $now
            );
        });
    }

    private function brandId(string $name, Carbon $now): int
    {
        DB::table('brands')->insert([
            'name' => $name,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return (int) DB::table('brands')->where('name', $name)->value('id');
    }

    private function productId(
        int $brandId,
        array $product,
        float $price,
        float $consumptionPerM2,
        float $minCoverage,
        float $maxCoverage,
        Carbon $now
    ): int {
        DB::table('products')->insert([
            'brand_id' => $brandId,
            'sku' => $product['sku'],
            'erp_name' => $product['erp_name'],
            'technical_name' => $product['technical_name'],
            'guarantee_years' => $product['guarantee_years'],
            'volume_liters' => $product['volume_liters'],
            'base_type' => $product['base_type'],
            'is_fibrated' => $product['is_fibrated'],
            'requires_separate_primer' => $product['requires_separate_primer'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $productId = (int) DB::table('products')
            ->where('sku', $product['sku'])
            ->value('id');

        DB::table('product_prices')->insert([
            'product_id' => $productId,
            'price' => $price,
            'currency' => 'MXN',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('product_performances')->insert([
            'product_id' => $productId,
            'surface_type' => 'general',
            'consumption_per_m2' => $consumptionPerM2,
            'min_coverage_m2' => $minCoverage,
            'max_coverage_m2' => $maxCoverage,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $productId;
    }

    private function match(
        string $ownSku,
        string $competitorSku,
        string $matchType,
        string $gama,
        string $technicalSegmentation,
        string $strategicAnalysis,
        int $priority,
        Carbon $now
    ): void {
        $ownProductId = DB::table('products')
            ->where('sku', $ownSku)
            ->value('id');

        $competitorProductId = DB::table('products')
            ->where('sku', $competitorSku)
            ->value('id');

        DB::table('equivalence_matches')->insert([
            'own_product_id' => $ownProductId,
            'competitor_product_id' => $competitorProductId,
            'match_type' => $matchType,
            'gama' => $gama,
            'technical_segmentation' => $technicalSegmentation,
            'strategic_analysis' => $strategicAnalysis,
            'priority' => $priority,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}