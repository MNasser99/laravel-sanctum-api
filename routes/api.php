<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

// Public Routes
// This skips through making all the individual crud routes. This only works for basic and conventional crud methods, that's why we added the search route manually below, before it's not conventional. To know more about conventional, write the resource line alone and then run "php artisan route:list" command in the terminal.
// Route::resource('products', ProductController::class);

// Public Routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

// Because we're in the api file, the url is not just /products, it is /api/products
Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/search/{name}", [ProductController::class, "search"]);
Route::get("/products/{product}", [ProductController::class, "show"]);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Here is where you can put the routes that you want to protect with sanctum middleware.
    Route::post("/products", [ProductController::class, "store"]);
    Route::put("/products/{product}", [ProductController::class, "update"]);
    Route::delete("/products/{product}", [ProductController::class, "destroy"]);

    Route::post("/logout", [AuthController::class, "logout"]);

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
