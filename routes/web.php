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

//login and register 
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

//User Profile 
Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index');
    Route::get('/{id}/edit', 'ProfileController@edit');
    Route::put('/{id}', 'ProfileController@update');
    Route::put('/field-officer/{id}', 'ProfileController@updateFO');
});


//Disaster Response
Route::prefix('disaster-response')->group(function () {
    Route::get('/start', 'DisasterResponseController@start');
    Route::post('/store', 'DisasterResponseController@store');
    Route::get('/show/{id}', 'DisasterResponseController@show');
    Route::get('/stop/{id}', 'DisasterResponseController@stop');
    Route::get('/archive', 'DisasterResponseController@archive');
    Route::get('/export/{id}', 'DisasterResponseController@exportPDF');
});

//map and evacuation center 
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
        Route::get('/admin/approve',   'DeliveryRequestController@approve')->name('request.approve');
        Route::get('/admin/cancel',   'DeliveryRequestController@admin_cancel')->name('request.admin_cancel');
        Route::get('/admin/decline',   'DeliveryRequestController@admin_decline')->name('request.admin_decline');
        Route::post('/admin/assign',   'DeliveryRequestController@assign_courier')->name('request.assign_courier');
        Route::post('/store',   'DeliveryRequestController@store')->name('request.store');
        Route::get('/courier/accept',   'DeliveryRequestController@courier_accept')->name('request.courier_accept');
        Route::get('/courier/decline',   'DeliveryRequestController@courier_decline')->name('request.courier_decline');
        Route::get('/courier/cancel',   'DeliveryRequestController@courier_cancel')->name('request.courier_cancel');
    });
});

//field officer 
Route::resource('/field_officers', 'FieldOfficerController');

//requests

//residents
Route::resource('relief-recipient', 'ReliefRecipientController');
Route::resource('residents', 'FamilyMemberController');
Route::get('residents.group', 'FamilyMemberController@group')->name('residents.group');
Route::post('residents.groupResidents', 'FamilyMemberController@groupResidents');


//supply and inventory
Route::resource('supplies', 'SupplyController');
Route::resource('inventory', 'InventoryController');

//chat
Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', 'ChatController@index')->name('chat');
    Route::get('/chat/{id}', 'ChatController@getMessage');
    Route::post('chat', 'ChatController@sendMessage');
    Route::get('/search', 'ChatController@search');
});


// Import 
Route::prefix('import')->group(function () {
    Route::get('/field_officers', 'ImportController@importFieldOfficer');
    Route::post('/field_officers/store', 'ImportController@storeFieldOfficer');
    Route::get('/supplies', 'ImportController@importSupplies');
    Route::post('/supplies/store', 'ImportController@storeSupplies');
    Route::get('/evacuation_centers', 'ImportController@importEvacuationCenters')->name('evacuation-center.file.import');
    Route::post('/evacuation_centers/store', 'ImportController@storeEvacuationCenters')->name('evacuation-center.file.store');
});

// Export
Route::prefix('export')->group(function () {
    Route::get('/field_officers', 'ExportController@exportFieldOfficer');
    Route::get('/supplies', 'ExportController@exportSupplies');
    Route::get('/evacuation_centers', 'ExportController@exportEvacuationCenters')->name('evacuation-center.file.export');
    Route::get('/requests', 'ExportController@exportDeliveryRequests')->name('request.file.export');
});

//barangay
Route::prefix('barangay')->group(function () {
    Route::get('/search', 'BarangayController@search');
});


// Barangay Captain
Route::prefix('barangay-captain')->group(function () {
    Route::get('/add-supply', 'BarangayCaptainController@addSupply');
    Route::get('/dispense', 'BarangayCaptainController@dispenseView');
    Route::get('/details/{id}', 'BarangayCaptainController@detailsView');
    Route::get('/list', 'BarangayCaptainController@listView');
});

// Camp Manager
Route::prefix('camp-manager')->group(function () {
    Route::get('/evacuees', 'CampManagerController@evacuees');
    Route::get('/admit-view', 'CampManagerController@admitView');
    Route::get('/group-fam', 'CampManagerController@groupFam');
    Route::get('/discharge-view', 'CampManagerController@dischargeView');
    Route::get('/supply-view', 'CampManagerController@supplyView');
    Route::get('/dispense', 'CampManagerController@dispenseView');
    Route::get('/request-supply', 'CampManagerController@requestSupplyView');
    Route::get('/history', 'CampManagerController@historyView')->name('request.camp-manager.history');
    Route::get('/details/{id}', 'CampManagerController@detailsView');
});

// Courier
Route::prefix('courier')->group(function () {
    Route::get('/details/{id}', 'CourierController@details');
});