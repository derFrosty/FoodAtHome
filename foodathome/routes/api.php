<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

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

//Route::middleware('Auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return User::with('customer')->where('id', $request->user()->id)->first();
});

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::post('login', [AuthController::class, 'authenticate']);

Route::get('products', [ProductController::class, 'index']);

Route::post('register', [AuthController::class, 'register']);

