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

            $matchId = (int) $request->query('match_id', 31);
            $areaM2 = (float) $request->query('area_m2', 500);

            $result = $smartMatchService->calculateByMatchId($matchId, $areaM2);

            return response()->json($result, 200);
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
}