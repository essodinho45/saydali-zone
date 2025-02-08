<?php

use App\Advertisement;
use App\Post;

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
//Clear configurations:
Route::get('/config-clear', function () {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function () {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

//Clear configuration cache:
Route::get('/config-cache', function () {
    $status = Artisan::call('config:cache');
    return '<h1>Configurations cache cleared</h1>';
});

//Generate Key:
Route::get('/gen-key', function () {
    $status = Artisan::call('key:generate');
    return '<h1>Key Generated</h1>';
});

Route::get('welcome/{locale}', function ($locale) {
    App::setLocale($locale);

    //
});

Route::get('/', function () {
    try {
        $ads = Advertisement::whereIn('position', [1, 2])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return view('welcome', ['posts' => $posts, 'ads' => $ads]);
    } catch (\Exception $e) {
        dd($e);
    }
});


Auth::routes(['verify' => true]);

Route::get('/firebase', function () {
    return view('firebase');
})->name('firebase');
Route::post('/save-push-notification-token', 'HomeController@savePushNotificationToken')->name('save-push-notification-token');
Route::post('/send-push-notification', 'HomeController@sendPushNotification')->name('send.push-notification');

Route::get('error403', 'HomeController@error403')->name("error403");
Route::get('/news', 'PostsController@index')->name('news');
// Route::get('verification.notice', 'HomeController@showVerNote')->name("verification.notice");
Route::get('freezed.notice', 'HomeController@showFrzNote')->name("freezed.notice");
// Route::get('verification.verify', 'HomeController@showVerNote')->name("verification.verify");

Route::middleware('isAdmin')->group(function () {
    Route::post('/createUserByAdmin', 'HomeController@createUserByAdmin')->name('createUser');
    Route::get('/createUserByAdminForm', 'HomeController@createUserByAdminForm')->name('createUserForm');
    Route::put('user/verify', 'HomeController@verUser')->name('verUser');
    Route::put('user/freeze', 'HomeController@frzUser')->name('frzUser');
    Route::put('user/unfreeze', 'HomeController@unfrzUser')->name('unfrzUser');
    Route::get('/users', 'HomeController@allUsers')->name('allUsers');
    Route::post('/addDist/{id}', 'UserRelationsController@saveDist')->name('saveDist');

    Route::post('/ads', 'AdvertisementController@store')->name('storeAds');
    Route::get('/ads', 'AdvertisementController@index')->name('ads');
    Route::get('/ads/create', 'AdvertisementController@create')->name('createAds');
    Route::get('/ads/{id}/edit', 'AdvertisementController@edit')->name('editAds');
    Route::put('/ads/{id}', 'AdvertisementController@update')->name('updateAds');
    Route::put('/ads/{id}/stop', 'AdvertisementController@stop')->name('stopAds');
    Route::delete('/ads/{id}', 'AdvertisementController@destroy')->name('deleteAds');
    Route::delete('orders/{id}', 'OrdersController@destroy')->name('deleteOrder');
    Route::delete('user/{id}', 'UserRelationsController@delUser')->name('deleteUser');
    Route::get('migrate', 'HomeController@migrate')->name('migrate');
});

Route::middleware('verified')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/user/{id}/edit', 'HomeController@editUser')->name('editUser');
    Route::get('/user/editPassword', 'HomeController@editPassword')->name('editPassword');
    Route::put('/user/updatePass', 'HomeController@updatePassword')->name('updatePassword');
    Route::put('/user/{id}', 'HomeController@updateUser')->name('updateUser');


    //news routes
    Route::post('/news', 'PostsController@store')->name('storePost');
    Route::get('news/create', 'PostsController@create')->name('createPost');
    Route::get('news/{id}/edit', 'PostsController@edit')->name('editPost');
    Route::put('news/{id}', 'PostsController@update')->name('updatePost');
    Route::delete('news/{id}', 'PostsController@destroy')->name('deletePost');


    //excel routes
    Route::get('items/importfromexcel', 'ItemsController@importItems')->name('importItems');
    Route::post('items/importfromexcel', 'ItemsController@import')->name('storeItems');


    //items routes
    Route::get('items', 'ItemsController@index')->name('items');
    Route::post('items', 'ItemsController@store')->name('storeItem');
    Route::get('items/create', 'ItemsController@create')->name('createItem');
    Route::get('items/{id}', 'ItemsController@show')->name('showItem');
    Route::get('items/{id}/edit', 'ItemsController@edit')->name('editItem');
    Route::put('items/{id}', 'ItemsController@update')->name('updateItem');
    Route::delete('items/{id}', 'ItemsController@destroy')->name('deleteItem');
    Route::post('items/freeze', 'ItemsController@freezeItemByUser')->name('freezeItem');
    Route::get('items/itemsByAgent/{agent_id}', 'ItemsController@itemsByAgent')->name('itemsByAgent');
    Route::post('setMaxQuantity', 'ItemsController@setMaxQuantity')->name('setMaxQuantity');


    //orders routes
    Route::get('orders', 'OrdersController@index')->name('orders');
    Route::post('orders', 'OrdersController@store')->name('storeOrder');
    Route::get('orders/create', 'OrdersController@create')->name('createOrder');
    Route::put('orders/verifyItem', 'OrdersController@verifyItem')->name('verifyItemInOrder');
    Route::get('orders/{id}', 'OrdersController@show')->name('showOrder');
    Route::put('orders/{id}', 'OrdersController@update')->name('verifyOrder');
    Route::get('cart', 'OrdersController@cart')->name('cart');
    Route::post('addToCart', 'OrdersController@addToCart')->name('addToCart');
    Route::delete('cart/{id}', 'OrdersController@deleteFromCart')->name('deleteCart');
    Route::post('cart/postItem', 'OrdersController@postItem')->name('postItem');
    Route::post('cart/postItemAgent', 'OrdersController@postItemAgent')->name('postItemAgent');
    Route::post('addAllItemsToCart', 'OrdersController@addAllItemsToCart')->name('addAllItemsToCart');


    //offers routes
    Route::get('/offers', 'OffersController@index')->name('offers');
    Route::post('/offers', 'OffersController@store')->name('storeOffer');
    Route::delete('offers/{type}/{id}', 'OffersController@destroy')->name('deleteOffer');
    Route::get('offers/create', 'OffersController@create')->name('createOffer');
    Route::get('offers/{type}/{id}/edit', 'OffersController@edit')->name('editOffer');
    Route::put('offers/{id}', 'OffersController@update')->name('updateOffer');
    Route::get('offers/{type}/{id}', 'OffersController@show')->name('showOffer');

    Route::post('ajaxItemRequest', 'ItemsController@ajaxItemRequest');


    //user relations routes
    Route::get('userRelations/agents', 'UserRelationsController@availableChildren')->name('agents');
    // Route::get('userRelations/agentsDist', 'UserRelationsController@availableParents')->name('agentsDist');
    Route::post('userRelations/child', 'UserRelationsController@addChild')->name('addChild');
    Route::post('userRelations/parent', 'UserRelationsController@addParent')->name('addParent');
    Route::put('userRelations/freeze', 'UserRelationsController@freezeRelation')->name('freezeRelation');
    Route::post('userRelations/requestAg', 'UserRelationsController@requestRelation')->name('requestRelation');
    Route::put('userRelations/verify', 'UserRelationsController@verifyRelation')->name('verifyRelation');

    Route::get('userRelations/distributors', 'UserRelationsController@availableChildren')->name('distributors');
    Route::get('userRelations/pharmacists', 'UserRelationsController@availableChildren')->name('pharmacists');

    Route::get('userRelations/companies', 'UserRelationsController@availableParents')->name('companies');
    Route::get('userRelations/showFav', 'UserRelationsController@showFavAg')->name('showFav');
    Route::get('userRelations/addFav', 'UserRelationsController@addFavAg')->name('addFav');
    Route::post('userRelations/createFavAg', 'UserRelationsController@createFavAg')->name('createFavAg');
    Route::post('ajaxFavAgRequest', 'UserRelationsController@ajaxFavAgRequest')->name('ajaxFavAgRequest');
    Route::delete('removeFavAg/{comp_id}/{id}', 'UserRelationsController@removeFavAg')->name('removeFavAg');
    // Route::post('userRelations/companies', 'UserRelationsController@addCompanies')->name('companies');
    // Route::delete('userRelations/companies/{id}', 'UserRelationsController@removeCompany')->name('removeCompany');

    //reports routes
    Route::get('reports/orders', 'ReportsController@ordersReport')->name('ordersReport');
    Route::post('reports/updateOrders', 'ReportsController@updateOrdersReport')->name('updateOrdersReport');

    Route::get('/showUsr/{id}', 'UserRelationsController@showUsr')->name('showUsr');
    Route::get('/setDistCompanies/{id}', 'UserRelationsController@setDistCompanies')->name('setDistCompanies');
    Route::post('/addCompsToDist/{id}', 'UserRelationsController@addCompsToDist')->name('addCompsToDist');

});

Route::get('news/{id}', 'PostsController@show')->name('showPost');
Route::post('ajaxCountryRequest', 'HomeController@ajaxCountryRequest');
