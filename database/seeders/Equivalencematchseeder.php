<?php

namespace Database\Seeders;

use App\Models\EquivalenceMatch;
use App\Models\Product;
use Illuminate\Database\Seeder;

class EquivalenceMatchSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::pluck('id', 'sku');

        foreach ($this->matches() as $data) {
            EquivalenceMatch::updateOrCreate(
                [
                    'own_product_id' => $products[$data['own_sku']],
                    'competitor_product_id' => $products[$data['competitor_sku']],
                ],
                [
                    'match_type' => $data['match_type'],
                    'gama' => $data['gama'],
                    'technical_segmentation' => $data['technical_segmentation'],
                    'strategic_analysis' => $data['strategic_analysis'],
                    'priority' => $data['priority'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function matches(): array
    {
        return [
            [
                'own_sku' => 'CX-IMPH-18L',
                'competitor_sku' => 'SK-ATIH-005-19L',
                'match_type' => 'direct',
                'gama' => 'Gama Hogar / 5 años',
                'technical_segmentation' => 'Impermeabilizantes de techo - Acrílicos',
                'strategic_analysis' => 'Comparación de entrada entre Impercool Hogar 18 L y Sika Acril Techo -005 Iron Home 19 L. Cemix ofrece 16 a 18 m² por cubeta, mientras Sika declara 19 m² por cubeta. La lectura comercial debe considerar precio, volumen, rendimiento y que el costo estimado puede variar por el uso de malla.',
                'priority' => 1,
            ],
            [
                'own_sku' => 'CX-IMPH-FIB-3Y-19L',
                'competitor_sku' => 'SK-AT3PRO-18L',
                'match_type' => 'direct',
                'gama' => 'Gama 3 años / Comercial',
                'technical_segmentation' => 'Impermeabilizantes de techo - Acrílicos fibratados',
                'strategic_analysis' => 'Cemix tiene una ventaja fuerte en rendimiento y costo por m²: 19 m² por cubeta contra 12.0 a 13.8 m² de Sika. Aunque Sika tiene un precio mayor, su cobertura menor eleva el costo por m².',
                'priority' => 2,
            ],
            [
                'own_sku' => 'CX-IMPH-FIB-5Y-19L',
                'competitor_sku' => 'SK-AT5ULTRA-18L',
                'match_type' => 'direct',
                'gama' => 'Gama 5 años / Media',
                'technical_segmentation' => 'Impermeabilizantes de techo - Acrílicos fibratados',
                'strategic_analysis' => 'Cemix Fibratado 5 años mantiene una lectura competitiva por costo por m² frente a Sika Acril Techo 5 Ultra. La defensa comercial debe enfocarse en rendimiento por cubeta, precio efectivo y desempeño aplicado.',
                'priority' => 3,
            ],
            [
                'own_sku' => 'CX-IMPH-ECO-5Y-19L',
                'competitor_sku' => 'SK-ATGREEN-19L',
                'match_type' => 'direct',
                'gama' => 'Gama ecológica / Sustentable',
                'technical_segmentation' => 'Impermeabilizantes de techo - Acrílicos ecológicos',
                'strategic_analysis' => 'Comparación directa en línea ecológica de 19 litros. Cemix presenta menor precio y menor costo estimado por m² frente a Sika Green Power, por lo que puede defenderse con argumento de ahorro, rendimiento y enfoque sustentable.',
                'priority' => 4,
            ],
            [
                'own_sku' => 'CX-IMPH-FIB-7Y-19L',
                'competitor_sku' => 'SK-ATPOWER-6-8Y-19L',
                'match_type' => 'direct',
                'gama' => 'Alta duración / Premium',
                'technical_segmentation' => 'Impermeabilizantes de techo - Acrílicos alta duración',
                'strategic_analysis' => 'Comparación de alta duración. Cemix Fibratado 7 años compite contra Sika Acril Techo Power 6 y 8 años. Sika puede presionar desde garantía, pero Cemix conserva una oportunidad comercial por costo por m² y rendimiento.',
                'priority' => 5,
            ],
        ];
    }
}