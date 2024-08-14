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
                <div class="text-center mt-3 d-flex justify-content-between align-items-center">
    <div class="step text-center">
       
    </div>
    <div class="step text-center">
   
       
    </div>
    <div class="step text-center">
    
    </div>
    <div class="step text-center">
    <img src="{{ URL::asset('/assets/images/location-pin.png') }}" style="height:45px;width:45px;">
    </div>
    <div class="step text-center">
       
    </div>
</div>
                <div class="progress mb-4 mt-3" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" style="width: 100%;background-color: green;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="text-center mb-4 mt-2 d-flex justify-content-between align-items-center">
                                    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/octicon--info-16.svg') }}" style="height:45px;width:45px;">
        <h5>Welcome</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px;">
        <h5>Personal Details</h5>
    </div>
   
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px;">
        <h5>Digital ID Verification</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px;">
        <h5>Banking Details</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/mdi--tick-circle-outline.png') }}" style="width:45px;">
        <h5>Finish</h5>
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



                                    <button type="button" class="btn w-md text-white" onclick="window.location='{{ url("/") }}'" style="float: right;background-color: #93186c; border-color: #93186c;">Finish</button>

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

    