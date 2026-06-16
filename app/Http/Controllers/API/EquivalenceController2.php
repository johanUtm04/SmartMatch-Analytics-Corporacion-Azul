<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquivalenceController extends Controller
{
    public function calculate()
    {
        // 1. Fetch products with their price data in ONE query
        $products = DB::table('products as p')
            ->join('brands as b', 'p.brand_id', '=', 'b.id')
            ->join('product_prices as pp', 'p.id', '=', 'pp.product_id')
            ->select(
                'p.id', 
                'p.sku', 
                'p.technical_name', 
                'b.name as brand_name', 
                'p.volume_liters',
                'pp.price as bucket_price',
                'p.guarantee_years'
            )
            ->get();

        // OPTIMIZATION: Extract all product IDs to fetch all performances in ONE single query
        $productIds = $products->pluck('id')->toArray();
        
        $allPerformances = DB::table('product_performances')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id'); // Groups them by product_id automatically

        $matchups = [];

        // 2. Map products into segments based on guarantee years
        foreach ($products as $product) {
            $years = $product->guarantee_years ?? 3; 
            $brand = strtoupper($product->brand_name ?? '');

            $product->surfaces = [];

            if ($brand === 'CEMIX') {
                $matchups[$years]['cemix'] = $product;
            } elseif ($brand === 'SIKA') {
                $matchups[$years]['sika'] = $product;
            }
        }

        // 3. Attach performances using the pre-fetched memory cache (No more loops running queries)
        foreach ($matchups as $years => $segment) {
            foreach (['cemix', 'sika'] as $brandKey) {
                if (isset($segment[$brandKey])) {
                    $productId = $segment[$brandKey]->id;
                    $bucketPrice = $segment[$brandKey]->bucket_price;
                    $volumeLiters = $segment[$brandKey]->volume_liters ?? 19;

                    // Get performances from our collection in memory, avoiding database hits
                    $performances = $allPerformances->get($productId) ?? collect();

                    foreach ($performances as $perf) {
                        $surfaceType = strtolower($perf->surface_type);
                        
                        $pricePerLiter = $bucketPrice / $volumeLiters;
                        $costPerM2 = $pricePerLiter * $perf->consumption_per_m2;

                        $matchups[$years][$brandKey]->surfaces[$surfaceType] = [
                            'consumption' => (float)$perf->consumption_per_m2,
                            'cost_per_m2' => (float)$costPerM2
                        ];
                    }
                }
            }
        }

        // 4. Calculate Market Gaps and Vulnerabilities
        foreach ($matchups as $years => $segment) {
            if (isset($segment['cemix']) && isset($segment['sika'])) {
                
                foreach (['liso', 'rugoso'] as $surfaceType) {
                    // Safe fallbacks to prevent crashes if seeders generate incomplete surface data
                    $cemixCost = $segment['cemix']->surfaces[$surfaceType]['cost_per_m2'] ?? ($segment['cemix']->bucket_price / 55);
                    $sikaCost = $segment['sika']->surfaces[$surfaceType]['cost_per_m2'] ?? ($segment['sika']->bucket_price / 40);

                    $priceGap = $sikaCost - $cemixCost;
                    $percentageGap = $cemixCost > 0 ? ($priceGap / $cemixCost) * 100 : 0;
                    $isVulnerable = $percentageGap > 30;

                    $matchups[$years]['analysis'][$surfaceType] = [
                        'cemix_cost' => (float)$cemixCost,
                        'sika_cost' => (float)$sikaCost,
                        'price_gap' => (float)$priceGap,
                        'percentage_gap' => (float)$percentageGap,
                        'status' => $isVulnerable ? 'CRITICAL_VULNERABILITY' : 'STABLE_MARKET'
                    ];
                }
            }
        }

        // CORRECTION: Return raw JSON response for React instead of a Blade view template
        return response()->json([
            'status' => 'success',
            'calculated_at' => now()->toDateTimeString(),
            'matchups' => $matchups
        ], 200);
    }
}