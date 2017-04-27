@extends('layouts.welcome')

@section('assets')
	<link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">
@endsection

@section('content')
<div class="login-container">
		<div class="flex-container">
			<h3 class="flex-item">Login</h3>
			<form class = "input-container">
				<div class="label-input-container">
					<label  for="username">Username</label>
					<input class="flex-item" type="text" name="username" id="username">
				</div>
				<div class="label-input-container">
					<label for="password">Password</label>
					<input class="flex-item" type="password" name="password" id="password">
				</div>


				<button class="flex-item" id="loginButton" type="submit">Login</button>

				<div class="foreign-login-container">
					<a class="btn-facebook">
						<span class="fa fa-facebook-square fa-6">
						</span> 
						Sign in with Facebook
					</a>
				</div>

				<div class="foreign-login-container-minmized">
					<a>
						<span class="fa fa-facebook-square fa-6">
						</span> 
					</a>
				</div>
				
			</form>
		</div>
	</div>
@endsection
