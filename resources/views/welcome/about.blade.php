@extends('layouts.welcome')

@section('assets')
	<link rel="stylesheet" type="text/css" href="{{asset('css/about_us.css')}}">
@endsection

@section('content')
<div class="content-container">
    <h1>
        About us
    </h1>
    <div class="information-container">
        <div class="personal-information">
            <img alt="avatar" class="personal-image" src="https://scontent.fotp3-3.fna.fbcdn.net/v/t34.0-12/19198151_768101280031806_1710414693_n.jpg?oh=26a2549e73abe2837806017c6743d2a7&oe=5941B512">
            <h3>
                Luca Andrei
            </h3>
            <p>
                Student at Faculty of Computer Science Iasi
            </p>

        </div>
        <div class="personal-information">
            <img  alt="avatar" class="personal-image" src="{{asset('img/stefan.jpg')}}">
            <h3>
                Stefan Matcovici
            </h3>
            <p>
                Student at Faculty of Computer Science Iasi
            </p>
            <p>
                <strong> Team Founder </strong>
            </p>

        </div>
        <div class="personal-information">
            <img alt="avatar" class="personal-image" src="https://scontent.fotp3-3.fna.fbcdn.net/v/t1.0-9/18486420_461102364237586_2877046768285819798_n.jpg?oh=2962f8410a5db4f48439e5f50f0a2006&oe=59DA0610">
            <h3>
                Opariuc Ariana
            </h3>
            <p>
                Student at Faculty of Computer Science Iasi
            </p>
        </div>
    </div>
</div>
@endsection
