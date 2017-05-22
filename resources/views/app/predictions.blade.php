@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/predictions.css')}}">
@endsection

@section('content')
    <script type="text/javascript" src="{{asset('js/countries.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/climate.js')}}"></script>

    <div class="image-form-div">
        <div class="image-div">
            <img alt="world image" src="{{asset('img/world.svg')}}">
        </div>


        <div class="prediction-form-div">
            <div class="introduction">
                <h3> Set your options </h3>
            </div>
            <form id="prediction-form-container" method="post">
                <div class="container-div">
                    <div class="year">
                        <label class="date" for="year"> From </label>
                        <input type="date" min="2017" max="2027" placeholder="Enter year">
                    </div>


                    <div class="year">
                        <label class="date" for="year"> To </label>
                        <input type="date" min="2017" max="2027" placeholder="Enter year">
                    </div>

                    <div class="radio-div">
                        <label class="date"> Age </label>
                        <div class="sub-radio-div">
                            <label>
                                Child:
                            </label>
                            <input class="radio-class" type="radio" name="radio">
                            <label>
                                Adult:
                            </label>
                            <input class="radio-class" type="radio" name="radio">
                        </div>
                    </div>

                    <div class="location-selection">
                        <label class="label-input-left"> Location
                            <select class="location-input" id="country-location" name="country-location"></select>
                        </label>
                        <script type="text/javascript">
                            populateCountries("country-location");
                        </script>
                    </div>

                    <div class="climate-selection">
                        <label class="label-input-left"> Climate
                            <select class="climate-input" id="climate-location" name="climate-location"></select>
                        </label>
                        <script type="text/javascript">
                            populateClimates("climate-location");
                        </script>
                    </div>

                    <div class="submit-button-div">
                        <input class="button" type="submit" name="submit" value="Send">
                    </div>

                </div>

            </form>

        </div>

    </div>