<?php

use App\Http\Controllers\ProfileRecipeController;
use App\Http\Controllers\RecipeController;
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

Route::prefix('v1')->as('v1.')->group(function () {
    Route::apiResource('recipes', RecipeController::class)->parameter('recipes', 'id')->whereUuid('id');

    Route::prefix('profile')->as('profile.')->controller(ProfileRecipeController::class)->group(function () {
        Route::patch('/recipes/{id}', 'store')->name('recipe.save');
        Route::get('/recipes', 'index')->name('recipes');
    });

    Route::prefix('auth')->as('auth.')->group(function () {
        require __DIR__ . '/auth.php';
    });
});
