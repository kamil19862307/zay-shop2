<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', env('APP_NAME'))
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>
<body>


@include('shared.flash')

@include('shared.header')


@yield('content')


@include('shared.footer')


</body>
</html>
