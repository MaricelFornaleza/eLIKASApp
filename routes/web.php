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

use App\Mail\VerifyEmail;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

//login and register 
Route::get('/', function () {
    if (auth()->user()) {
        return redirect(route('home'));
    } else {
        return redirect(route('login'));
    }
    // return view('auth.login');
});

Auth::routes(['register' => false, 'verify' => true]);

Route::get('/send-mail', function () {
    $data = [
        'name' => 'Maricel',
        'remember_token' => Str::random(25),
        'email' => 'maformaleza@gbox.adnu.edu.ph',
    ];

    Mail::to($data['email'])->send(new VerifyEmail($data));
});

//email verification

Route::get('/user/verify/{remember_token}', 'FieldOfficerController@verifyUser');

// the user must be authenticated to access these routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    //Home
    Route::get('/home', 'HomeController@index')->name('home');
    //User Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', 'ProfileController@index');
        Route::get('/{id}/edit', 'ProfileController@edit');
        Route::put('/{id}', 'ProfileController@update');
        Route::put('/field-officer/{id}', 'ProfileController@updateFO');
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
        Route::get('/suggestion/{id}',   'DeliveryRequestController@viewSuggestion')->middleware('officertype:Administrator');
        Route::get('/admin/decline',   'DeliveryRequestController@admin_decline')->name('request.admin_decline')->middleware('officertype:Administrator');
        Route::post('/admin/assign',   'DeliveryRequestController@assign_courier')->name('request.assign_courier')->middleware('officertype:Administrator');
        Route::get('/courier/accept/{id}',   'DeliveryRequestController@courier_accept')->name('request.courier_accept')->middleware('officertype:Courier');
        Route::get('/courier/decline',   'DeliveryRequestController@courier_decline')->name('request.courier_decline')->middleware('officertype:Courier');
        Route::get('/evac-data/{id}', 'DeliveryRequestController@evac_data')->middleware('officertype:Administrator');
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

    Route::post('config', 'AdminController@adminConfig');


    Route::group(['middleware' => ['officertype:Administrator', 'adminconfig']], function () {
        // Map
        Route::prefix('map')->group(function () {
            Route::get('/get_locations/{id}', 'MapController@get_locations');
            Route::get('/affected_areas', 'MapController@affected_areas');
            Route::get('/get_couriers', 'MapController@get_couriers');
            Route::get('/get_evac', 'MapController@get_evac')->name('map.evacs');
            Route::resource('/', 'MapController');
        });
        // Field Officer
        Route::resource('/field_officers', 'FieldOfficerController');
        Route::get('/resend-verification/{remember_token}', 'FieldOfficerController@resendVerification');
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
            Route::get('/field_officers/pdf', 'ExportController@exportFieldOfficerPDF');
            Route::get('/supplies', 'ExportController@exportSupplies');
            Route::get('/supplies/pdf', 'ExportController@exportSuppliesPDF');
            Route::get('/evacuation_centers', 'ExportController@exportEvacuationCenters');
            Route::get('/evacuation_centers/pdf', 'ExportController@exportEvacuationCentersPDF');
            Route::get('/requests', 'ExportController@exportDeliveryRequests');
            Route::get('/requests/pdf', 'ExportController@exportDeliveryRequestsPDF');
            Route::get('/residents', 'ExportController@exportResidents');
            Route::get('/residents/pdf', 'ExportController@exportResidentsPDF');
        });
    });

    // Barangay Captain
    Route::group(['middleware' => ['officertype:Barangay Captain']], function () {
        Route::prefix('barangay-captain')->group(function () {
            Route::get('/add-supply', 'BarangayCaptainController@addSupply');
            Route::get('/dispense-view', 'BarangayCaptainController@dispenseView');
            Route::post('/dispense', 'BarangayCaptainController@dispense');
            Route::get('/details/{id}', 'BarangayCaptainController@detailsView');
            Route::get('/edit/{id}', 'BarangayCaptainController@editSupply');
            Route::get('/list', 'BarangayCaptainController@listView');
            Route::get('/search/non-evacuees', 'BarangayCaptainController@searchNonEvacuees');
            Route::get('/search/bc-supplies', 'BarangayCaptainController@searchSupplies');
        });
    });

    // Camp Manager
    Route::group(['middleware' => ['officertype:Camp Manager']], function () {
        Route::prefix('camp-manager')->group(function () {
            Route::get('/evacuees', 'CampManagerController@evacuees')->name('cm_evacuees');
            Route::get('/admit-view', 'CampManagerController@admitView');
            Route::post('/admit', 'CampManagerController@admit');
            Route::get('/discharge-view', 'CampManagerController@dischargeView');
            Route::post('/discharge', 'CampManagerController@discharge');
            Route::get('/supply-view', 'CampManagerController@supplyView')->name('cm_supply_view');
            Route::get('/dispense-view', 'CampManagerController@dispenseView');
            Route::post('/dispense', 'CampManagerController@dispense');
            Route::get('/request-supply', 'CampManagerController@requestSupplyView');
            Route::get('/history', 'CampManagerController@historyView')->name('request.camp-manager.history');
            Route::get('/details/{id}', 'CampManagerController@detailsView');
            Route::get('/search/admit-evacuees', 'CampManagerController@searchAdmitEvacuees');
            Route::get('/search/discharge-evacuees', 'CampManagerController@searchDischargeEvacuees');
        });
    });


    // Courier
    Route::group(['middleware' => ['officertype:Courier']], function () {
        Route::prefix('courier')->group(function () {
            Route::get('/details/{id}', 'CourierController@details');
        });
    });
});

Route::get('subscribe', function () {
    $http = new \GuzzleHttp\Client();
    $response = $http->post("https://developer.globelabs.com.ph/oauth/access_token", [
        'form_params' => [
            "app_id" => env('GLOBE_LABS_APP_ID'),
            "app_secret" => env('GLOBE_LABS_APP_SECRET')
        ]
    ]);
    Log::info($response->getBody());
    return $response->getBody();
});

Route::get('sms/inbound-sms', function ($response) {
    return response()->json($response);
});