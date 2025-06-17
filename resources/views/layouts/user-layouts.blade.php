<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', '3-REBU')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html {
                scroll-behavior: smooth;
            }
        </style>
    </head>

    <body>

        <head>
            @include('components.user.navbar')
        </head>
        <div>
            @yield('content')
        </div>
        {{-- <script src="https://unpkg.com/scrollreveal"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ScrollReveal().reveal('.flex-col, .rounded-lg, .text-center, .font-bold, .p-4', {
                    distance: '40px',
                    duration: 900,
                    easing: 'ease-in-out',
                    origin: 'bottom',
                    interval: 10,
                    reset: false
                });
            });
        </script> --}}
    </body>

</html>
