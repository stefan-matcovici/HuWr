<!DOCTYPE html>
<html lang="en">

<head>
  <title> HuWr Home </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
    crossorigin="anonymous">
  
  <!-- Assets for this page -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/home.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Fanwood+Text" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quintessential" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Specific assets -->
  @yield('assets')

</head>

<body>
  <!-- Home Navbar -->
  <nav class="navbar navbar-toggleable-sm navbar-light bg-faded rounded mt-3 mx-5 fixed-top">
    <button class="navbar-toggler navbar-toggler-right mt-3" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{route('welcome')}}"><img alt="logo" src="{{ asset('img/logo.png') }}" />Human Migration Web Reporter</a>
    <a class="navbar-brand navbar-brand-short" href="../HomePage/home.html"><img alt="logo" src="{{ asset('img/logo.png') }}" />HuWr</a>
    <div class="collapse navbar-collapse justify-content-md-end" id="navbarNav">
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item">
          <a class="nav-link" href="{{route('login')}}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('register')}}">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('feed')}}">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('api')}}">Rest API</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('about')}}">About us</a>
        </li>
      </ul>
    </div>
  </nav>

  @yield('content')

  <!-- jQuery first, then Tether, then Bootstrap JS. -->
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
    crossorigin="anonymous"></script>
</body>

</html>
