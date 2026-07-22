<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Import the request validation classes
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

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
public function store(StoreProductRequest $request)
{
    try {
        $validated = $request->validated();

        $productId = DB::transaction(function () use ($validated) {
            $productId = DB::table('products')->insertGetId([
                'brand_id' => $validated['brand_id'],
                'sku' => $validated['sku'],
                'erp_name' => $validated['erp_name'],
                'technical_name' => $validated['technical_name'],
                'guarantee_years' => $validated['guarantee_years'] ?? 0,
                'volume_liters' => $validated['volume_liters'],
                'base_type' => $validated['base_type'] ?? null,
                'is_fibrated' => $validated['is_fibrated'],
                'requires_separate_primer' => $validated['requires_separate_primer'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_prices')->insert([
                'product_id' => $productId,
                'price' => $validated['price'],
                'currency' => strtoupper($validated['currency']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_performances')->insert([
                'product_id' => $productId,
                'surface_type' => $validated['surface_type'] ?? 'general',
                'consumption_per_m2' => $validated['consumption_per_m2'],
                'min_coverage_m2' => $validated['min_coverage_m2'],
                'max_coverage_m2' => $validated['max_coverage_m2'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $productId;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'data' => [
                'id' => $productId,
            ],
        ], 201);
    } catch (Throwable $exception) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error creating product.',
            'debug' => $exception->getMessage(),
        ], 500);
    }
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
public function update(UpdateProductRequest $request, string $id)
{
    try {
        $validated = $request->validated();

        $productExists = DB::table('products')
            ->where('id', $id)
            ->exists();

        if (!$productExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found.',
            ], 404);
        }

        DB::transaction(function () use ($validated, $id) {
            DB::table('products')
                ->where('id', $id)
                ->update([
                    'brand_id' => $validated['brand_id'],
                    'sku' => $validated['sku'],
                    'erp_name' => $validated['erp_name'],
                    'technical_name' => $validated['technical_name'],
                    'guarantee_years' => $validated['guarantee_years'] ?? 0,
                    'volume_liters' => $validated['volume_liters'],
                    'base_type' => $validated['base_type'] ?? null,
                    'is_fibrated' => $validated['is_fibrated'],
                    'requires_separate_primer' => $validated['requires_separate_primer'],
                    'updated_at' => now(),
                ]);

            DB::table('product_prices')->updateOrInsert(
                ['product_id' => $id],
                [
                    'price' => $validated['price'],
                    'currency' => strtoupper($validated['currency']),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('product_performances')->updateOrInsert(
                ['product_id' => $id],
                [
                    'surface_type' => $validated['surface_type'] ?? 'general',
                    'consumption_per_m2' => $validated['consumption_per_m2'],
                    'min_coverage_m2' => $validated['min_coverage_m2'],
                    'max_coverage_m2' => $validated['max_coverage_m2'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
        ], 200);
    } catch (Throwable $exception) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error updating product.',
            'debug' => $exception->getMessage(),
        ], 500);
    }
}

public function destroy(string $id)
{
    try {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found.',
            ], 404);
        }

        $isUsedInMatches = DB::table('equivalence_matches')
            ->where('own_product_id', $id)
            ->orWhere('competitor_product_id', $id)
            ->exists();

        if ($isUsedInMatches) {
            return response()->json([
                'status' => 'error',
                'message' => 'This product cannot be deleted because it is used in one or more equivalence matches. Deactivate or update those matches first.',
            ], 409);
        }

        DB::transaction(function () use ($id) {
            DB::table('product_performances')
                ->where('product_id', $id)
                ->delete();

            DB::table('product_prices')
                ->where('product_id', $id)
                ->delete();

            DB::table('products')
                ->where('id', $id)
                ->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.',
        ], 200);
    } catch (Throwable $exception) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error deleting product.',
            'debug' => $exception->getMessage(),
        ], 500);
    }
}
}
