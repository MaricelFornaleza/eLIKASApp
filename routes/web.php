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

Auth::routes();


// the user must be authenticated to access these routes
Route::group(['middleware' => ['auth']], function () {
    //Home

    Route::get('/home', 'HomeController@index')->name('home');
    //User Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', 'ProfileController@index');
        Route::get('/{id}/edit', 'ProfileController@edit');
        Route::put('/{id}', 'ProfileController@update');
        Route::put('/field-officer/{id}', 'ProfileController@updateFO');
    });

    // Map
    Route::prefix('map')->group(function () {
        Route::get('/get_locations/{id}', 'MapController@get_locations');
        Route::get('/get_couriers', 'MapController@get_couriers');
        Route::get('/get_evac', 'MapController@get_evac')->name('map.evacs');
        Route::resource('/', 'MapController');
    });
    // Evacuation Center
    Route::prefix('evacuation_centers')->group(function () {
        Route::get('/',         'EvacuationCenterController@index')->name('evacuation-center.index');
        Route::get('/create',   'EvacuationCenterController@create')->name('evacuation-center.create');
        Route::post('/store',   'EvacuationCenterController@store')->name('evacuation-center.store');
        Route::get('/edit',     'EvacuationCenterController@edit')->name('evacuation-center.edit');
        Route::post('/update',  'EvacuationCenterController@update')->name('evacuation-center.update');
        Route::delete('/delete',   'EvacuationCenterController@delete')->name('evacuation-center.delete');
    });
    // Requests
    Route::prefix('requests')->group(function () {
        Route::get('/',         'DeliveryRequestController@index')->name('request.index')->middleware('officertype:Administrator');
        Route::get('/refresh',         'DeliveryRequestController@refresh')->name('request.refresh')->middleware('officertype:Administrator');
        Route::get('/receive',   'DeliveryRequestController@receive_supplies')->name('request.receive_supplies')->middleware('officertype:Camp Manager');
        Route::post('/store',   'DeliveryRequestController@store')->name('request.store')->middleware('officertype:Camp Manager');
        Route::get('/cancel',   'DeliveryRequestController@cancel')->name('request.cancel');    //all users can access this
        Route::get('/admin/approve',   'DeliveryRequestController@approve')->name('request.approve')->middleware('officertype:Administrator');
        Route::get('/admin/decline',   'DeliveryRequestController@admin_decline')->name('request.admin_decline')->middleware('officertype:Administrator');
        Route::post('/admin/assign',   'DeliveryRequestController@assign_courier')->name('request.assign_courier')->middleware('officertype:Administrator');
        Route::get('/courier/accept/{id}',   'DeliveryRequestController@courier_accept')->name('request.courier_accept')->middleware('officertype:Courier');
        Route::get('/courier/decline',   'DeliveryRequestController@courier_decline')->name('request.courier_decline')->middleware('officertype:Courier');
    });

    Route::group(['middleware' => ['officertype:Admin&BC']], function () {
        // Supply
        Route::resource('supplies', 'SupplyController');
        // Inventory
        Route::resource('inventory', 'InventoryController');
    });

    // Chat
    Route::get('/chat', 'ChatController@index')->name('chat');
    Route::get('/chat/{id}', 'ChatController@getMessage');
    Route::post('chat', 'ChatController@sendMessage');
    Route::get('/search', 'ChatController@search');

    Route::group(['middleware' => ['officertype:Administrator']], function () {
        // Field Officer
        Route::resource('/field_officers', 'FieldOfficerController');
        // Residents
        Route::resource('relief-recipient', 'ReliefRecipientController');
        Route::resource('residents', 'FamilyMemberController');
        Route::get('residents.group', 'FamilyMemberController@group')->name('residents.group');
        Route::post('residents.groupResidents', 'FamilyMemberController@groupResidents');
        //Disaster Response
        Route::prefix('disaster-response')->group(function () {
            Route::get('/start', 'DisasterResponseController@start');
            Route::post('/store', 'DisasterResponseController@store');
            Route::get('/show/{id}', 'DisasterResponseController@show');
            Route::get('/stop/{id}', 'DisasterResponseController@stop');
            Route::get('/archive', 'DisasterResponseController@archive');
            Route::get('/export/{id}', 'DisasterResponseController@exportPDF');
        });
        // Import
        Route::prefix('import')->group(function () {
            Route::get('/field_officers', 'ImportController@importFieldOfficer');
            Route::post('/field_officers/store', 'ImportController@storeFieldOfficer');
            Route::get('/supplies', 'ImportController@importSupplies');
            Route::post('/supplies/store', 'ImportController@storeSupplies');
            Route::get('/evacuation_centers', 'ImportController@importEvacuationCenters')->name('evacuation-center.file.import');
            Route::post('/evacuation_centers/store', 'ImportController@storeEvacuationCenters')->name('evacuation-center.file.store');
            Route::get('/residents', 'ImportController@importResidents');
            Route::post('/residents/store', 'ImportController@storeResidents');
        });

        // Export
        Route::prefix('export')->group(function () {
            Route::get('/field_officers', 'ExportController@exportFieldOfficer');
            Route::get('/supplies', 'ExportController@exportSupplies');
            Route::get('/evacuation_centers', 'ExportController@exportEvacuationCenters')->name('evacuation-center.file.export');
            Route::get('/requests', 'ExportController@exportDeliveryRequests')->name('request.file.export');
            Route::get('/residents', 'ExportController@exportResidents');
        });
    });

    // Barangay Captain
    Route::group(['middleware' => ['officertype:Barangay Captain']], function () {
        Route::prefix('barangay-captain')->group(function () {
            Route::get('/add-supply', 'BarangayCaptainController@addSupply');
            Route::get('/dispense', 'BarangayCaptainController@dispenseView');
            Route::get('/details/{id}', 'BarangayCaptainController@detailsView');
            Route::get('/list', 'BarangayCaptainController@listView');
        });
    });

    // Camp Manager
    Route::group(['middleware' => ['officertype:Camp Manager']], function () {
        Route::prefix('camp-manager')->group(function () {
            Route::get('/evacuees', 'CampManagerController@evacuees');
            Route::get('/admit-view', 'CampManagerController@admitView');
            Route::post('/admit', 'CampManagerController@admit');
            Route::get('/discharge-view', 'CampManagerController@dischargeView');
            Route::post('/discharge', 'CampManagerController@discharge');
            Route::get('/supply-view', 'CampManagerController@supplyView');
            Route::get('/dispense-view', 'CampManagerController@dispenseView');
            Route::post('/dispense', 'CampManagerController@dispense');
            Route::get('/request-supply', 'CampManagerController@requestSupplyView');
            Route::get('/history', 'CampManagerController@historyView')->name('request.camp-manager.history');
            Route::get('/details/{id}', 'CampManagerController@detailsView');
        });
    });


    // Courier
    Route::group(['middleware' => ['officertype:Courier']], function () {
        Route::prefix('courier')->group(function () {
            Route::get('/details/{id}', 'CourierController@details');
        });
    });
});

// Route::fallback(function () {
//     return 'Hm, why did you land here somehow?';
// });