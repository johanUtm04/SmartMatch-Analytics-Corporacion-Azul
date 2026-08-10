<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Import the request validation classes
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

//query builder
use Illuminate\Database\Query\Builder;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all products with their associated brand names, prices, and performance data 
        // because of productQuery() method, we can reuse the query for other methods like show, update, etc.
        $products = $this->productQuery()
            ->orderBy('brands.name')
            ->orderBy('products.erp_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], 200);
    }

    public function store(StoreProductRequest $request)
    {
            $validated = $request->validated();

            $productId = DB::transaction(function () use ($validated) {
                $productId = DB::table('products')->insertGetId([
                    ...$this->productData($validated),
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $product = $this->productQuery()
                ->where('products.id', $id)
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
    }

        public function update(UpdateProductRequest $request, string $id)
        {
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
                    ...$this->productData($validated),
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
        }

    public function destroy(string $id)
    {
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
    }

    public function restore(string $id)
    {
        try {
            $match = DB::table('products')
                ->where('id', $id)
                ->first();

            if (!$match) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
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
            ], 500);
        }
    }

private function productQuery(): Builder
    {
        return DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin(
                'product_prices',
                'products.id',
                '=',
                'product_prices.product_id'
            )
            ->leftJoin(
                'product_performances',
                'products.id',
                '=',
                'product_performances.product_id'
            )
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
            );
    }

private function productData(array $validated): array
    {
        return [
            'brand_id' => $validated['brand_id'],
            'sku' => $validated['sku'],
            'erp_name' => $validated['erp_name'],
            'technical_name' => $validated['technical_name'],
            'guarantee_years' => $validated['guarantee_years'] ?? 0,
            'volume_liters' => $validated['volume_liters'],
            'base_type' => $validated['base_type'] ?? null,
            'is_fibrated' => $validated['is_fibrated'],
            'requires_separate_primer' =>
                $validated['requires_separate_primer'],
        ];
    }

}
