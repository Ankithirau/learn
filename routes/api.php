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
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/user', App\Http\Controllers\API\APIUserController::class);

Route::post('/user/login', [App\Http\Controllers\API\APIUserController::class, 'userLogin']);

Route::post('user/update_password/{id}', [App\Http\Controllers\API\APIUserController::class, 'update_password']);

Route::resource('/event', App\Http\Controllers\API\EventController::class);

Route::get('/event-detail/{id}', [App\Http\Controllers\API\EventController::class, 'product_detail']);

Route::get('/event-search/{search}', [App\Http\Controllers\API\EventController::class, 'search_product']);

Route::resource('/event', App\Http\Controllers\API\EventController::class);

Route::resource('/seo', App\Http\Controllers\API\SeoController::class);

Route::get('pickup_point/{id}', [App\Http\Controllers\API\EventController::class, 'pickuppoint_by_county']);

Route::get('county/{id}', [App\Http\Controllers\API\EventController::class, 'county_by_Id']);

Route::get('/get_price/{product_id}/{county_id}/{pickup_id}', [App\Http\Controllers\API\EventController::class, 'get_price']);

Route::post('login', [App\Http\Controllers\API\APIEmployeeController::class, 'doLogin']);

Route::post('/booking', [App\Http\Controllers\API\EventController::class, 'book_product']);

Route::get('companies', [App\Http\Controllers\API\APIClientController::class, 'index']);
Route::post('/payment', [App\Http\Controllers\StripeController::class, 'stripePost']);

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

Route::get('test', function () {

    $user = [
        'name' => 'Harsukh Makwana',
        'info' => 'Laravel & Python Devloper'
    ];

    \Mail::to('viradoj301@exoacre.com')->send(new \App\Mail\NewMail($user));

    dd("success");
});
