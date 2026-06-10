<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquivalenceController extends Controller
{
    public function calculate()
    {
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

        $matchups = [];

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

        foreach ($matchups as $years => $segment) {
            foreach (['cemix', 'sika'] as $brandKey) {
                if (isset($segment[$brandKey])) {
                    $productId = $segment[$brandKey]->id;
                    $bucketPrice = $segment[$brandKey]->bucket_price;
                    $volumeLiters = $segment[$brandKey]->volume_liters ?? 19;

                    $performances = DB::table('product_performances')
                        ->where('product_id', $productId)
                        ->get();

                    foreach ($performances as $perf) {
                        $surfaceType = strtolower($perf->surface_type);
                        
                        $pricePerLiter = $bucketPrice / $volumeLiters;
                        $costPerM2 = $pricePerLiter * $perf->consumption_per_m2;

                        $matchups[$years][$brandKey]->surfaces[$surfaceType] = [
                            'consumption' => $perf->consumption_per_m2,
                            'cost_per_m2' => $costPerM2
                        ];
                    }
                }
            }
        }

        foreach ($matchups as $years => $segment) {
            if (isset($segment['cemix']) && isset($segment['sika'])) {
                
                foreach (['liso', 'rugoso'] as $surfaceType) {
                    $cemixCost = $segment['cemix']->surfaces[$surfaceType]['cost_per_m2'] ?? ($segment['cemix']->bucket_price / 55);
                    $sikaCost = $segment['sika']->surfaces[$surfaceType]['cost_per_m2'] ?? ($segment['sika']->bucket_price / 40);

                    $priceGap = $sikaCost - $cemixCost;
                    $percentageGap = $cemixCost > 0 ? ($priceGap / $cemixCost) * 100 : 0;
                    $isVulnerable = $percentageGap > 30;

                    $matchups[$years]['analysis'][$surfaceType] = [
                        'cemix_cost' => $cemixCost,
                        'sika_cost' => $sikaCost,
                        'price_gap' => $priceGap,
                        'percentage_gap' => $percentageGap,
                        'status' => $isVulnerable ? 'CRITICAL_VULNERABILITY' : 'STABLE_MARKET'
                    ];
                }
            }
        }

        return response()->view('equivalence', [
            'matchups' => $matchups,
            'calculated_at' => now()->toDateTimeString()
        ]);
    }
}