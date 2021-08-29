<?php

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
use App\Http\Controllers\API\V1;

Route::prefix('v1')->group(function (){
    Route::post('login', [V1\UserController::class, 'login']);
    Route::post('register', [V1\UserController::class, 'register']);
});

Route::prefix('v1')->group(function (){
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [V1\UserController::class, 'logout']);
        Route::resource('films', V1\FilmController::class);
        Route::get('getcountries', [V1\CountryController::class,'index'])->name('getcountries');
        Route::get('getgenres', [V1\GenreController::class,'index'])->name('getgenres');
    });
});
