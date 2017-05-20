@extends('layouts.welcome')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/register.css')}}">
    <script src="{{asset('js/countries_states.js')}}"></script>
@endsection

@section('content')
    <div class="introduction-sign-up-form-div">
        <h2>
            Create your personal account
        </h2>
        <div class="sign-up-div">
            <div class="image-div">
                <img src="{{ asset('img/logo.png') }}" alt="image">
            </div>

            <div class="sign-up-form-div">
                <form id="form-propr" method="POST" action="{{ route('register') }}">
                    {{csrf_field()}}
                    <div class="name">
                        <label class="date" for="first-name"> <strong> Name </strong> </label>
                        <div class="name-input-div">
                            <input class="name-input" type="text" id="first-name" placeholder="First" name="first-name">
                            @if ($errors->has('first-name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('first-name') }}</strong>
                                    </span>
                            @endif
                            <input class="name-input" type="text" id="last-name" placeholder="Last" name="last-name">
                            @if ($errors->has('last-name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('last-name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="username">
                        <label class="date" for="username"> <strong> Username </strong> </label>
                        <input type="text" id="username" placeholder="Enter your Username" name="username">
                        @if ($errors->has('username'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="password">
                        <label class="date" for="password"> <strong> Password </strong> </label>
                        <input type="password" id="password" placeholder="Enter your Password" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="password_confirm">
                        <label class="date" for="password"> <strong> Confirm Password </strong> </label>
                        <input type="password" id="password-confirm" placeholder="Confirm your Password"
                               name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="birth">
                        <label class="date" for="birth"> Birthday </label>
                        <input type="date" id="birth" name="birthday">
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="gender-div">
                        <label class="date" for="gender-female"> <strong> Gender </strong> </label>
                        <div class="sub-gender-div">
                            <label>
                                Female:
                            </label>
                            <input class="gender-class" type="radio" id="gender-female" name="female">
                            @if ($errors->has('female'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                            @endif

                            <label>
                                Male:
                            </label>
                            <input class="gender-class" type="radio" id="gender-male" name="male">
                            @if ($errors->has('male'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="email">
                        <label class="date" for="email"> <strong> Email </strong> </label>
                        <input type="text" id="email" placeholder="Enter your Email" name="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="button-div">
                        <input class="button" type="submit" name="submit" value="Send">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection