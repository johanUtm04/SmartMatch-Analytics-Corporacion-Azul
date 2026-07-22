<?php
use App\Http\Controllers\API\EquivalenceController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\EquivalenceMatchController;
use Illuminate\Support\Facades\Route;

// Registering the dynamic endpoint for the SmartMatch analytics matrix
Route::get('/v1/equivalence/calculate', [EquivalenceController::class, 'calculate']);

Route::get('/v1/equivalence/matches', [EquivalenceController::class, 'matches']);

Route::prefix('/v1/admin')->group(function () {
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/equivalence-matches', EquivalenceMatchController::class);
    
    Route::patch('/equivalence-matches/{id}/restore', [EquivalenceMatchController::class, 'restore']);
});