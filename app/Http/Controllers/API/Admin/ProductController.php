<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = DB::table('products')
            //Join brands and products where products.brand_id = brands.id
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->leftJoin('product_performances', 'products.id', '=', 'product_performances.product_id')
                ->select(
                    'products.id',
                    'products.brand_id',
                    'brands.name as brand',
                    'products.sku',
                    'products.erp_name',
                    'products.technical_name',
                    'products.guarantee_years',
                    'products.volume_liters',
                    'products.base_type',
                    'products.is_fibrated',
                    'products.requires_separate_primer',
                    'product_prices.price',
                    'product_prices.currency',
                    'product_performances.surface_type',
                    'product_performances.consumption_per_m2',
                    'product_performances.min_coverage_m2',
                    'product_performances.max_coverage_m2'
                )
                ->orderBy('brands.name')
                ->orderBy('products.erp_name')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $products,
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error loading products.',
                'debug' => $exception->getMessage(),
            ], 500);
        }    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Product creation endpoint not implemented yet.',
        ], 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = DB::table('products')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->leftJoin('product_performances', 'products.id', '=', 'product_performances.product_id')
                ->where('products.id', $id)
                ->select(
                    'products.id',
                    'products.brand_id',
                    'brands.name as brand',
                    'products.sku',
                    'products.erp_name',
                    'products.technical_name',
                    'products.guarantee_years',
                    'products.volume_liters',
                    'products.base_type',
                    'products.is_fibrated',
                    'products.requires_separate_primer',
                    'product_prices.price',
                    'product_prices.currency',
                    'product_performances.surface_type',
                    'product_performances.consumption_per_m2',
                    'product_performances.min_coverage_m2',
                    'product_performances.max_coverage_m2'
                )
                ->first();

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $product,
            ], 200);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error loading product.',
                'debug' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Product update endpoint not implemented yet.',
        ], 501);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Product delete endpoint not implemented yet.',
        ], 501);
    }
}
