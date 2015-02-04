<?php
/*********************************************************************************************************
 * Application Routes
 ********************************************************************************************************/
use App\Src\Message\Thread;

/*********************************************************************************************************
 * Car Routes
 ********************************************************************************************************/
$router->resource('cars', 'CarsController');

/*********************************************************************************************************
 * Auth Routes
 ********************************************************************************************************/
$router->get('login', ['as' => 'user.login.get', 'uses' => 'AuthController@getLogin']);

$router->post('login', ['as' => 'user.login.post', 'uses' => 'AuthController@postLogin']);

$router->get('account/logout', ['as' => 'user.logout', 'uses' => 'AuthController@getLogout']);

$router->get('signup', ['as' => 'user.register.get', 'uses' => 'AuthController@getSignup']);

$router->post('signup', ['as' => 'user.register.post', 'uses' => 'AuthController@postSignup']);

$router->get('account/forgot', ['as' => 'user.forgot.get', 'uses' => 'AuthController@getForgot']);

$router->post('account/forgot', ['as' => 'user.forgot.post', 'uses' => 'AuthController@postForgot']);

$router->get('password/reset/{token}', ['as' => 'user.token.get', 'uses' => 'AuthController@getReset']);

$router->post('password/reset', ['as' => 'user.token.post', 'uses' => 'AuthController@postReset']);

$router->get('account/activate/{token}', ['as' => 'user.token.confirm', 'uses' => 'AuthController@activate']);

$router->post('account/send-activation-link', ['as' => 'user.token.send-activation', 'uses' => 'AuthController@sendActivationLink']);

/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/
Route::get('user/{id}/profile', array('as' => 'profile', 'uses' => 'UsersController@getProfile'));

Route::resource('user', 'UsersController');

/*********************************************************************************************************
 * Messages
 ********************************************************************************************************/
$router->resource('messages', 'MessagesController');


/*********************************************************************************************************
 * Misc
 ********************************************************************************************************/

$router->get('/', ['as' => 'home', 'uses' => 'HomeController@index']);


/*********************************************************************************************************
 * API Routes
 ********************************************************************************************************/

$router->group(array('prefix' => 'api'), function ($router) {

	/*********************************************************************************************************
	 * Car Routes
	 ********************************************************************************************************/
	$router->get('cars/filter', 'CarsController@filter'); // get Filter ( Ajax )

	$router->get('cars/{id}/favorite', 'CarsController@favorite');

	$router->get('cars', 'CarsController@getCars');

	/*********************************************************************************************************
	 * Favorites
	 ********************************************************************************************************/
	$router->resource('favorites', 'FavoritesController');

	/*********************************************************************************************************
	 * Notifcation
	 ********************************************************************************************************/
	$router->get('notifications/notify','CarsController@getNotify');
});

Route::get('test', 'CarsController@getCars');