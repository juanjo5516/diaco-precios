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
Route::get('SubCategoria','menu@viewSubCategoria');
Route::get('TablaSubCategoria','menu@GetTablaS');
Route::get('AddSubCategoria','menu@addSCategorias');