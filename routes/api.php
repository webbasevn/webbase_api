<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleWare;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserControllers;
use App\Http\Controllers\Api\Admin\UserStatusController;

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

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUser']);

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::get('/cities', [])

Route::middleware(['auth:sanctum','admin_check'])->group(function () {

    // check token admin
    Route::get('/me', [AuthController::class, 'getUserAdmin']);

    // user
    Route::get('/admin/users', [UserControllers::class, 'ListUsers']);

    // package
    // Route::get('/admin/user_status', [UserStatusController::class, 'query']);
    // Route::post('/admin/user_status', [UserStatusController::class, 'create']);
    // Route::delete('/admin/user_status/{id}', [UserStatusController::class, 'delete']);

    Route::apiResource('/admin/user_status',UserStatusController::class);

});