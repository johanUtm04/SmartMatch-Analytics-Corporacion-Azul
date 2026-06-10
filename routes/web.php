<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EquivalenceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/analytics/view', [EquivalenceController::class, 'calculate']);