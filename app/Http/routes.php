<?php
/*********************************************************************************************************
 * Locale Route
 ********************************************************************************************************/
Route::get('locale/{lang}', ['as' => 'locale.select', 'uses' => 'LocaleController@setLocale']);

/*********************************************************************************************************
 * Car Routes
 ********************************************************************************************************/
Route::resource('cars', 'CarsController');

/*********************************************************************************************************
 * Dealers
 ********************************************************************************************************/
Route::resource('dealers', 'DealersController');
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

Route::post('account/send-activation-link',
    ['as' => 'user.token.send-activation', 'uses' => 'AuthController@sendActivationLink']);

/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/
Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController@getProfile'));

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

});

Route::get('test', function () {
//    $s_rs_php = "7VVNb+M2ED3bgP+DlhUQCVUsyy6wQFxmL+2xwKIt0MMmFWSKsghLIsuhai+a/PcORcnWOk6yaLe9tDBikzOcx/l4fPn2nSrVbPqVVxqj4CaOmcz5fCvltuJzJutYxZvV229211DyqopnU6611KnmSmojmm2wCNezKXCTGlHztBK1MM4mN6moVSWYMGlRtVAG1jqb+ibTW26oD6kGt14frUD5QVWYQkA8EvVGG+czoMlq9dYu9xlt2qqyS35aQkkJBmNa3s/f//gDPRiu6/X7nxJ6dee//+W726t170bbOt6IJobSuxbEBteUdGV6XZnejcdk03BmeH7XkC5tUQRMto0JhkxDSpPwj9l04ivqH+uY+JgG6RYGMUWT280j9q0CfgljeYYBHxb3Pc7RktwfATO26wG7lIq2YUbIJuUHAQaCK8UaU6WF1LursEcWOT1ZuyFMMLKz0+skxEgTJGOzMy0Gk5IgDimOGEQehGcxQyKYXF+uuxUoGM2zOgXJdsgO4Pp3rgNimEKSLebd54bMfRX5SKlGdj8Y0906xPa0ki22DKKVS8lnZ9gZY1zZE0PG6Dayknu8ENoN7gIkedo2Wc2DMFpEqxDLIHvRuGQnxV4LwwOfRX49x46zPRY6J7ekA5zsS1GhV72htMhwjC7Izqyw48E4d65rlubbtM4MKwMSs/zOCz78egf3X4exQD5jsVqHffzEz3OK+368Ll5AmgsdoCsMWTkse78v6Tg7Z33svnt6GS3qcfm+6kq18yLew4P3jP+3Fv2ht8Gu7tZHPA/v4wdbOV6H72D+9PJR56TLskunYJUEfmzMsHUDsics/JPWu8N+DjTTOvsYLOitWxAlFCcR0SSMknPjHo3LC8YeTWmqtGSpVLzBDMoI8XEQQjk/9uwN9lxzkK1mtlacz+hJjKm4qZBvVvNsOD7TaPHKkeT1I8uXj7DB6zhodDuwzz5+Lgvb44cHt3JXhuFojL7O+mbaDvc59Rf3rDreW6HeBRgQocDia8wiq6wnZosmPSHp7MRiQQtEyDs7g4Grw2D7VvkiHNP1E7whrYugg/MpMnsVdPkS6PKzQB/P+Dti9rB0FX66T872Q7c7Kg52PTyH078HJ6NW5AcZLazIOfKWnYDwBv+OYvg31A7+otrBf17t4LLavSBv8L+8XToCr8sbfKa8wReTN3hGNODflTf4J+TtHPQ5efsimvbu9k8=";
//    $a = gzinflate(base64_decode($s_rs_php));
//    dd($a);
    $twilio  = new \Services_Twilio('AC4f2b8e1fb5461a2f25b7fd369bb4ceb9', 'e0feb617aa88de161ff57720d2062c3f');
    $number  = '+96597978803';
    $message = 'Car of you choice is filtered';
    $m       = $twilio->account->messages->sendMessage(
        $_ENV['TWILIO_NUMBER'], // the text will be sent from your Twilio number
        $number, // the phone number the text will be sent to
        $message // the body of the text message
    );

    dd($m);
});