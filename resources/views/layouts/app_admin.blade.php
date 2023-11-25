<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.admin_name', 'Admin Project Crystal') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/crystal_logo.ico') }}">

    <!-- Scripts -->
    @vite(['vuejs/admin-app/app.js', 'resources/sass/app.scss', 'resources/sass/custom.scss'])
</head>

<body>
    <div id="app">
        <main>
            <router-view></router-view>
            <!-- @yield('content') -->
        </main>
    </div>
</body>

</html>