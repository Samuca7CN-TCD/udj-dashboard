<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="token" content="{{ session()->get('token') }}">
    @endauth

        <title name="title">{{ $title }}</title>

        <link rel="shortcut icon" type="imagex/png" href="{{ asset('storage/logo/icone.png') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/materialize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    </head>
    <body>
        <div>
        @auth
            <x-header/>
        @endauth

        @auth
            <x-navbar />
        @endauth

            <!-- Page Content -->
            <main class="container">
                {{ $slot }}
            </main>

        @auth
            <x-footer />
        @endauth
            <!-- Scripts -->
            <script src="{{ asset('js/app.js') }}"></script>
            <script src="{{ asset('js/jquery.js') }}"></script>
            <script src="{{ asset('js/materialize.js') }}"></script>
            <script src="{{ asset('js/chart.js') }}"></script>
            <script src="{{ asset('js/funcoes.js') }}"></script>
        @hasSection('javascript')
            @yield('javascript')
        @endif
        </div>
    </body>
</html>