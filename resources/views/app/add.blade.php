@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/add.css')}}">
@endsection

@section('content')
    <script src="{{asset('js/countries_states.js')}}"></script>

    <div class="add-migration-div-container">
        <h1>
            Add migration
        </h1>

        <div class="image-form-container">

            <div class="add-migration-image-div">
                <img id="migration-image" src="{{ asset('img/migration.png') }}" alt="Migration image"/>
            </div>

            <form class="add-migration-form-container" action="{{route('add.migration')}}" method="post">
                {{csrf_field()}}
                <div class="migration-div">
                    <div class="location-selection">
                        <label class="label-input-left">
                            Departure location:
                            <select id="country-departure" name="country-departure"></select>
                        </label>
                        <label class="label-input-left">

                            <select id="state-departure" name="state-departure"></select>
                        </label>


                        <label class="label-input-left">
                            Destination location:
                            <select id="country-destination" name="country-destination"></select>

                        </label>

                        <label class="label-input-left">
                            <select id="state-destination" name="state-destination"></select>
                        </label>

                        <script type="text/javascript">
                            populateCountries("country-departure", "state-departure");
                            populateCountries("country-destination", "state-destination");
                        </script>
                    </div>

                    <div class="location-selection">
                        <label class="label-input-right">
                            Reason:
                            <select name="reason">
                                <option value="Economics">
                                    Economics
                                </option>
                                <option value="War">
                                    War
                                </option>
                                <option value="Personal">
                                    Personal
                                </option>
                                <option value="Education">
                                    Education
                                </option>
                                <option value="Religion">
                                    Religion
                                </option>
                                <option value="Other">
                                    Other
                                </option>
                            </select>
                        </label>

                        <label class="label-input-right">
                            Number of adults:
                            <input class="number-input" type="number" name="number-of-adults" value="0" min="0" max="1000">
                        </label>

                        <label class="label-input-right">
                            Number of children:
                            <input class="number-input" type="number" name="number-of-children" value="0" min="0" max="1000">
                        </label>

                    </div>
                </div>
                <label>
                    Share on Twitter
                    <input type="checkbox" name="twitter-share">
                </label>
                <div class="submit-button-div">
                    <input type="submit" name="submit" value="Add" class="button">
                </div>
            </form>
        </div>
    </div>