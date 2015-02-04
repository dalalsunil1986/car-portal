<div class="row clearfix language-bar">
    <div class="col-md-12">
        <span class="pull-right"><a href="#" class="arabic-lang">العربية</a></span>
        @if(Auth::check())
            <span class=" pull-right register" ><a href="{{action('AuthController@getLogout')}}"> Logout</a></span>
        @else
            <span class=" pull-right"><a href="{{ action('AuthController@getLogin') }}">Login</a></span>
            <span class=" pull-right register"><a href="{{ action('AuthController@getSignup') }}"> Register</a></span>
        @endif
    </div>
</div>