@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/statistics.css')}}">
@endsection

@section('content')
    <script type="text/javascript">
        var basicURI = "{{ route('welcome')}}";
        var statisticShareURI = "{{route('statistics-share') }}";
    </script>
    <script src="{{asset('js/countries_states.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://d3js.org/d3.v4.js"></script>
    <script src="{{asset('js/statistics.js')}}"></script>
    <script src="{{asset('js/getCountryCode.js')}}"></script>
    <script src="{{asset('js/svgToPdf.js')}}"></script>
    <script src="https://rawgit.com/exupero/saveSvgAsPng/gh-pages/saveSvgAsPng.js"></script>
    <script src="https://rawgit.com/MrRio/jsPDF/master/dist/jspdf.debug.js"></script>
    <script src="{{asset('js/FileSaver.js')}}"></script>

    <button id="open-modal-button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display: none">Open Modal</button>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Share statistic on Twitter</h4>
                </div>
                <div class="modal-body" id="modal-text">
                    <p>You shared this statistic succesfully on Twitter.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div class="jumbotron">

        <div class="card text-center rounded col-lg-10  mt-5 mx-auto" >
            <div class="card-block">
                <div class="location-selection">
                    <label class="label-input-center">Country</label>
                    <select class="location-input" id="country-location" name="country-location"></select>
                    <select class="location-input" id="state-location" name="state-location"></select>
                    <button type="button" class="btn btn-default mt-2" onclick="drawStatistics()">Go</button>
                    <script type="text/javascript">
                        populateCountries("country-location", "state-location");
                    </script>
                </div>
            </div>
        </div>
    </div>