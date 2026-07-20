<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function store(Request $request)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Equivalence match creation endpoint not implemented yet.',
        ], 501);
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

    public function update(Request $request, string $id)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Equivalence match update endpoint not implemented yet.',
        ], 501);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Equivalence match delete endpoint not implemented yet.',
        ], 501);
    }
}