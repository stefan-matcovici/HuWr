@extends('layouts.welcome')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/feed.css')}}">
    <link
            rel="stylesheet"
            type="text/css"
            href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css"
    />
    <script src="{{asset('js/getCountryName.js')}}"></script>
@endsection