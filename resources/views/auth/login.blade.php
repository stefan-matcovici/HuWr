@extends('layouts.welcome')

@section('assets')
	<link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">
@endsection

@section('content')
<div class="login-container">
		<div class="flex-container">
			<h3 class="flex-item">Login</h3>
			<form class = "input-container" method="POST" action="{{ route('login') }}">
				{{csrf_field()}}
				<div class="label-input-container">
				<label  for="email">Email</label>		
					<input class="flex-item" type="email" name="email" id="email">
		
					@if ($errors->has('email'))		
						<span class="help-block">		
							<strong>{{ $errors->first('email') }}</strong>		
						</span>		
					@endif 
				</div>
				<div class="label-input-container">
					<label for="password">Password</label>
					<input class="flex-item" type="password" name="password" id="password">
				</div>


				<button class="flex-item" id="loginButton" type="submit">Login</button>

				<div class="foreign-login-container">
					<a class="btn-facebook" href="{{route('twitter.login')}}">
						<span class="fa fa-twitter-square fa-6">
						</span> 
						Sign in with Twitter
					</a>
				</div>

				<div class="foreign-login-container-minmized">
					<a href="{{route('twitter.login')}}">
						<span class="fa fa-twitter-square fa-6">
						</span> 
					</a>
				</div>
				
			</form>
		</div>
	</div>
@endsection