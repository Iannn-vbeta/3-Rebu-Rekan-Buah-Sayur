<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', '3-Rebu')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <x-admin.navbar>
            @slot('isi')
                @yield('content')
            @endslot
        </x-admin.navbar>

    </body>

</html>
