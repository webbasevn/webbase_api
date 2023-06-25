<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleWare;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;

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

Route::middleware(['auth:sanctum','admin_check'])->group(function () {

    //debug
    Route::get('/check-middleware', function(){
        return response()->json('ok');
    });

    // check token admin
    Route::get('/me', [AuthController::class, 'getUserAdmin']);

    // role
    Route::post('/role/create', [RoleController::class, 'CreateRole']);
    Route::get('/role/query', [RoleController::class, 'QueryRole']);
    Route::delete('/role/{role}', [RoleController::class, 'DeleteRole']);

});