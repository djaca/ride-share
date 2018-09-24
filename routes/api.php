<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cities', function () {
    $query = request()->keywords;

    $cities = \App\City::where('name', 'LIKE', "%$query%")
                       ->select(['id', 'name', 'country'])
                       ->get();

    return response()->json($cities);
});

Route::get('cities/{city}', function (\App\City $city) {
    return response()->json($city->only(['id', 'name', 'country']));
});
