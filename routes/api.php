<?php

use App\Http\Controllers\Api\CompletedController;
use App\Http\Controllers\Api\InProcessController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::apiResources([
    'users' => UserController::class
]); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
// Route::post('/registration', [\App\Http\Controllers\Auth\RegistrationController::class, 'registration']);
// Route::get('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResources([
        'tasks' => TaskController::class,
        'completed' => CompletedController::class,
        'inprocess' => InProcessController::class,
        'user' => UserController::class
    ]); 
});


