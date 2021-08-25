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
use App\Http\Controllers\ReliefRecipientController;

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
    Route::get('/map/get_locations/{id}', 'MapController@get_locations');
    Route::get('/map/get_couriers', 'MapController@get_couriers');
    Route::get('/map/get_evac', 'MapController@get_evac')->name('map.evacs');
    Route::resource('/map', 'MapController');
    Route::prefix('evacuation_centers')->group(function () {
        Route::get('/',         'EvacuationCenterController@index')->name('evacuation-center.index');
        Route::get('/create',   'EvacuationCenterController@create')->name('evacuation-center.create');
        Route::post('/store',   'EvacuationCenterController@store')->name('evacuation-center.store');
        Route::get('/edit',     'EvacuationCenterController@edit')->name('evacuation-center.edit');
        Route::post('/update',  'EvacuationCenterController@update')->name('evacuation-center.update');
        Route::delete('/delete',   'EvacuationCenterController@delete')->name('evacuation-center.delete');
    });
    Route::prefix('requests')->group(function () {
        Route::get('/',         'DeliveryRequestController@index')->name('request.index');
        Route::get('/admin_approve',   'DeliveryRequestController@approve')->name('request.approve');
        Route::get('/admin_cancel',   'DeliveryRequestController@admin_cancel')->name('request.admin_cancel');
        Route::get('/admin_decline',   'DeliveryRequestController@admin_decline')->name('request.admin_decline');
        Route::post('/admin_assign',   'DeliveryRequestController@assign_courier')->name('request.assign_courier');
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

// Route::post('/import_excel_supplies', 'ImportExcelController@import');
// Route::get('/export_excel_supplies', 'ExportExcelController@export');

Route::resource('relief-recipient', 'ReliefRecipientController');

Route::prefix('import')->group(function () {
    Route::get('/field_officers', 'ImportController@importFieldOfficer');
    Route::post('/field_officers/store', 'ImportController@storeFieldOfficer');
    Route::get('/supplies', 'ImportController@importSupplies');
    Route::post('/supplies/store', 'ImportController@storeSupplies');
    Route::get('/evacuation_centers', 'ImportController@importEvacuationCenters')->name('evacuation-center.file.import');
    Route::post('/evacuation_centers/store', 'ImportController@storeEvacuationCenters')->name('evacuation-center.file.store');
});

Route::prefix('export')->group(function () {
    Route::get('/field_officers', 'ExportController@exportFieldOfficer');
    Route::get('/supplies', 'ExportController@exportSupplies');
    Route::get('/evacuation_centers', 'ExportController@exportEvacuationCenters')->name('evacuation-center.file.export');
    Route::get('/requests', 'ExportController@exportDeliveryRequests')->name('request.file.export');
});
