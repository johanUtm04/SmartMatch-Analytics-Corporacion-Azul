<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SmartMatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class EquivalenceController extends Controller
{
    public function calculate(Request $request, SmartMatchService $smartMatchService)
    {
        try {
            $areaM2 = (float) $request->query('area_m2', 500);

            /**
             * Mode 1:
             * Calculate using an official equivalence match ID.
             *
             * Example:
             * /api/v1/equivalence/calculate?match_id=32
             */
            if ($request->filled('match_id')) {
                $matchId = (int) $request->query('match_id');
                $result = $smartMatchService->calculateByMatchId($matchId, $areaM2);
                return response()->json($result, 200);
            }

            /**
             * Mode 2:
             * Calculate using dynamic SKUs.
             *
             * Example:
             * /api/v1/equivalence/calculate?own_sku=CX-IMPH-FIB-3Y-19L&competitor_sku=SK-AT3PRO-18L
             */
            if ($request->filled('own_sku') && $request->filled('competitor_sku')) {
                $ownSku = (string) $request->query('own_sku');
                $competitorSku = (string) $request->query('competitor_sku');

                $result = $smartMatchService->calculateBySkus(
                    $ownSku,
                    $competitorSku,
                    $areaM2
                );

                return response()->json($result, 200);
            }
            
        } catch (RuntimeException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], 404);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected SmartMatch calculation error.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }

    public function matches()
    {
        try {
            $matches = DB::table('equivalence_matches')
                ->join('products as own_products', 'equivalence_matches.own_product_id', '=', 'own_products.id')
                ->join('products as competitor_products', 'equivalence_matches.competitor_product_id', '=', 'competitor_products.id')
                ->where('equivalence_matches.is_active', true)
                ->select(
                    'equivalence_matches.id',
                    'equivalence_matches.match_type',
                    'equivalence_matches.gama',
                    'equivalence_matches.technical_segmentation',
                    'equivalence_matches.priority',
                    'own_products.erp_name as own_product',
                    'own_products.sku as own_sku',
                    'competitor_products.erp_name as competitor_product',
                    'competitor_products.sku as competitor_sku'
                )
                ->orderBy('equivalence_matches.priority')
                ->get()
                ->map(function ($match) {
                    return [
                        'id' => $match->id,
                        'label' => $match->own_product . ' vs ' . $match->competitor_product,
                        'own_product' => $match->own_product,
                        'own_sku' => $match->own_sku,
                        'competitor_product' => $match->competitor_product,
                        'competitor_sku' => $match->competitor_sku,
                        'gama' => $match->gama,
                        'match_type' => $match->match_type,
                        'technical_segmentation' => $match->technical_segmentation,
                        'priority' => $match->priority,
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $matches,
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error loading SmartMatch matches.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }
}