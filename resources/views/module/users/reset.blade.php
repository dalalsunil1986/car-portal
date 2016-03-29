@extends('....layouts._three_columns_left_right_sidebar')

<!-- Styles -->
@section('styles')
@parent
{{ HTML::style('site/css/global-simple.css') }}
{{ HTML::style('site/css/login.css') }}
{{ HTML::style('site/css/car-page.css') }}
@stop
<!--Content Start-->
@section('scripts')
@parent
<script>
    $('.omb_btn-facebook').addClass('animated fadeInLeft');
    $('.omb_btn-twitter').addClass('animated fadeInLeft');
    $('.omb_btn-google').addClass('animated fadeInLeft');
    $('.forum').addClass('animated fadeInDown');
</script>
@stop

    <div class="omb_login forum">
    	<h3 class="omb_authTitle">Enter your new password!</a></h3>
		

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">
                {{ Form::open(['action' => 'AuthController@postPasswordReset', 'method' => 'post']) }}
                    <input type="hidden" name="token" value="{{ $token }}">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email' ]) }}
					</div>
                    <span class="help-block"></span>
                    
                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password' ]) }}
                    </div>

                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-asterisk  fa-spin"></i></span>
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password' ]) }}
					</div>
                    <span class="help-block"></span>

					<button class="btn btn-lg btn-primary btn-block" type="submit">Yalla! Sign Up</button>
				</form>
			</div>
    	</div>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">
				<label class="checkbox">
					<input type="checkbox" value="remember-me">Remember Me
				</label>
			</div>
			
		</div>	    
        
       
		
	</div>
