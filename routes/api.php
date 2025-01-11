<?php

use Illuminate\Http\Request;

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
Route::post('login', 'Auth\LoginController@apiLogin');
Route::post('register', 'Auth\RegisterController@apiRegister');
Route::get('/cities/{id}', 'API\ApiController@getCities');
Route::get('/getads/{id}', 'API\ApiController@getAds');
Route::get('countries', 'API\ApiController@getCountries');

Route::middleware('auth:api')->group(function(){
    Route::get('getItems', 'API\ItemsController@getItems');
    Route::get('getBaskets', 'API\ItemsController@getBaskets');
    Route::get('getAgents/{id}/{is_basket}', 'API\ItemsController@getAgents');
    Route::get('itemsByAgent/{agent_id}', 'API\ItemsController@itemsByAgent');
    Route::post('addToCart', 'API\OrdersController@addAllItemsToCart');
    Route::post('addItemToCart', 'API\OrdersController@addToCart');
    Route::post('makeOrder', 'API\OrdersController@makeOrder');
    Route::post('editCart', 'API\OrdersController@editCart');
    Route::get('getCart', 'API\OrdersController@getCart');
    Route::get('getOrders', 'API\OrdersController@getOrders');
    Route::get('getOffers', 'API\OrdersController@getOffers');
    Route::get('getOrder/{id}', 'API\OrdersController@getOrder');
    Route::post('verifyOrder', 'API\OrdersController@verifyOrder');
    Route::delete('cart/{id}', 'API\OrdersController@deleteFromCart');
    Route::delete('offers/{id}', 'API\OrdersController@deleteOffer');
});

// ->get('/user', function (Request $request) {
//     return $request->user();
// })