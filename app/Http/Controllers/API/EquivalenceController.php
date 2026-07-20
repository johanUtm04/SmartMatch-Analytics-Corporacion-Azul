<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SmartMatchService;
use Illuminate\Http\Request;
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

    public function matches(SmartMatchService $smartMatchService)
    {
        
    }
}