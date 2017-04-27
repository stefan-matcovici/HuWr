@extends('layouts.welcome')

@section('assets')
	<link rel="stylesheet" type="text/css" href="{{asset('css/register.css')}}">
	<script src="{{asset('js/country_states.js')}}"></script>
@endsection

@section('content')
<div class="introduction-sign-up-form-div">
	<h2>
		Create your personal account
	</h2>
	<div class="sign-up-div">
		<div class="image-div">
			<img src="../img/logo.png" alt="image">
		</div>

		<div class="sign-up-form-div">
			<form id="form-propr" action="action.php" method="get">
				<div class="name">
					<label class="date" for="first-name"> <strong> Name </strong> </label>
					<div class="name-input-div">
						<input class="name-input" type="text" id="first-name" placeholder="First" name="first-name">
						<input class="name-input" type="text" id="last-name" placeholder="Last" name="last-name">
					</div>
				</div>

				<div class="username">
					<label class="date" for="username"> <strong> Username </strong> </label>
					<input type="text" id="username" placeholder="Enter your Username" name="username">
				</div>

				<div class="password">
					<label class="date" for="password"> <strong> Password </strong> </label>
					<input type="password" id="password" placeholder="Enter your Password" name="password">
				</div>

				<div class="password_confirm">
					<label class="date" for="password"> <strong> Confirm Password </strong> </label>
					<input type="password" id="password-confirm" placeholder="Confirm your Password" name="password_confirm">
				</div>

				<div class="birth">
					<label class="date" for="birth"> Birthday </label>
					<input type="date" id="birth" name="day">
				</div>

				<div class="gender-div">
					<label class="date" for="gender-female"> <strong> Gender </strong> </label>
					<div class="sub-gender-div">
						<label>
											 	Female:	
											 </label>
						<input class="gender-class" type="radio" id="gender-female" name="gender">

						<label>
												Male:
											 </label>
						<input class="gender-class" type="radio" id="gender-male" name="gender">
					</div>
				</div>

				<div class="location-selection">
					<label class="label-input-left date">
							<strong> Location </strong>
						</label>
					<select class="location-input" id="country-location" name="country-location"></select>
					<select class="location-input" id="state-location" name="state-location"></select>
					<script type="text/javascript">
						populateCountries("country-location", "state-location");
					</script>
				</div>

				<div class="email">
					<label class="date" for="email"> <strong> Email </strong> </label>
					<input type="text" id="email" placeholder="Enter your Email" name="email">
				</div>

				<div class="button-div">
					<input class="button" type="submit" name="submit" value="Send">
				</div>
			</form>

		</div>
	</div>
</div>
@endsection