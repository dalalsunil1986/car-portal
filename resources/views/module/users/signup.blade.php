@extends('layouts._three_column')

@section('content')
	<div class="one-column sign-up-forum">

		{!! Form::open(['action' => 'AuthController@postSignup', 'method' => 'post', 'class'=>'register-signin-form']) !!}

			<h3>Register or <a href="{{ action('AuthController@getLogin') }}">Login</a></h3>

			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
			</div>

			<span class="help-block"></span>

			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				{!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
			</div>
			<span class="help-block"></span>

			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
				{!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
			</div>
			<span class="help-block"></span>

			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
				{!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
			</div>
			<span class="help-block"></span>

			<button class="btn btn-lg btn-primary btn-block" type="submit">Yalla! Sign Up</button>

			<div class="tos-agreement">
				By pressing the sign up button you agree to the <a href="#">terms of service</a>.

			</div>
		{!! Form::close() !!}

	</div>
@stop