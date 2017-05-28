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

@section('content')
<div class="body-container">
    <h1>
        <img class="migration-image" alt="migration" src="https://cdn.pixabay.com/photo/2017/02/01/11/13/couple-2029712_960_720.png">
        Migration Feed
        <img class="migration-image" alt="migration" src="https://cdn.pixabay.com/photo/2017/02/01/11/13/couple-2029712_960_720.png">
    </h1>
    <div class="submit-button-div">
        <a href="{{route('feed.get')}}">Feed</a>
    </div>

    <div class="table-div">
        <table>
            <tr>
                <th class="from-cell"> <div> From</div> </th>
                <th class="reason-cell"> <div>  Reason </div> </th>
                <th class="to-cell"> <div>  To </div> </th>
            </tr>

            @foreach($migrations as $migration)
                <tr>
                <td class="from-cell">
                    <div class="f32">
                        <div class="flag {{strtolower($migration->departure_country)}}"></div>
                    </div>
                    Country:<script>
                        document.write(getCountryName('{{$migration->departure_country}}'));
                    </script> <br>
                    City:{{$migration->departure_city}}
                </td>
                <td class="reason-cell">
                    <div class="username">
                        User: {{$migration->user->username}}
                    </div>
                    <div class="reason">
                        Reason: {{$migration->reason}}
                    </div>
                    @if ($migration->reason == 'Education')
                        <img class="reason-image" src="{{asset('img/reason/education.svg')}}" alt="Economics Reason photo">
                    @elseif ($migration->reason == 'Religion')
                        <img class="reason-image" src="{{asset('img/reason/religion.svg')}}" alt="Religion Reason photo">
                    @elseif ($migration->reason == 'Economics')
                        <img class="reason-image" src="{{asset('img/reason/money.svg')}}" alt="Economics Reason photo">
                    @elseif ($migration->reason == 'War')
                        <img class="reason-image" src="{{asset('img/reason/war.svg')}}" alt="War Reason photo">
                    @elseif ($migration->reason == 'Personal')
                        <img class="reason-image" src="{{asset('img/reason/personal.svg')}}" alt="Personal Reason photo">
                    @elseif ($migration->reason == 'Other')
                        <img class="reason-image" src="{{asset('img/reason/other.svg')}}" alt="Personal Reason photo">
                    @endif
                    <div class="number-adults-children-div">
                        <div class="number-adults-div">
                            Nr adults: {{$migration->adults}}
                        </div>
                        <div class="number-children-div">
                            Nr children: {{$migration->children}}
                        </div>							
                    </div>
                    <div class="time-elapsed">
                        5 minutes ago
                    </div>
                    
                </td>
                <td class="to-cell">
                    <div class="f32">
                        <div class="flag {{strtolower($migration->arrival_country)}}"></div>
                    </div>
                    Country:<script>
                        document.write(getCountryName('{{$migration->departure_country}}'));
                    </script> <br>
                    City:{{$migration->arrival_city}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    @include('pagination.default', ['paginator' => $migrations])
</div>
@endsection
