<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EquivalenceController;

Route::get('/', function () {
    return view('portal');
});

Route::get('/smartmatch', function () {
    return view('dashboard');
});

Route::get('/admin', function () {
    return view('admin');
});