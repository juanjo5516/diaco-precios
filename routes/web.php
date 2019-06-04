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
// Route::get('/admin', function () {
//     return view('admin.home');
// });
// Route::get('/', function () {
//     return view('admin.home');
// });




Route::get('/','menu@GetSelectMedida'); 

Route::get('Producto','menu@GetTabla'); 

Route::get('addProducto','menu@addProductos');
