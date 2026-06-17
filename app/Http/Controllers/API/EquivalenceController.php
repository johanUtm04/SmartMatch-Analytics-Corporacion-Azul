<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquivalenceController extends Controller
{
    public function calculate()
    {
        // Traer los dos productos con sus relaciones de precio y rendimiento en una sola consulta estructurada
        $cemix = DB::table('products')
            ->join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_performances', 'products.id', '=', 'product_performances.product_id')
            ->where('products.sku', 'CX-IMPH-5Y')
            ->select('products.*', 'product_prices.price', 'product_performances.consumption_per_m2')
            ->first();

        $sika = DB::table('products')
            ->join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_performances', 'products.id', '=', 'product_performances.product_id')
            ->where('products.sku', 'SK-ATIH-5Y')
            ->select('products.*', 'product_prices.price', 'product_performances.consumption_per_m2')
            ->first();

        if (!$cemix || !$sika) {
            return response()->json([
                'status' => 'error',
                'message' => 'Faltan datos de los productos insignia en el sistema.'
            ], 404);
        }

        // Matriz de análisis basada en los costos de rendimiento por metro cuadrado
        // Costo por m² = (Precio Cubeta / Litros Totales) * Consumo por m²
        $cemix_cost_m2 = ($cemix->price / $cemix->volume_liters) * $cemix->consumption_per_m2;
        $sika_cost_m2 = ($sika->price / $sika->volume_liters) * $sika->consumption_per_m2;

        $price_gap = $sika_cost_m2 - $cemix_cost_m2;
        $percentage_gap = ($cemix_cost_m2 > 0) ? ($price_gap / $cemix_cost_m2) * 100 : 0;

        if (ob_get_length()) {
            ob_clean();
        }

        return response()->json([
            'status' => 'success',
            'calculated_at' => now()->toDateTimeString(),
            'battleground' => [
                'cemix' => [
                    'name' => $cemix->technical_name,
                    'sku' => $cemix->sku,
                    'bucket_price' => (float)$cemix->price,
                    'volume' => (float)$cemix->volume_liters,
                    'consumption' => (float)$cemix->consumption_per_m2,
                    'cost_m2' => round($cemix_cost_m2, 2)
                ],
                'sika' => [
                    'name' => $sika->technical_name,
                    'sku' => $sika->sku,
                    'bucket_price' => (float)$sika->price,
                    'volume' => (float)$sika->volume_liters,
                    'consumption' => (float)$sika->consumption_per_m2,
                    'cost_m2' => round($sika_cost_m2, 2)
                ],
                'analysis' => [
                    'price_gap' => round($price_gap, 2),
                    'percentage_gap' => round($percentage_gap, 1)
                ]
            ]
        ], 200);
    }
}