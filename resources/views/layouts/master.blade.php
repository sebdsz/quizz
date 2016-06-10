<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quizz')</title>
    <meta name=viewport content="width=device-width,initial-scale=1">
    <meta name="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="main">
    @if(Auth::check() && Auth::user()->isAdmin())
        <header>@include('partials.nav')</header>
    @endif
    <div class="content">
        @yield('content')
    </div>
</div>
<footer></footer>
<script src="http://code.jquery.com/jquery-2.2.2.min.js"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>
</html>