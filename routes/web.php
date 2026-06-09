<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EquivalenceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/analytics/view', function () {
    // Instantiate the controller and decode its JSON output to pass it directly
    $controller = app(EquivalenceController::class);
    $data = json_decode($controller->calculate()->getContent(), true);

    return view('equivalence', [
        'products' => $data['products'],
        'calculated_at' => $data['calculated_at']
    ]);
});