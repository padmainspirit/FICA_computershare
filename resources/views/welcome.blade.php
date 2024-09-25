<?php

use Illuminate\Support\Facades\Session;
?>
@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Starter_Page')
@endsection

@section('content')
    <?= Session::flush(); ?>
    <br><br><br><br><br><br><br><br><br>
    <div class="row d-flex justify-content-center mb-3 mt-5">
        <img src="{{ URL::asset('/assets/images/logo/computershare.png') }}" style="width: 300px;" alt="" class="img-fluid">
    </div>
    <div class="text-center">
        <h3>Click the Link to login to <b><a href="{{ route('login', ['customer' => 'Computershare']) }}">FICA SA</a></b>
        </h3>
    </div>
@endsection
