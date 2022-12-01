<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\OrganizerController;
use App\Http\Controllers\API\SportEventController;
use App\Http\Controllers\API\UserController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::get('/', [ApiController::class, 'welcome'])->name('welcome');

    Route::group(['prefix' => 'users'], function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/', [UserController::class, 'register']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
            Route::put('/{id}/password', [UserController::class, 'changePassword']);
        });
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('organizers', OrganizerController::class);
        Route::apiResource('sport-events', SportEventController::class);
    });
});
