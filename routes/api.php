<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CategoryController;
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

Route::post('/login', [AuthenticationController::class, 'login'])->name('login.api');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout.api');
Route::get('/redirect', [AuthenticationController::class, 'authorization'])->name('authorize.api');

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    // Récupérer les catégories par type de document
    Route::get('/categories/by-type', [CategoryController::class, 'getCategoriesByType'])->name('api.categories.by-type');
    
    // Vos autres routes API protégées ici
});
