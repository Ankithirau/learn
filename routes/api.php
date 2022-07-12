<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigneds the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user/login', [App\Http\Controllers\API\APIUserController::class, 'userLogin']);

Route::post('/user/userchecker', [App\Http\Controllers\API\APIUserController::class, 'usernameChecker']);

Route::post('/user/register', [App\Http\Controllers\API\APIUserController::class, 'store']);

Route::post('user/update_password/{id}', [App\Http\Controllers\API\APIUserController::class, 'update_password']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user/{id}', [App\Http\Controllers\API\APIUserController::class, 'show']);
    Route::post('user/update/{id}', [App\Http\Controllers\API\APIUserController::class, 'update']);
    Route::post('user-password/update/{id}', [App\Http\Controllers\API\APIUserController::class, 'update_password']);
});

Route::post('user/forget-password',[App\Http\Controllers\API\APIUserController::class, 'user_update_password']);

Route::post('/intent-payments', [App\Http\Controllers\API\StripeController::class, 'StripePaymentIntent']);

Route::get('/get_slider', [App\Http\Controllers\API\SliderController::class, 'get_slider']);

Route::resource('/event', App\Http\Controllers\API\EventController::class);

// Route::get('/event/{category_id?}', [App\Http\Controllers\API\EventController::class, 'index']);
// Route::resource('/event', App\Http\Controllers\API\EventController::class)->except([
//     'index'
// ]);

Route::get('/msg', [App\Http\Controllers\API\EventController::class, 'resetmsg']);

Route::get('/event-detail/{id}', [App\Http\Controllers\API\EventController::class, 'product_detail']);

Route::get('/event-search/{search}', [App\Http\Controllers\API\EventController::class, 'search_product']);

Route::resource('/event', App\Http\Controllers\API\EventController::class);

Route::resource('/seo', App\Http\Controllers\API\SeoController::class);

Route::get('get_county/{id}', [App\Http\Controllers\API\EventController::class, 'select_county_by_point']);

Route::get('county/{id}', [App\Http\Controllers\API\EventController::class, 'county_by_Id']);

Route::post('intent-payment', [App\Http\Controllers\API\EventController::class, 'createPaymentIntent']);

Route::get('/get_price/{product_id}/{county_id}/{pickup_id}', [App\Http\Controllers\API\EventController::class, 'get_price']);

Route::post('login', [App\Http\Controllers\API\APIEmployeeController::class, 'doLogin']);

Route::post('/booking', [App\Http\Controllers\API\EventController::class, 'book_product']);

Route::get('/companies', [App\Http\Controllers\API\APIClientController::class, 'index']);

Route::post('/coupon_code', [App\Http\Controllers\API\CouponController::class, 'validate_coupon']);

Route::get('test', function () {

    $user = [
        'name' => 'Harsukh Makwana',
        'info' => 'Laravel & Python Devloper'
    ];

    \Mail::to('vavit12196@hekarro.com')->send(new \App\Mail\NewMail($user));

    dd("success");
});

#-------------------------------------------------------------------------------------

Route::get('employees/{client_id}', [App\Http\Controllers\API\APIEmployeeController::class, 'index']);
Route::post('employee/store', [App\Http\Controllers\API\APIEmployeeController::class, 'store']);
Route::post('employee-update/{id}', [App\Http\Controllers\API\APIEmployeeController::class, 'update']);
Route::get('employees-log-list/{prefix}', [App\Http\Controllers\API\APIEmployeeController::class, 'employees_log_list']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('employee/{id}', [App\Http\Controllers\API\APIEmployeeController::class, 'show']);
    Route::post('employee-profile/{id}/update', [App\Http\Controllers\API\APIEmployeeController::class, 'update']);
    Route::post('employee-profile/{id}/update_image', [App\Http\Controllers\API\APIEmployeeController::class, 'update_image']);
    Route::get('logout/{token}', [App\Http\Controllers\API\APIEmployeeController::class, 'logout']);
    Route::post('logout/{token}', [App\Http\Controllers\API\APIEmployeeController::class, 'logout']);
    Route::post('employee-password/{id}/update', [App\Http\Controllers\API\APIEmployeeController::class, 'update_password']);
    Route::get('employee-log/{prefix}/{empid}', [App\Http\Controllers\API\APIEmployeeController::class, 'employee_log']);
    Route::post('employee-log/{prefix}/{empid}', [App\Http\Controllers\API\APIEmployeeController::class, 'employee_log_filter']);
});
