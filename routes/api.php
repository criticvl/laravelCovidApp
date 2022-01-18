<?php

use App\Http\Controllers\CountryController;
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

Route::get("countries/list",[App\Http\Controllers\CountryController::class,"list"]);

Route::get("covidWW",[App\Http\Controllers\CountryController::class,"covidWW"]);

Route::get("countries/searched",[App\Http\Controllers\CountryController::class,"searched"]);
Route::post("/add-country",[App\Http\Controllers\CountryController::class,"addcountry"]);
Route::delete("/delete-country/{id}",[App\Http\Controllers\CountryController::class,"deletecountry"]);
