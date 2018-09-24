<?php

//Auth::login(\App\User::first());
Route::get('/', 'RidesController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('search', 'SearchController@index')->name('search');
Route::get('/rides/{ride}/{orderFromSource?}', 'RidesController@show')->name('rides.show');

Route::get('profile/{user}', 'ProfileController@show')->name('public.profile');

Route::group(['middleware' => 'auth', 'prefix' => 'offer-ride'], function () {
    Route::get('/1', 'RideStepperController@getStepOne')->name('offer.step.one');
    Route::post('/1', 'RideStepperController@postStepOne');

   Route::group(['middleware' => 'check-ride-session'], function () {
       Route::get('/2', 'RideStepperController@getStepTwo')->name('offer.step.two');
       Route::post('/2', 'RideStepperController@postStepTwo');

       Route::get('/3', 'RideStepperController@getStepThree')->name('offer.step.three');
       Route::post('/3', 'RideStepperController@postStepThree');
   });

});

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function () {
    Route::get('/', 'User\DashboardController@index')->name('dashboard');

    Route::get('profile', 'User\ProfileController@show')->name('profile');
    Route::patch('profile', 'User\ProfileController@update')->name('profile.update');

    Route::resource('cars', 'User\CarsController')->except(['show', 'destroy']);

    Route::get('photo', 'User\PhotoController@show')->name('photo');
    Route::post('photo', 'User\PhotoController@store')->name('photo.store');

    Route::get('preferences', 'User\PreferencesController@index')->name('preferences');
    Route::post('preferences', 'User\PreferencesController@store')->name('preferences.store');

    Route::post('requests', 'RideRequestsController@store')->name('requests.store');
    Route::post('rides/requests/{rideRequest}/review', 'RideRequestsController@review')
         ->name('rides.requests.review');

    Route::get('rides/offered', 'User\RidesOfferedController@index')->name('rides.offered.index');

    Route::get('rides/booked', 'User\RidesBookedController@index')->name('rides.booked.index');

    Route::get('rides/{ride}', 'User\RidesController@show')->name('user.ride.show');
});
