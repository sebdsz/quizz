<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Quizz - Admin')</title>
      <meta name="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/js/jquery-confirm2/css/jquery-confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300' rel='stylesheet' type='text/css'>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <script>var base_url = "{{ URL::to('/') }}" </script>
</head>
<body>
@if(Auth::check() && Auth::user()->isAdmin())
    <header>@include('partials.nav')</header>
@endif
<div class="main">
    <div class="content">
        @yield('content')
    </div>
</div>
<footer></footer>
<script src="http://code.jquery.com/jquery-2.2.2.min.js"></script>
<script src="{{ asset('assets/js/jquery-confirm2/js/jquery-confirm.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>
</html>