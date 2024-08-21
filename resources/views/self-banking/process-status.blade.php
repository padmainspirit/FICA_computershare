@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.selfbankingservice')
@endsection

@section('css')
<style>
    .required {
        color: "#ff0000" !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



@endsection


@section('body')

<body style="background-color: rgb(230, 230, 230)">
    @endsection

    @section('content')

    <div class="row d-flex justify-content-center mb-2 mt-4">
        <img src="{{ URL::asset("assets\images\logo\computershare.png") }}" style="max-width: 200px; max-height: 200px;" alt="" class="img-fluid">
    </div>

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="container">
                        <div class="row justify-content-between align-items-center">
    <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">

    </div>
    <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">


    </div>
    <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">

    </div>
    <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">

    </div>
    <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">
        <img src="{{ URL::asset('/assets/images/location-pin.png') }}" style="height:45px;width:45px;">
    </div>
</div>
</div>
<div class="progress mx-auto mb-4 mt-3" style="height: 20px; width:85%;">
                                    <div class="progress-bar" role="progressbar" style="width: 100%;background-color: #91C60F;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="container">
                                        <div class="row justify-content-between align-items-center">
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center mb-3">
                                            <img id="openCam" src="{{ URL::asset('/assets/images/octicon--info-16.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Welcome</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center mb-3">
                                            <img id="openCam2" src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Personal Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Digital ID Verification</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Banking Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/mdi--tick-circle-outline.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Finish</h5>
                                          </div>
                                        </div>
                                      </div>
                    <div class="card overflow-hidden" style="border-radius: 10px;">

                        <div style="background-image: linear-gradient(#93186c, #93186c);" class="text-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h4 class="text-white">Self Service Banking Process</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">

                            <div class="p-2">






                                <div class="form-group row" style="border: 1px solid black;width: 70%;padding: 25px 50px;margin: 50px 125px;text-align:center;font-size:20px;">

                                    @if ($Success)
                                        <div class="alert alert-success">
                                        <p>Thank you<p>
                                        {{$Success }}
                                        </div>
                                    @endif
                                <div>

                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                <div class="mt-5">


                                    <button onclick="window.location='{{ url("/") }}'" type="submit"
                                    class="btn w-md text-white"
                                    style="align:center;background-color: #91C60F; border-color: #91C60F;">Finish
                                </button>


                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->
    @endsection

