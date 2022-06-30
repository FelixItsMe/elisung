<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

        <style>
            .table-bordered {
                border-color: rgb(45, 44, 44) !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="container-scroller">
            @include('layouts.navbar')


            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_navbar.html -->
                @include('layouts.sidebar')
                <!-- partial -->

                <div class="main-panel">
                    <div class="content-wrapper">
                        {{ $header }}

                        {{ $slot }}
                    </div>
                    @include('layouts.footer')
                </div>

            </div>
        </div>

        @include('layouts.script')
        @stack('scripts')
    </body>
</html>
