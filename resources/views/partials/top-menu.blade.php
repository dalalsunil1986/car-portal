<div class="row clearfix language-bar">
    <div class="col-md-12">

        @if(App::getLocale() == 'en')
            <span class="pull-right"><a href="{{action('LocaleController@setLocale',['ar']) }} "> العربية  </a></span>
        @else
            <span class="pull-right"><a href="{{action('LocaleController@setLocale',['en']) }} "> English  </a></span>
        @endif

        @if(Auth::check())
            <span class=" pull-right register" ><a href="{{action('AuthController@getLogout')}}"> Logout</a></span>
        @else
            <span class=" pull-right"><a href="{{ action('AuthController@getLogin') }}">Login</a></span>
            <span class=" pull-right register"><a href="{{ action('AuthController@getSignup') }}"> Register</a></span>
        @endif
    </div>
</div>