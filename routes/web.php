<?php

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

/*
/----------------------------------------------------------------------------
/ Rutas para los Menús
/----------------------------------------------------------------------------
/
*/
Route::get('/','menu@GetSelectMedida'); 
Route::get('Productos','menu@GetTabla'); 
Route::get('addProducto','menu@addProductos');
Route::get('index','menu@GetSelectMedida');
Route::get('Producto','menu@viewProducto');
Route::get('Categoria','menu@viewCateogira');
Route::get('TablaCategoria','menu@GetTablaC');
Route::get('categorias','menu@addCategorias');
Route::get('SubCategorias','menu@viewSubCategoria');
Route::get('TablaSubCategoria','menu@GetTablaS');
Route::get('AddSubCategoria','menu@addSCategorias');
Route::get('Mercado','menu@VaciadoMercado');
Route::get('Medida','menu@viewMedida');
Route::get('Medidas','menu@addMedidas');
Route::get('TablaMedida','menu@GetTablaM');
Route::get('Mercados','menu@viewMercado');
Route::get('DetalleMercados','menu@addDetalleMercados');
Route::get('TablaMercados','menu@GetTablaMercado');
Route::get('GetAddress','menu@GetChangeAddress');
Route::get('Establecimiento','menu@viewEstablecimiento');
Route::get('addDestablecimiento','menu@AddDestablecimiento');
Route::get('GetTablaEstablecimiento','menu@GetTablaEstablecimiento');
Route::get('GetAddressEstablecimiento','menu@GetChangeAddressEstablecimiento');
Route::get('AddVaciadoMercado','menu@AddMercadoVaciado');
/*Graficos */
Route::get('bar-chart', 'ChartController@ChartProductos');

/* Rutas de Editor de Plantillas */

Route::group(['middleware' => 'cors'], function(){
    Route::get('Edicion','plantillasController@index');
    Route::get('addPlantillas','plantillasController@store');
    Route::get('AsignarSede','plantillasController@Asede');
    Route::get('ListarAsignacion','plantillasController@ListarAsignaciones');
    Route::post('aLista', 'plantillasController@storeLista');
    Route::get('GetListaAsede','plantillasController@getAsede');
    Route::get('Bandeja','plantillasController@showInbox');
    Route::get('getinbox','plantillasController@getInbox');
    Route::get('Printer/{id}','plantillasController@showPrinter');
}); 