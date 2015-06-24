<?php

/*********************************************************************************************************
 * API Routes
 ********************************************************************************************************/
Route::group(['prefix' => 'api/v1'], function () {

    Route::group(['prefix' => 'cars', 'namespace' => 'Car'], function () {

        /*********************************************************************************************************
         * Car Routes
         ********************************************************************************************************/
        Route::get('search', 'CarSearchController@search'); // get Filter ( Ajax )

        Route::get('cars/{id}/favorite', 'CarsController@favorite');

        Route::get('cars/name', 'CarsController@getFilterNames');

        Route::get('cars', 'CarsController@getCars');
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