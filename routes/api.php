<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

Route::post('/user', [UserController::class, 'create']);
Route::middleware('auth:sanctum')->get('/projects', [ProjectController::class, 'fetch']);
Route::post('/projects/{project}/domains', [ProjectController::class, 'addDomain']);
Route::post('/projects/{id?}', [ProjectController::class, 'create']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'vxAuthentication']);
