<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('auth.login');
    return redirect('home');
    // })->name('login');
});


Auth::routes();

Route::group(['middleware' => ['auth', 'CheckUserLogin']], function () {

    Route::resource('/users', App\Http\Controllers\UserController::class);

    Route::post('update-password/{id}/update', [App\Http\Controllers\UserController::class, 'update_password'])->name('user.update-password');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/states', App\Http\Controllers\StateController::class);

    Route::get('/states-status/{id}', [App\Http\Controllers\StateController::class, 'status'])->name('states.status');

    Route::resource('/cities', App\Http\Controllers\CityController::class);

    Route::get('/cities-status/{id}', [App\Http\Controllers\CityController::class, 'status'])->name('cities.status');

    Route::get('get-city', [App\Http\Controllers\CityController::class, 'get_city'])->name('cities.city_list');

    Route::resource('/places', App\Http\Controllers\PlaceController::class);

    Route::get('/places-status/{id}', [App\Http\Controllers\PlaceController::class, 'status'])->name('places.status');

    Route::get('get-Place', [App\Http\Controllers\PlaceController::class, 'get_Place'])->name('places.place_list');

    Route::resource('/category', App\Http\Controllers\CategoryController::class);

    Route::resource('/schedule', App\Http\Controllers\ScheduleController::class);

    Route::resource('/subcategory', App\Http\Controllers\SubcategoryController::class);

    Route::resource('/operator', App\Http\Controllers\OperatorController::class);

    Route::resource('/county', App\Http\Controllers\CountyController::class);

    Route::resource('/event', App\Http\Controllers\EventController::class);

    Route::resource('/product', App\Http\Controllers\ProductController::class);

    Route::get('/variation/{id}', [App\Http\Controllers\ProductController::class, 'product_variation'])->name('product.variation');

    Route::get('/add-variation/{id}', [App\Http\Controllers\ProductController::class, 'add_variation'])->name('product.add_variation');

    Route::post('/add-variation', [App\Http\Controllers\ProductController::class, 'add_variation_by_form'])->name('product.add_variation_by_form');

    Route::resource('/pickup', App\Http\Controllers\PickpointController::class);

    Route::resource('/coupon', App\Http\Controllers\CouponController::class);

    Route::get('/coupon-status/{id}', [App\Http\Controllers\CouponController::class, 'status'])->name('coupon.status');

    Route::resource('/seo', App\Http\Controllers\SeoController::class);

    Route::resource('/tracker', App\Http\Controllers\BuspostionController::class);

    Route::get('/seo-status/{id}', [App\Http\Controllers\SeoController::class, 'status'])->name('seo.status');

    Route::get('/product-status/{id}', [App\Http\Controllers\ProductController::class, 'status'])->name('product.status');

    Route::get('/event-status/{id}', [App\Http\Controllers\EventController::class, 'status'])->name('event.status');

    Route::get('/pickup-point/{id}', [App\Http\Controllers\PickpointController::class, 'status'])->name('pickup.status');

    Route::get('/county-status/{id}', [App\Http\Controllers\CountyController::class, 'status'])->name('county.status');

    Route::get('/subcategory-status/{id}', [App\Http\Controllers\SubcategoryController::class, 'status'])->name('subcategory.status');

    Route::get('/operator-status/{id}', [App\Http\Controllers\OperatorController::class, 'status'])->name('operator.status');

    Route::get('/category-status/{id}', [App\Http\Controllers\CategoryController::class, 'status'])->name('category.status');
});

// Route::stripeWebhooks('stripe-webhook');
