<?php

use Illuminate\Support\Facades\Session;

?>


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

<div class="justify-content-center">
    <div class="progress">
        <?php $progress_sb = Session::get('sb_progress'); ?>
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $progress_sb }}" aria-valuemin="0" aria-valuemax="100" style="width:<?= $progress_sb . '%'; ?> "></div>
    </div>
<div>

        @yield('content')

        @include('layouts.vendor-scripts')

        @guest
        @if(session()->has('sbid'))
        @include('layouts.session-script')
        @endif
        @endguest

        </body>

</html>