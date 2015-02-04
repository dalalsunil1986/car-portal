@extends('layouts._three_column')

@section('content')
    <div class="one-column sign-up-forum">


        {!! Form::open(['action' => 'AuthController@postLogin', 'method' => 'post', 'class'=>'register-signin-form']) !!}

        <h3>Login or <a href="{{ action('AuthController@getSignup') }}">Register</a></h3>

        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('word.email') ]) !!}
        </div>
        <span class="help-block"></span>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('word.password') ]) !!}
        </div>
        <span class="help-block"></span>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

        {!! Form::close() !!}

    </div>

@stop