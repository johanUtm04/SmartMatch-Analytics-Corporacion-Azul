<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use RuntimeException;

class SmartMatchService
{
    /**
     * Calculate a SmartMatch battle using an equivalence match ID.
     */
    public function calculateByMatchId(int $matchId, float $areaM2 = 500): array
    {
        $match = DB::table('equivalence_matches')
            ->where('id', $matchId)
            ->where('is_active', true)
            ->first();

        if (!$match) {
            throw new RuntimeException('Equivalence match not found or inactive.');
        }

        $ownProduct = $this->getProductData((int) $match->own_product_id);
        $competitorProduct = $this->getProductData((int) $match->competitor_product_id);

        $ownCostM2 = $this->calculateCostPerM2(
            (float) $ownProduct->price,
            (float) $ownProduct->volume_liters,
            (float) $ownProduct->consumption_per_m2
        );

        $competitorCostM2 = $this->calculateCostPerM2(
            (float) $competitorProduct->price,
            (float) $competitorProduct->volume_liters,
            (float) $competitorProduct->consumption_per_m2
        );

        $gap = $competitorCostM2 - $ownCostM2;

        $percentageGap = $ownCostM2 > 0
            ? ($gap / $ownCostM2) * 100
            : 0;

        $winner = $this->detectWinner($ownCostM2, $competitorCostM2);

        return [
            'status' => 'success',
            'calculated_at' => now()->toDateTimeString(),

            'match' => [
                'id' => $match->id,
                'match_type' => $match->match_type,
                'gama' => $match->gama,
                'technical_segmentation' => $match->technical_segmentation,
                'strategic_analysis' => $match->strategic_analysis,
                'priority' => $match->priority,
            ],

            'battlefield' => [
                'area_m2' => $areaM2,

                'own_product' => [
                    'id' => $ownProduct->id,
                    'brand' => $ownProduct->brand_name,
                    'name' => $ownProduct->technical_name,
                    'erp_name' => $ownProduct->erp_name,
                    'sku' => $ownProduct->sku,
                    'bucket_price' => (float) $ownProduct->price,
                    'currency' => $ownProduct->currency,
                    'volume_liters' => (float) $ownProduct->volume_liters,
                    'consumption_per_m2' => (float) $ownProduct->consumption_per_m2,
                    'min_coverage_m2' => (float) $ownProduct->min_coverage_m2,
                    'max_coverage_m2' => (float) $ownProduct->max_coverage_m2,
                    'cost_m2' => round($ownCostM2, 2),
                    'total_investment' => round($ownCostM2 * $areaM2, 2),
                ],

                'competitor_product' => [
                    'id' => $competitorProduct->id,
                    'brand' => $competitorProduct->brand_name,
                    'name' => $competitorProduct->technical_name,
                    'erp_name' => $competitorProduct->erp_name,
                    'sku' => $competitorProduct->sku,
                    'bucket_price' => (float) $competitorProduct->price,
                    'currency' => $competitorProduct->currency,
                    'volume_liters' => (float) $competitorProduct->volume_liters,
                    'consumption_per_m2' => (float) $competitorProduct->consumption_per_m2,
                    'min_coverage_m2' => (float) $competitorProduct->min_coverage_m2,
                    'max_coverage_m2' => (float) $competitorProduct->max_coverage_m2,
                    'cost_m2' => round($competitorCostM2, 2),
                    'total_investment' => round($competitorCostM2 * $areaM2, 2),
                ],

                'analysis' => [
                    'winner' => $winner,
                    'price_gap_m2' => round($gap, 2),
                    'percentage_gap' => round($percentageGap, 1),
                    'advantage_percentage' => round(abs($percentageGap), 1),
                    'difference_total_investment' => round(($competitorCostM2 - $ownCostM2) * $areaM2, 2),
                ],
            ],
        ];
    }

    /**
     * Get product data with brand, price and performance.
     */
    private function getProductData(int $productId): object
    {
        $product = DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_performances', 'products.id', '=', 'product_performances.product_id')
            ->where('products.id', $productId)
            ->select(
                'products.*',
                'brands.name as brand_name',
                'product_prices.price',
                'product_prices.currency',
                'product_performances.consumption_per_m2',
                'product_performances.min_coverage_m2',
                'product_performances.max_coverage_m2'
            )
            ->first();

        if (!$product) {
            throw new RuntimeException("Product data not found for product ID: {$productId}");
        }

        return $product;
    }

    /**
     * Cost per m² = (bucket price / liters) * consumption per m².
     */
    private function calculateCostPerM2(float $price, float $volumeLiters, float $consumptionPerM2): float
    {
        if ($price <= 0 || $volumeLiters <= 0 || $consumptionPerM2 <= 0) {
            return 0;
        }

        return ($price / $volumeLiters) * $consumptionPerM2;
    }

    /**
     * Detect which product has the lower cost per m².
     */
    private function detectWinner(float $ownCostM2, float $competitorCostM2): string
    {
        if ($ownCostM2 <= 0 || $competitorCostM2 <= 0) {
            return 'insufficient_data';
        }

        if ($ownCostM2 < $competitorCostM2) {
            return 'own_product';
        }

        if ($competitorCostM2 < $ownCostM2) {
            return 'competitor_product';
        }

        return 'tie';
    }
}