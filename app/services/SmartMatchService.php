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

                'analysis' => array_merge([
                    'winner' => $winner,
                    'price_gap_m2' => round($gap, 2),
                    'percentage_gap' => round($percentageGap, 1),
                    'advantage_percentage' => round(abs($percentageGap), 1),
                    'difference_total_investment' => round(($competitorCostM2 - $ownCostM2) * $areaM2, 2),
                ], 
                //We save the strategic fields in a separate method
                $this->buildStrategicFields(
                    $winner,
                    $ownProduct,
                    $competitorProduct,
                    $ownCostM2,
                    $competitorCostM2,
                    $areaM2
                )),
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

    private function buildStrategicFields(
    string $winner,
    object $ownProduct,
    object $competitorProduct,
    float $ownCostM2,
    float $competitorCostM2,
    float $areaM2
): array {
    $advantagePercentage = $ownCostM2 > 0
        ? abs((($competitorCostM2 - $ownCostM2) / $ownCostM2) * 100)
        : 0;

    $differenceTotalInvestment = ($competitorCostM2 - $ownCostM2) * $areaM2;

    $targetPrice = $this->calculateTargetPrice(
        $competitorCostM2,
        (float) $ownProduct->volume_liters,
        (float) $ownProduct->consumption_per_m2
    );

    $requiredAdjustment = (float) $ownProduct->price - $targetPrice;

    return [
        'commercial_status' => $this->getCommercialStatus($winner),
        'risk_level' => $this->getRiskLevel($winner, $advantagePercentage),
        'recommended_action' => $this->getRecommendedAction($winner, $advantagePercentage),
        'pricing_recommendation' => $this->getPricingRecommendation(
            $winner,
            (float) $ownProduct->price,
            $targetPrice,
            $requiredAdjustment
        ),
        'target_price' => round($targetPrice, 2),
        'required_adjustment' => round($requiredAdjustment, 2),
        'executive_summary' => $this->getExecutiveSummary(
            $winner,
            $ownProduct,
            $competitorProduct,
            $advantagePercentage,
            $differenceTotalInvestment,
            $areaM2
        ),
        'sales_argument' => $this->getSalesArgument(
            $winner,
            $ownProduct,
            $competitorProduct,
            $advantagePercentage,
            $differenceTotalInvestment,
            $areaM2
        ),
    ];
}

private function calculateTargetPrice(
    float $competitorCostM2,
    float $ownVolumeLiters,
    float $ownConsumptionPerM2
): float {
    if ($competitorCostM2 <= 0 || $ownVolumeLiters <= 0 || $ownConsumptionPerM2 <= 0) {
        return 0;
    }

    return ($competitorCostM2 * $ownVolumeLiters) / $ownConsumptionPerM2;
}

private function getCommercialStatus(string $winner): string
{
    return match ($winner) {
        'own_product' => 'advantage',
        'competitor_product' => 'risk',
        'tie' => 'parity',
        default => 'insufficient_data',
    };
}

private function getRiskLevel(string $winner, float $advantagePercentage): string
{
    if ($winner === 'insufficient_data') {
        return 'undefined';
    }

    if ($winner === 'own_product') {
        if ($advantagePercentage >= 30) {
            return 'low';
        }

        if ($advantagePercentage >= 10) {
            return 'medium_low';
        }

        return 'competitive_watch';
    }

    if ($winner === 'competitor_product') {
        if ($advantagePercentage >= 30) {
            return 'high';
        }

        if ($advantagePercentage >= 10) {
            return 'medium';
        }

        return 'low';
    }

    return 'neutral';
}

private function getRecommendedAction(string $winner, float $advantagePercentage): string
{
    if ($winner === 'own_product') {
        if ($advantagePercentage >= 30) {
            return 'Usar la ventaja de costo por m² como argumento comercial principal. Reforzar comunicación de ahorro, rendimiento y menor inversión total.';
        }

        return 'Defender la posición actual con mensajes de valor, disponibilidad y respaldo técnico. Mantener vigilancia de precio contra competencia.';
    }

    if ($winner === 'competitor_product') {
        if ($advantagePercentage >= 30) {
            return 'Revisar precio objetivo de Cemix de forma prioritaria. Evaluar ajuste comercial, paquete promocional o argumento de valor agregado.';
        }

        return 'Monitorear el diferencial y preparar una estrategia de defensa con precio, disponibilidad, garantía o soporte técnico.';
    }

    if ($winner === 'tie') {
        return 'La comparación está en paridad. La estrategia debe enfocarse en confianza de marca, disponibilidad, garantía, soporte técnico y facilidad de aplicación.';
    }

    return 'Completar o validar datos de precio, volumen y rendimiento antes de tomar una decisión comercial.';
}

