<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;


Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'edit']);
});
Route::post('/mypage/profile', [UserController::class, 'update']);
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::middleware('auth')->group(function () {
    Route::post('/like', [LikeController::class, 'store']);
    Route::delete('/like', [LikeController::class, 'destroy']);
});
Route::middleware('auth')->group(function () {
    Route::post('/comment', [CommentController::class, 'store']);
});
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
});
Route::middleware('auth')->group(function () {
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
});
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [UserController::class, 'show']);
});