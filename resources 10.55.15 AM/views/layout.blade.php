<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $strHeadTitle }}</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <script src="{{ asset('js/bower_components/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    @extends('goals/navbar')
    @yield('content')
</body>
</html>
