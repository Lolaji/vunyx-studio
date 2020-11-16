<?php

use App\Http\Controllers\ElementController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vx/auth', [UserController::class, 'vxAuth']);
Route::get('/user/logout', [UserController::class, 'logout']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/main/{page}/{param1?}', [MainController::class, 'index'])
        ->name('main');

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/studio/{project:uuid}', [StudioController::class, 'index'])
        ->name('studio');

Route::get('/{page}/{project:uuid}', [PlayerController::class, 'index'])
        ->name('player');


// Project Route
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/projects/{project}/viewers', [WatchUserController::class, 'create'])
        ->name('add-project-watch-users');

Route::middleware(['auth:sanctum', 'verified'])
        ->post('/projects/{project}/domains', [ProjectController::class, 'addDomain'])
        ->name('add-project-domain');

Route::middleware(['auth:sanctum', 'verified'])
        ->patch('/projects/{project}/settings', [ProjectSettingController::class, 'save'])
        ->name('project-settings');

Route::middleware(['auth:sanctum', 'verified'])
        ->delete('/projects/{project}', [ProjectController::class, 'delete'])
        ->name('delete-project');

Route::middleware(['auth:sanctum', 'verified'])
        ->delete('/projects/viewers/{watchUser}', [WatchUserController::class, 'delete'])
        ->name('remove-viewer');

Route::middleware(['auth:sanctum', 'verified'])
        ->delete('/projects/domains/{domain}', [ProjectController::class, 'removeDomain'])
        ->name('remove-domain');

// Element Router
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/projects/{project}/elements/{id?}', [ElementController::class, 'save'])
        ->name('upsert-element');

Route::middleware(['auth:sanctum', 'verified'])
        ->delete('/projects/{project}/elements/{id}', [ElementController::class, 'remove'])
        ->name('upsert-element');