private function getPricingRecommendation(
    string $winner,
    float $ownPrice,
    float $targetPrice,
    float $requiredAdjustment
): string {
    if ($winner === 'own_product') {
        return 'No se requiere ajuste de precio inmediato. Cemix conserva ventaja por costo por m² frente a la competencia.';
    }

    if ($winner === 'competitor_product') {
        if ($targetPrice <= 0) {
            return 'No es posible calcular precio objetivo por falta de datos completos.';
        }

        if ($requiredAdjustment > 0) {
            return 'Para igualar el costo por m² de la competencia, Cemix debería evaluar un precio objetivo aproximado de $'
                . number_format($targetPrice, 2)
                . ' MXN, equivalente a un ajuste de $'
                . number_format($requiredAdjustment, 2)
                . ' MXN sobre el precio actual.';
        }

        return 'Cemix ya se encuentra por debajo del precio objetivo estimado. Revisar si el diferencial viene de rendimiento, no de precio.';
    }

    if ($winner === 'tie') {
        return 'No se requiere ajuste inmediato. La decisión comercial puede basarse en valor agregado y disponibilidad.';
    }

    return 'No hay datos suficientes para emitir una recomendación de precio.';
}

private function getExecutiveSummary(
    string $winner,
    object $ownProduct,
    object $competitorProduct,
    float $advantagePercentage,
    float $differenceTotalInvestment,
    float $areaM2
): string {
    $ownName = $ownProduct->technical_name;
    $competitorName = $competitorProduct->technical_name;

    if ($winner === 'own_product') {
        return "{$ownName} tiene ventaja comercial frente a {$competitorName}, con una diferencia estimada de {$advantagePercentage}% en costo por m². Para una obra de {$areaM2} m², Cemix representa un ahorro aproximado de $"
            . number_format(abs($differenceTotalInvestment), 2)
            . " MXN.";
    }

    if ($winner === 'competitor_product') {
        return "{$competitorName} tiene ventaja comercial frente a {$ownName}, con una diferencia estimada de {$advantagePercentage}% en costo por m². Para una obra de {$areaM2} m², la competencia representa una inversión menor aproximada de $"
            . number_format(abs($differenceTotalInvestment), 2)
            . " MXN.";
    }

    if ($winner === 'tie') {
        return "{$ownName} y {$competitorName} se encuentran en paridad de costo por m². La decisión comercial dependerá de disponibilidad, confianza, garantía y soporte técnico.";
    }

    return 'No hay datos suficientes para generar un resumen ejecutivo confiable.';
}

private function getSalesArgument(
    string $winner,
    object $ownProduct,
    object $competitorProduct,
    float $advantagePercentage,
    float $differenceTotalInvestment,
    float $areaM2
): string {
    $ownName = $ownProduct->technical_name;
    $competitorName = $competitorProduct->technical_name;

    if ($winner === 'own_product') {
        return "Argumento de venta: {$ownName} ofrece una mejor relación costo-rendimiento que {$competitorName}. En una superficie de {$areaM2} m², el cliente puede reducir su inversión aproximada en $"
            . number_format(abs($differenceTotalInvestment), 2)
            . " MXN, manteniendo una solución competitiva para impermeabilización.";
    }

    if ($winner === 'competitor_product') {
        return "Argumento defensivo: {$competitorName} presenta una ventaja de costo por m² de {$advantagePercentage}%. Para competir, Cemix debe reforzar disponibilidad, respaldo técnico, garantía, confianza de marca o revisar una estrategia de precio objetivo.";
    }

    if ($winner === 'tie') {
        return "Argumento de venta: ambos productos están muy cercanos en costo por m². La recomendación es vender por confianza, disponibilidad, garantía, asesoría técnica y experiencia de aplicación.";
    }

    return 'No hay datos suficientes para construir un argumento comercial confiable.';
}

    public function calculateBySkus(string $ownSku, string $competitorSku, float $areaM2 = 500): array
    {
        $match = DB::table('equivalence_matches')
            ->join('products as own_products', 
                'equivalence_matches.own_product_id', '=', 'own_products.id')
            ->join('products as competitor_products', 
            'equivalence_matches.competitor_product_id', '=', 'competitor_products.id')
            ->where('own_products.sku', $ownSku)
            ->where('competitor_products.sku', $competitorSku)
            ->where('equivalence_matches.is_active', true)
            ->select('equivalence_matches.*')
            ->first();

        if (!$match) {
            throw new RuntimeException('Equivalence match not found for the provided SKUs.');
        }

        return $this->calculateByMatchId((int) $match->id, $areaM2);
    }
    
}