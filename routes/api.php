<?php

use App\Http\Controllers\API\CurrencyController;
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

Route::get('/currencies/convert/{base_currency}/{target_currency}', [CurrencyController::class, 'convert']);

Route::apiResource('/currencies', CurrencyController::class)->only('index');

Route::any('{any}', function () {
    return response()->json(['error' => 'Invalid API URI'], 404);
})->where('any', '.*');
