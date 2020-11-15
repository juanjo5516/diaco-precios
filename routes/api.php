<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('apiRest','ServiciosRest@ApiRest');
Route::get('getSedes','ServiciosRest@getSede');
// Route::get('categoriess','ServiciosRest@getApi');
Route::get('getprecio/{id}/{categoria}','ServiciosRest@getPricePrevious');
Route::get('getprecios/{id}/{categoria}','ServiciosRest@getPriceLast');


Route::get('fecha/{sede}/{categoria}', 'ServiciosRest@getPriceLastPrevious');
Route::get('prueba/{sede}/{categoria}', 'ServiciosRest@getPriceLastPrevious');


//Route::get('categories', 'ServiciosRest@collectionDataApi');

//cambio 13 enero
// Route::get('categories', 'ServiciosRest@VerifyActiveDepartments');
// Route::get('price/{id}/{categoria}','ServiciosRest@apiPrice');
Route::get('categories', 'MovilApp@movile_app');
Route::get('price/{id}/{categoria}','MovilApp@apiPrice_app');

Route::get('VerifyActiveDepartments','ServiciosRest@VerifyActiveDepartments');



//******Api Movil
Route::get('verify','MovilApp@movile_app');
Route::get('prices/{id}/{categoria}','MovilApp@apiPrice_app'); 

//***************

// Route::post('createMarket','catalogos@addMarket');
Route::post('createMarket','plantillasController@createMarket');


Route::get('categoriasPublicas','InfoPublic@movile_app');
Route::get('preciosPublicos/{id}/{categoria}','InfoPublic@apiPrice_app');
Route::post('price_view','InfoPublic@price_view');
Route::post('price_viewFilter','InfoPublic@price_viewFilter');
Route::post('chartPublic','InfoPublic@chartPublic');
Route::post('price_view_Category','InfoPublic@price_view_Category');
Route::get('tipos','InfoPublic@getTipoV');
Route::post('month','InfoPublic@getMonth');
Route::post('year','InfoPublic@getYear');
Route::post('viewCBA','InfoPublic@viewCBA');



