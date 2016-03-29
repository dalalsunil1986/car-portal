@extends('....layouts._three_columns_left_right_sidebar')

<!-- Styles -->
@section('styles')
@parent
{{ HTML::style('site/css/car-page.css') }}
{{ HTML::style('site/css/login.css') }}
{{ HTML::style('site/css/signup.css') }}
@stop
<!--Content Start-->
<!--Content Start-->
<div class="omb_login forum">

    <h3 class="omb_authTitle">Forgot your password? Dont worry, we can help. Provide us with your account email so we may assit you.</h3>

    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-6">
            {{ Form::open(['action' => 'AuthController@postForgotPassword', 'method' => 'post'], ['class'=>'omb_loginForm']) }}

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email' ]) }}
                </div>
                <span class="help-block"></span>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Yalla Go!</button>

            {{ Form::close() }}
        </div>
    </div>

</div>
