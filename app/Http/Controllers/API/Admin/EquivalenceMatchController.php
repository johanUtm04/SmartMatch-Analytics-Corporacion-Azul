<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Import the request validation classes
use App\Http\Requests\StoreEquivalenceMatchRequest;
use App\Http\Requests\UpdateEquivalenceMatchRequest;

use Throwable;

class EquivalenceMatchController extends Controller
{
    public function index()
    {
        try {
            $matches = DB::table('equivalence_matches')
                ->join('products as own_products', 'equivalence_matches.own_product_id', '=', 'own_products.id')
                ->join('products as competitor_products', 'equivalence_matches.competitor_product_id', '=', 'competitor_products.id')
                ->select(
                    'equivalence_matches.id',
                    'equivalence_matches.own_product_id',
                    'equivalence_matches.competitor_product_id',
                    'equivalence_matches.match_type',
                    'equivalence_matches.gama',
                    'equivalence_matches.technical_segmentation',
                    'equivalence_matches.strategic_analysis',
                    'equivalence_matches.priority',
                    'equivalence_matches.is_active',
                    'own_products.sku as own_sku',
                    'own_products.erp_name as own_product',
                    'competitor_products.sku as competitor_sku',
                    'competitor_products.erp_name as competitor_product'
                )
                ->orderBy('equivalence_matches.priority')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $matches,
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error loading equivalence matches.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }

public function store(StoreEquivalenceMatchRequest $request)
{
    try {
        $validated = $request->validated();

        $duplicateExists = DB::table('equivalence_matches')
            ->where('own_product_id', $validated['own_product_id'])
            ->where('competitor_product_id', $validated['competitor_product_id'])
            ->exists();

        if ($duplicateExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This equivalence match already exists.',
            ], 409);
        }

        $matchId = DB::table('equivalence_matches')->insertGetId([
            'own_product_id' => $validated['own_product_id'],
            'competitor_product_id' => $validated['competitor_product_id'],
            'match_type' => $validated['match_type'],
            'gama' => $validated['gama'],
            'technical_segmentation' => $validated['technical_segmentation'],
            'strategic_analysis' => $validated['strategic_analysis'],
            'priority' => $validated['priority'],
            'is_active' => $validated['is_active'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Equivalence match created successfully.',
            'data' => [
                'id' => $matchId,
            ],
        ], 201);
    } catch (Throwable $exception) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error creating equivalence match.',
            'debug' => $exception->getMessage(),
        ], 500);
    }
}

    public function show(string $id)
    {
        try {
            $match = DB::table('equivalence_matches')
                ->join('products as own_products', 'equivalence_matches.own_product_id', '=', 'own_products.id')
                ->join('products as competitor_products', 'equivalence_matches.competitor_product_id', '=', 'competitor_products.id')
                ->where('equivalence_matches.id', $id)
                ->select(
                    'equivalence_matches.id',
                    'equivalence_matches.own_product_id',
                    'equivalence_matches.competitor_product_id',
                    'equivalence_matches.match_type',
                    'equivalence_matches.gama',
                    'equivalence_matches.technical_segmentation',
                    'equivalence_matches.strategic_analysis',
                    'equivalence_matches.priority',
                    'equivalence_matches.is_active',
                    'own_products.sku as own_sku',
                    'own_products.erp_name as own_product',
                    'competitor_products.sku as competitor_sku',
                    'competitor_products.erp_name as competitor_product'
                )
                ->first();

            if (!$match) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Equivalence match not found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $match,
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error loading equivalence match.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateEquivalenceMatchRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $matchExists = DB::table('equivalence_matches')
                ->where('id', $id)
                ->exists();

            if (!$matchExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Equivalence match not found.',
                ], 404);
            }

            $duplicateExists = DB::table('equivalence_matches')
                ->where('own_product_id', $validated['own_product_id'])
                ->where('competitor_product_id', $validated['competitor_product_id'])
                ->where('id', '!=', $id)
                ->exists();

            if ($duplicateExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Another equivalence match with these products already exists.',
                ], 409);
            }

            DB::table('equivalence_matches')
                ->where('id', $id)
                ->update([
                    'own_product_id' => $validated['own_product_id'],
                    'competitor_product_id' => $validated['competitor_product_id'],
                    'match_type' => $validated['match_type'],
                    'gama' => $validated['gama'],
                    'technical_segmentation' => $validated['technical_segmentation'],
                    'strategic_analysis' => $validated['strategic_analysis'],
                    'priority' => $validated['priority'],
                    'is_active' => $validated['is_active'],
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Equivalence match updated successfully.',
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error updating equivalence match.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $match = DB::table('equivalence_matches')
                ->where('id', $id)
                ->first();

                if (!$match){
                    return response ()->json([
                        'status' => 'error',
                        'message' => 'Equivalence match not found. '
                    ], 404);
                }

            DB::table('equivalence_matches')
                ->where('id', $id)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Equivalence match deactivated successfully.',
                ], 200);
            }catch (Throwable $exception) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unexpected error deactivating equivalence match.',
                    'debug' => $exception->getMessage(),
                ], 500);
            }
}

    public function restore(string $id)
    {
        try {
            $match = DB::table('equivalence_matches')
                ->where('id', $id)
                ->first();

            if (!$match) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Equivalence match not found.',
                ], 404);
            }

            DB::table('equivalence_matches')
                ->where('id', $id)
                ->update([
                    'is_active' => true,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Equivalence match restored successfully.',
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error restoring equivalence match.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }
}