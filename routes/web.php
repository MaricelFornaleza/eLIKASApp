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

use App\Models\User;

use App\Http\Controllers\FieldOfficerController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\FamilyMemberController;

Route::get('/', function () {
    $count = User::count();
    if ($count == 0) {
        return view('auth.register');
    } else {
        return view('auth.login');
    }
});
Route::auth('/register', function () {
    $count = User::count();

    return view('auth.register')->with('count', $count);
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/map/get_couriers', 'MapController@get_couriers');
    Route::get('/map/get_evac', 'MapController@get_evac');
    Route::resource('/map', 'MapController');
    Route::prefix('evacuation-centers')->group(function () {
        Route::get('/',         'EvacuationCenterController@index')->name('evacuation-center.index');
        Route::get('/create',   'EvacuationCenterController@create')->name('evacuation-center.create');
        Route::post('/store',   'EvacuationCenterController@store')->name('evacuation-center.store');
        Route::get('/edit',     'EvacuationCenterController@edit')->name('evacuation-center.edit');
        Route::post('/update',  'EvacuationCenterController@update')->name('evacuation-center.update');
        Route::delete('/delete',   'EvacuationCenterController@delete')->name('evacuation-center.delete');
    });
});

Route::resource('/field_officers', 'FieldOfficerController');

Route::resource('/profile', 'ProfileController');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', 'ChatController@index')->name('chat');
    Route::get('/chat/{id}', 'ChatController@getMessage');
    Route::post('chat', 'ChatController@sendMessage');
    Route::get('/search', 'ChatController@search');
});

Route::resource('supplies', 'SupplyController');
Route::resource('inventory', 'InventoryController');

Route::resource('residents', 'FamilyMemberController');
Route::get('residents.group', 'FamilyMemberController@group')->name('residents.group');
Route::post('residents.groupResidents', 'FamilyMemberController@groupResidents');



// Route::post('/import_excel_supplies', 'ImportExcelController@import');
// Route::get('/export_excel_supplies', 'ExportExcelController@export');

Route::prefix('import')->group(function () {
    Route::get('/field_officers', 'ImportController@importFieldOfficer');
    Route::post('/field_officers/store', 'ImportController@storeFieldOfficer');
    Route::get('/supplies', 'ImportController@importSupplies');
    Route::post('/supplies/store', 'ImportController@storeSupplies');
    Route::get('/residents', 'ImportController@importResidents');
    Route::post('/residents/store', 'ImportController@storeResidents');
});

Route::prefix('export')->group(function () {
    Route::get('/field_officers', 'ExportController@exportFieldOfficer');
    Route::get('/supplies', 'ExportController@exportSupplies');
    Route::get('/residents', 'ExportController@exportResidents');
});