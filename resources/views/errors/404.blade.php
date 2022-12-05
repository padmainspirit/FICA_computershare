<?php

use App\Models\CustomerUser;
use App\Models\Consumer;

?>

@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Error_404')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <?php
        $url = '/';
        if (Auth::user()) {
            $getRoleName = CustomerUser::getCustomerUserRoleName();
            if ($getRoleName == 'SuperAdmin') {
                $url = '/admin-display';
            } elseif ($getRoleName == 'CustomerAdmin') {
                $url = '/admin-dashboard';
            } else {
                $consumer = Consumer::where('Email', '=', Auth::user()->Email)
                    ->where('CustomerUSERID', '=', Auth::user()->Id)
                    ->first();
                $url = $consumer != null ? '/fica' : '/startfica';
            }
        }
        ?>


        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h1 class="display-2 fw-medium">4<i class="bx bx-buoy bx-spin text-primary display-3"></i>4</h1>
                            <h4 class="text-uppercase">Sorry, page not found</h4>
                            <div class="mt-5 text-center">
                                <a class="btn btn-primary waves-effect waves-light" href="{{ $url }}">Back to
                                    Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-6">
                        <div>
                            <img src="{{ URL::asset('/assets/images/error-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
