<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'verified'])->get('/user-detail', function (Request $request) {
    return response()->json([
        'message' => 'Detail User retrieved successfully',
        'user' => $request->user(),
    ]);
});

Route::get('/books', [BookController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/borrowings', [BorrowingController::class, 'store']);
});

require __DIR__.'/auth.php';