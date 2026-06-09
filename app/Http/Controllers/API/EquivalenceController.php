<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquivalenceController extends Controller
{
    public function calculate()
    {
        // 1. Bring the products
        $products = DB::table('products as p')
            ->join('brands as b', 'p.brand_id', '=', b.id')
            ->select('p.id', 'p.sku', 'p.technical_name', 'b.name as brand_name', 'p.volume_liters')
            ->get();

        $response = [];

        // 2. Bring the latest price registered for this product
        foreach ($products as $product) {
            $latestPrice = DB::table('product_prices')
                ->where('product_id', $product->id)
                ->orderBy('registered_at', 'desc')
                ->first();

            $price = $latestPrice ? (float)$latestPrice->price : 0;

            // 3. Bring the performances/coverages according to the surface (smooth/rough/general)
            $performances = DB::table('product_performances')
                ->where('product_id', $product->id)
                ->get();

            $surfaceCalculations = [];

            foreach ($performances as $perf) {
                //The mathematics: Cost = Bucket price / Square meters of coverage
                // The worst scenario uses the minimum performance (spends more product)
                $costWorst = $perf->min_coverage_m2 > 0 ? $price / $perf->min_coverage_m2 : 0;
                // The best scenario uses the maximum performance (performs better)
                $costBest = $perf->max_coverage_m2 > 0 ? $price / $perf->max_coverage_m2 : 0;

                $surfaceCalculations[] = [
                    'surface_type' => $perf->surface_type,
                    'min_m2' => (float)$perf->min_coverage_m2,
                    'max_m2' => (float)$perf->max_coverage_m2,
                    'cost_per_m2' => [
                        'best_case' => round($costBest, 2),
                        'worst_case' => round($costWorst, 2)
                    ]
                ];
            }

            // 4. Structure the output JSON of this product
            $response[] = [
                'sku' => $product->sku,
                'brand' => $product->brand_name,
                'name' => $product->technical_name,
                'bucket_price' => $price,
                'volume_liters' => (float)$product->volume_liters,
                'surfaces' => $surfaceCalculations
            ];
        }

        // Return the clean response
        return response()->json([
            'status' => 'success',
            'calculated_at' => now()->toDateTimeString(),
            'products' => $response
        ]);
    }
}