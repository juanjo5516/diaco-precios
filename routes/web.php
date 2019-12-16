<?php

Auth::routes();

Route::get('/', 'menu@GetSelectMedida');
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
        Route::get('vaciado/{id}/{correlativo}','plantillasController@showVaciado');  
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

        // Tipos de visita
        Route::get('viewVisita','menu@viewVisita');  
        Route::get('findAllVisita','catalogos@findAllVisit');
        Route::post('addVisita','catalogos@addSVisit');
        Route::put('deleteByIdVisita','catalogos@deleteByIdVisit');
        Route::put('updateByIdVisita','catalogos@updateByIdVisit');
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

        // Update Vaciado status
        Route::post('updateStatusVaciado','plantillasController@updateStatusVaciado');
        // Route::get('getCorrelativo','plantillasController@createCorrelative');
        //---------------

        // Editar Plantillas
        // Route::post('getCountColumn','plantillasController@getCountColumn');
        // Route::get('getCorrelativo','plantillasController@createCorrelative');
        Route::put('updatePlantillaById','catalogos@updateByIdPlantilla');
        Route::post('getProductoEdicionPlantilla','plantillasController@getProductoEdicionPlantilla');
        Route::get('editPlantilla/{id}/{correlativo}','plantillasController@showEdit');
        //---------------

        // Usuarios Sistema
        Route::get('viewUsuariosSistema','menu@viewUsuariosSistema');  
        Route::get('findAllUserSystem','catalogos@findAllUserSystem');
        Route::post('addUserSystem','catalogos@addUserSystem');
        Route::put('deleteByIdUserSystem','catalogos@deleteByIdUserSystem');
        Route::put('updateByIdUserSystem','catalogos@updateByIdUserSystem');
        // *******************

        // Export Excel 
        Route::get('view/{id}/{user}/{correlativo}','plantillasController@exportExcelView');
        Route::get('getExportData/{id}/{user}/{correlativo}','catalogos@getExportData');
        Route::get('getExportDataCategory/{id}/{user}/{correlativo}','catalogos@getCategoriaExport');
        Route::get('getPriceExport/{id}/{user}/{correlativo}','catalogos@getExportDataPrice');
        //***************

        // Asignacion Sede Usuario
        Route::get('asignacionUsuario','menu@viewUsuariosSistemaById'); 
        Route::post('AUsuario', 'plantillasController@storeListaUsuario');
        //******************************

        // Preview
        Route::get('preview/{id}/{user}/{correlativo}','plantillasController@preview');
        Route::post('updatePrice','catalogos@updatePrice');
        Route::post('changeStatusPlantilla','catalogos@changeStatusPlantilla');
        Route::get('revisarEnvio','plantillasController@previewSubmit');
        Route::get('viewSubmit/{id}/{user}/{correlativo}','plantillasController@submitView');
        //**********************



        Route::post('getProductoAndMeasure','catalogos@getProductoAndMeasure');

        Route::get('getUserCba/{id}','plantillasController@getUserCba');
        
    //------------------------------------------------------------------------------------------
    }); 




// Route::group(['middleware' => ['admin']], function () {
    

// });

