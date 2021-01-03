<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CookApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShoppingCartController;


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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return User::with('customer')->where('id', $request->user()->id)->first();
    });

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('updateuser', [UserApiController::class, 'update_user']);

    Route::put('changepassword', [UserApiController::class, 'update_password']);

    Route::put('removeavatar', [UserApiController::class, 'remove_avatar']);

    Route::post('confirmorder', [ShoppingCartController::class, 'confirmOrder']);

    Route::get('cookdashboard', [CookApiController::class, 'index']);

    Route::get('orders', [OrderController::class, 'index']);

    Route::get('my_orders', [OrderController::class, 'myOrders']);

    Route::get('order_history', [OrderController::class, 'orderHistory']);

    Route::get('checkorder/{order_id}', [ShoppingCartController::class, 'checkOrderCook']);

    Route::get('getReadyOrders', [OrderController::class, 'getReadyOrders']);

    Route::get('currently_delivering', [OrderController::class, 'getOrderCurrentlyDelivering']);

    Route::get('availability', [UserApiController::class, 'getDeliverAvailability']);

    Route::put('deliverorder', [OrderController::class, 'assignOrderToDeliver']);

    Route::put('orderDelivered', [OrderController::class, 'orderDelivered']);

    Route::put('orderPrepared', [OrderController::class, 'orderPrepared']);
});

Route::get('getproducts/{order_id}', [OrderController::class, 'getProducts']);

Route::post('login', [AuthController::class, 'authenticate']);

Route::get('products', [ProductController::class, 'index']);

Route::post('register', [AuthController::class, 'register']);

Route::put('updateAvailability', [UserApiController::class, 'updateAvailability']);

Route::put('updateLoggedAt', [UserApiController::class, 'updateLoggedAt']);


