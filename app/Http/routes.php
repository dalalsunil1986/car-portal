<?php

/*********************************************************************************************************
 * API Routes
 ********************************************************************************************************/
Route::group(['prefix' => 'api/v1'], function () {

    Route::group(['prefix' => 'cars', 'namespace' => 'Car'], function () {

        Route::get('search', 'CarSearchController@search'); // get Filter ( Ajax )
        Route::get('name', 'CarSearchController@getFilterNames');

        Route::get('cars/{id}/favorite', 'CarController@favorite');
        Route::get('/', 'CarController@getCars');

    });

    /*********************************************************************************************************
     * Favorites
     ********************************************************************************************************/
    Route::resource('favorites', 'FavoritesController');

    /*********************************************************************************************************
     * Notifcation
     ********************************************************************************************************/
    Route::get('notifications/test', 'NotificationsController@test');

    Route::resource('notifications', 'NotificationsController'); //todo : change to post

    Route::get('/', function () {
        return 'cars api site';
    });

});