|<?php
use App\Http\Controllers\API\EquivalenceController;

Route::get('/metrics/equivalence', [EquivalenceController::class, 'calculate']);