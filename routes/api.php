<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Rutas para apiRest

Route::get('apiRest','ServiciosRest@ApiRest');
Route::get('getSedes','ServiciosRest@getSede');
Route::get('getApi','ServiciosRest@getApi');
Route::get('getprecio/{id}/{categoria}','ServiciosRest@getPriceLast');
Route::get('price/{id}/{categoria}','ServiciosRest@apiPrice');

Route::get('fecha', 'ServiciosRest@getfechas');

