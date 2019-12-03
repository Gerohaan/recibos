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
Route::resource('datos', 'DatosgeneralesController');
Route::post('datos/query','DatosgeneralesController@query')->name('datos.query');
Route::post('datos/queryii','DatosgeneralesController@queryii')->name('datos.queryii');
Route::post('datos/roster','DatosgeneralesController@query_roster')->name('datos.roster');
Route::get('datos/reciboPDF/{idTrabajador}/{codigoDocumento}','DatosgeneralesController@imprimirRecibo')->name('datos.imprimirRecibo');
Route::get('/imprimir', 'DatosgeneralesController@print_pdf')->name('print');
Route::get('datos/isrl/{idTrabajador}/{anno}', 'DatosgeneralesController@imprimirari')->name('datos.imprimirari');
Route::get('datos/constancias/{idTrabajador}', 'DatosgeneralesController@nominaConstancia')->name('datos.constancias');
Route::get('datos/consultaConstancia/{idTrabajador}/{tipoNomina}/{tipoConstancia}', 'DatosgeneralesController@imprimirConstancia')->name('datos.consultaConstancia');
Route::get('/', function () {
    return view('principal');
});

