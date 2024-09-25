<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | FICA - V1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="icon" href="{{ URL::asset('assets/images/logo.ico') }}">
    @include('layouts.head-css')
</head>

<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js') }}"></script>

@yield('body')



@yield('content')


    <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>

    @yield('script')



</body>

</html>