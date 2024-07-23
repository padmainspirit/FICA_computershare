<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | FICA - V1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="icon" href="{{ URL::asset('assets/images/logo/.png') }}">
    @include('layouts.head-css')
</head>

@yield('body')




@yield('content')

@include('layouts.vendor-scripts')

@guest
@if(session()->has('sbid'))
@include('layouts.session-script')
@endif
@endguest

</body>

</html>