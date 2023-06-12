<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\ProfileController;
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
    Route::apiResource('recipes/{recipe_id}/instructions', InstructionController::class)->parameters(['instructions' => 'id'])->whereUuid(['recipe_id', 'id']);
    Route::apiResource('recipes/{recipe_id}/ingredients', IngredientController::class)->parameters(['ingredients' => 'id'])->whereUuid(['recipe_id', 'id']);

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::controller(ProfileRecipeController::class)->group(function () {
            Route::patch('/recipes/{id}', 'store')->name('save.recipe');
            Route::delete('/recipes/{id}', 'destroy')->name('delete.recipe');
            Route::get('/recipes/saved', 'saved_recipes')->name('saved.recipes');
            Route::get('/recipes', 'index')->name('my.recipes');
        });


        Route::get('/info', [ProfileController::class, 'show'])->name('info');
    });

    Route::prefix('auth')->as('auth.')->group(function () {
        require __DIR__ . '/auth.php';
    });
});
