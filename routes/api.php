|<?php
use App\Http\Controllers\API\EquivalenceController;
use Illuminate\Support\Facades\Route;

// Registering the dynamic endpoint for the SmartMatch analytics matrix
Route::get('/v1/equivalence/calculate', [EquivalenceController::class, 'calculate']);