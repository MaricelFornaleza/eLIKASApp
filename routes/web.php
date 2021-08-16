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

use App\Http\Controllers\FieldOfficerController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\ExportExcelController;

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});



Route::resource('/field_officers', 'FieldOfficerController');
Route::resource('supplies', 'SupplyController');
Route::resource('inventory', 'InventoryController');

Route::post('/import_excel_supplies', 'ImportExcelController@import');
Route::get('/export_excel_supplies', 'ExportExcelController@export');
