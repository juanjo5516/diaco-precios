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

// Auth::routes();

// Route::get('/inicio', 'HomeController@index')->name('home');

// Route::get('/inicio', function () {
//     // if (Auth::check()) {
//     //     // The user is logged in...
//     //     return redirect()->intended('/home');
        
//     // }else{
//         return view('auth.login'); 
    
// });




/*
/----------------------------------------------------------------------------
/ Rutas para los Menús
/----------------------------------------------------------------------------
/
*/
Route::get('/', function () {
    if (Auth::check()) {
        // The user is logged in...
        return redirect()->intended('/home');
        
    }else{
        return view('auth.login'); 
    }
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'menu@GetSelectMedida')->name('home');
// Route::get('/','menu@GetSelectMedida'); 
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
Route::get('SMercados','menu@viewSuperMercado');
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
        // Route::get('addPlantillas','plantillasController@store'); 
        Route::post('addPlantillas','plantillasController@store');
        Route::get('AsignarSede','plantillasController@Asede');
        Route::get('ListarAsignacion','plantillasController@ListarAsignaciones');
        Route::post('aLista', 'plantillasController@storeLista');
        // Route::get('GetListaAsede','plantillasController@getAsede');
        Route::get('GetListaAsede','plantillasController@getAsedeJson');
        Route::get('Bandeja','plantillasController@showInbox');
        Route::get('getinbox','plantillasController@getInbox');
        Route::get('Printer/{id}/{correlativo}','plantillasController@showprinter');
        // Route::post('Printer','plantillasController@showprinter');
        Route::get('vaciado/{id}','plantillasController@showVaciado'); 
        Route::post('mercadoCBA','plantillasController@vaciado');
        Route::get('clonar','plantillasController@clon');
        Route::post('getPlantillaClone','plantillasController@getDataPlantillas'); 
        Route::get('getPlantillaClon','plantillasController@getPlantillasAll');
        Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
        Route::get('getTipo','plantillasController@getTipoVisita');
        Route::get('visitas/{id}','plantillasController@getTipoVerificacionVaciado');
        Route::get('check','plantillasController@check');
        Route::get('GasPropano','menu@viewGasPropano');
        Route::get('getPropano','PropanoController@GetPropano');
        Route::post('AddPropano','PropanoController@addPropano');
        Route::get('enviados','plantillasController@showEnviados');
        Route::get('getEnviados','plantillasController@GetEnviados');
        Route::put('DeleteAsginacionById','plantillasController@deleteByIdAsignacion');

    //-----------------------------------------------------------------------------------------    
        // Categoria
        Route::get('getCategory','catalogos@dataCategory');
        Route::post('addCategory','catalogos@addCategory');
        Route::put('deleteCategory','catalogos@deleteByIdCategory');
        Route::put('UpdateCategory','catalogos@UpdateById');
        // -------------
        // Producto
        Route::get('findAllProducto','catalogos@findAllProduct');
        Route::post('addProducto','catalogos@addProducto');
        Route::put('deleteProducto','catalogos@deleteByIdProduct');
        Route::put('UpdateProduct','catalogos@updateByIdProduct');
        Route::post('findByIdProduct','catalogos@findByIdProduct');
        // -------------
        // SubCategoria
        Route::get('findAllSubCategory','catalogos@findAllSubCategory');
        Route::post('addSubCategory','catalogos@addSubCategory');
        Route::put('deleteSubCategory','catalogos@deleteByIdSubCategory');
        Route::put('UpdateSubCategory','catalogos@updateByIdSubCategory');
        // -------------
        // Medida
        Route::get('findAllmeasure','catalogos@findAllmeasure');
        Route::post('addmeasure','catalogos@addmeasure');
        Route::put('deleteByIdmeasure','catalogos@deleteByIdmeasure');
        Route::put('updateByIdmeasure','catalogos@updateByIdmeasure');
        Route::post('findByIdmeasure','catalogos@findByIdmeasure');
        // -------------
        // Mercados
        Route::get('findAllMarket','catalogos@findAllMarket');
        Route::post('addMarket','catalogos@addMarket');
        Route::put('deleteByIdMarket','catalogos@deleteByIdMarket');
        Route::put('updateByIdmarket','catalogos@updateByIdMarket');
        // -------------
        // Establecimiento
        Route::get('findAllLocal','catalogos@findAllLocal');
        Route::post('addLocal','catalogos@addLocal');
        Route::put('deleteByIdLocal','catalogos@deleteByIdLocal');
        Route::put('updateByIdLocal','catalogos@updateByIdLocal');
        // -------------
        // Super Mercado
        Route::get('findAllSmarket','catalogos@findAllSmarket');
        Route::post('addSmarket','catalogos@addSmarket');
        Route::put('deleteByIdSmarket','catalogos@deleteByIdSmarket');
        Route::put('updateByIdSmarket','catalogos@updateByIdSmarket');
        // -------------
        // Reset Pasword User
        Route::get('changePasswordUser','PasswordResetController@reset');
        Route::post('changePassword','PasswordResetController@changePassword')->name('changePassword');
        // -------------

        // Get Data Departamento and Municipio
        Route::get('getDepartamento','plantillasController@getDepartament');
        Route::post('getMunicipio','plantillasController@getMunicipioById');
        // -------------
        
        // Get Data Pdf Generate
        Route::get('get-pdf/{id}','PdfController@getPdf');
        Route::get('getInfoUser','PdfController@getInfoUser');
        Route::post('getCategoriaPdf', 'PdfController@getCategoria');
        Route::post('getProductosPdf','PdfController@getPlantillas');
        // -------------

        // Count Column
        Route::post('getCountColumn','plantillasController@getCountColumn');
        Route::get('getCorrelativo','plantillasController@createCorrelative');
        //---------------

        Route::post('getProductoAndMeasure','catalogos@getProductoAndMeasure');
        
    //------------------------------------------------------------------------------------------
    }); 




// Route::group(['middleware' => ['admin']], function () {
    

// });

