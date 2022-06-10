<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{website_name}', [PostController::class, 'show']);
Route::post('posts/{website_name}', [PostController::class, 'create']);
Route::post('posts/{website_name}/subscribe', [SubscriptionController::class, 'store']);