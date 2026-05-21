<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| 商品一覧・詳細
|--------------------------------------------------------------------------
*/

Route::get('/', [ItemController::class, 'index']);

Route::get('/item/{item_id}', [ItemController::class, 'show']);

/*
|--------------------------------------------------------------------------
| ログイン必須
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | マイページ
    |--------------------------------------------------------------------------
    */

    Route::get('/mypage', [UserController::class, 'show']);

    Route::get('/mypage/profile', [UserController::class, 'edit']);

    Route::post('/mypage/profile', [UserController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | いいね
    |--------------------------------------------------------------------------
    */

    Route::post('/like', [LikeController::class, 'store']);

    Route::delete('/like', [LikeController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | コメント
    |--------------------------------------------------------------------------
    */

    Route::post('/comment', [CommentController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | 購入
    |--------------------------------------------------------------------------
    */

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show']);

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address']);

    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);

    /*
    |--------------------------------------------------------------------------
    | 出品
    |--------------------------------------------------------------------------
    */

    Route::get('/sell', [ItemController::class, 'create']);

    Route::post('/sell', [ItemController::class, 'store']);
});