<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'verified'])->get('/user-detail', function (Request $request) {
    return response()->json([
        'message' => 'Detail User retrieved successfully',
        'user' => $request->user(),
    ]);
});

require __DIR__.'/auth.php';