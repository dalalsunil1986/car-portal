<?php
/*********************************************************************************************************
 * Car Routes
 ********************************************************************************************************/
Route::resource('cars', 'CarsController');

/*********************************************************************************************************
 * Auth Routes
 ********************************************************************************************************/
Route::get('login', ['as' => 'user.login.get', 'uses' => 'AuthController@getLogin']);

Route::post('login', ['as' => 'user.login.post', 'uses' => 'AuthController@postLogin']);

Route::get('account/logout', ['as' => 'user.logout', 'uses' => 'AuthController@getLogout']);

Route::get('signup', ['as' => 'user.register.get', 'uses' => 'AuthController@getSignup']);

Route::post('signup', ['as' => 'user.register.post', 'uses' => 'AuthController@postSignup']);

Route::get('account/forgot', ['as' => 'user.forgot.get', 'uses' => 'AuthController@getForgot']);

Route::post('account/forgot', ['as' => 'user.forgot.post', 'uses' => 'AuthController@postForgot']);

Route::get('password/reset/{token}', ['as' => 'user.token.get', 'uses' => 'AuthController@getReset']);

Route::post('password/reset', ['as' => 'user.token.post', 'uses' => 'AuthController@postReset']);

Route::get('account/activate/{token}', ['as' => 'user.token.confirm', 'uses' => 'AuthController@activate']);

Route::post('account/send-activation-link', ['as' => 'user.token.send-activation', 'uses' => 'AuthController@sendActivationLink']);

/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/
Route::get('user/{id}/profile', array('as' => 'profile', 'uses' => 'UsersController@getProfile'));

Route::resource('user', 'UsersController');

/*********************************************************************************************************
 * Messages
 ********************************************************************************************************/
Route::resource('messages', 'MessagesController');


/*********************************************************************************************************
 * Misc
 ********************************************************************************************************/

Route::get('/', ['as' => 'home', 'uses' => 'CarsController@index']);


/*********************************************************************************************************
 * API Routes
 ********************************************************************************************************/

Route::group(array('prefix' => 'api'), function ($router) {

	/*********************************************************************************************************
	 * Car Routes
	 ********************************************************************************************************/
	Route::get('cars/filter', 'CarsController@filter'); // get Filter ( Ajax )

	Route::get('cars/{id}/favorite', 'CarsController@favorite');

	Route::get('cars/name','CarsController@getFilterNames');


	Route::get('cars', 'CarsController@getCars');

	/*********************************************************************************************************
	 * Favorites
	 ********************************************************************************************************/
	Route::resource('favorites', 'FavoritesController');

	/*********************************************************************************************************
	 * Notifcation
	 ********************************************************************************************************/
	Route::get('notifications/test', 'NotificationsController@test');
	Route::resource('notifications','NotificationsController'); //todo : change to post

});

Route::get('test', 'CarsController@getCars');