<?php

/*********************************************************************************************************
 * API Routes
 ********************************************************************************************************/
Route::group(array('prefix' => 'api/v1'), function ($router) {

    /*********************************************************************************************************
     * Car Routes
     ********************************************************************************************************/
    Route::get('cars/filter', 'CarsController@filter'); // get Filter ( Ajax )

    Route::get('cars/{id}/favorite', 'CarsController@favorite');

    Route::get('cars/name', 'CarsController@getFilterNames');

    Route::get('cars', 'CarsController@getCars');

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