<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Api\{UserController, AssetController, CategoryController, OfferController, ProductController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// route login and logout

require __DIR__ . '/auth.php';


Route::get('/', function () {
    return response()->json(['message' => 'Welcome to our api']);
});


Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api-users.index');
    Route::post('/', [UserController::class, 'store'])->name('api-users.store');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::prefix('onboarding')->group(function () {
        Route::get('/', [UserController::class, 'onboarding']);
        Route::middleware('edit.onboarding')->group(function () {
            Route::post('address', [UserController::class, 'onboardingAddress']);
            Route::post('bank', [UserController::class, 'onboardingBank']);
            Route::post('company', [UserController::class, 'onboardingCompany']);
            Route::post('document', [UserController::class, 'onboardingDocument']);
        });
        Route::get('bank/list', [AssetController::class, 'bankList']);
    });
    Route::apiResource('user', UserController::class)
        ->only(['update', 'destroy', 'index']);

    Route::get('categories', [CategoryController::class, 'index'])->name('api-categories.index');

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('api-products.store');
        Route::get('/', [ProductController::class, 'index'])->name('api-products.index');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('api-products.destroy');
        Route::put('/{product}', [ProductController::class, 'update'])->name('api-products.update');
    });


    Route::prefix('offers')->group(function () {
        Route::post('/', [OfferController::class, 'store'])->name('api-offers.store');
        Route::get('/', [OfferController::class, 'index'])->name('api-offers.index');
        Route::delete('/{offer}', [OfferController::class, 'destroy'])->name('api-offers.destroy');
        Route::put('/{offer}', [OfferController::class, 'update'])->name('api-offers.update');
    });
});

Route::get('/health', HealthCheckController::class);
