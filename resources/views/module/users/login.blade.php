@extends('layouts._three_column')

@section('content')
    <div class="one-column sign-up-forum">


        {!! Form::open(['action' => 'AuthController@postLogin', 'method' => 'post', 'class'=>'register-signin-form']) !!}

        <h3>Login or <a href="{{ action('AuthController@getSignup') }}">Register</a></h3>

        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('E-mail') ]) !!}
        </div>
        <span class="help-block"></span>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('Password') ]) !!}
        </div>
        <span class="help-block"></span>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

            <a href="" class="pull-right password-reset-link">Forgot password?</a>


        {!! Form::close() !!}

    </div>

@stop