@extends('layouts.master-getstarted')

@section('title')
    @lang('translation.Timeline')
@endsection

@section('css')
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.css') }}">

    <style>
        #card {
            border-top-color: #1a4f6e;
            border-bottom-color: #1a4f6e;
            border-left-color: #1a4f6e;
            border-right-color: #1a4f6e;
        }
    </style>
@endsection

@section('content')
    {{-- @component('components.breadcrumb')
        @slot('li_1')
            dashboard
        @endslot
        @slot('title')
            get started
        @endslot
    @endcomponent --}}

    <style>
        body {
            background-color: rgb(240, 240, 240);
        }

        .heading-fica-id {
            height: 49px;
            background-image: linear-gradient(#0e425b, #056895);
        }
    </style>
    
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card overflow-hidden">
                <div style="background-image: linear-gradient(#0e425b, #1a4f6e);">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-white p-4">
                                <h5 class="text-white">Getting Started</h5>
                                <p>To complete your FICA process, please follow the steps below:</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="card"
                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px;margin-bottom: 0px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                style="background-color: #1a4f6e; background-image: linear-gradient(315deg, #1a4f6e 0%, #1a4f6e 74%);">
                                <i class="mdi mdi-account-box-multiple-outline font-size-24" style="color: rgb(255, 255, 255);"></i>
                            </span>
                        </div>
                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Step 1: Upload Documents</h3>
                    </div>
                    <div class="text-muted mt-4">
                        <h5 class="text-black" style="text-align:left;">A copy of your Identification Document, Proof of Banking and Residence is required.</h5>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="card"
                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px;margin-bottom: 0px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                style="background-color: #1a4f6e; background-image: linear-gradient(315deg, #1a4f6e 0%, #1a4f6e 74%);">
                                <i class="mdi mdi-account-circle-outline font-size-24" style="color: rgb(255, 255, 255);"></i>
                            </span>
                        </div>
                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Step 2: Facial Recognition</h3>
                    </div>
                    <div class="text-muted mt-4">
                        <h5 class="text-black" style="text-align:left;">Take a quick selfie to verify it is you.</h5>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="card"
                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px;margin-bottom: 0px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                style="background-color: #1a4f6e; background-image: linear-gradient(315deg, #1a4f6e 0%, #1a4f6e 74%);">
                                <i class="mdi mdi-content-save-edit-outline font-size-24" style="color: rgb(255, 255, 255);"></i>
                            </span>
                        </div>
                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Step 3: Review Details</h3>
                    </div>
                    <div class="text-muted mt-4">
                        <h5 class="text-black" style="text-align:left;">Review all your information to ensure that it is correct.</h5>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="card"
                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px;margin-bottom: 0px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                style="background-color: #1a4f6e; background-image: linear-gradient(315deg, #1a4f6e 0%, #1a4f6e 74%);">
                                <i class="mdi mdi-file-star-outline font-size-24" style="color: rgb(255, 255, 255);"></i>
                            </span>
                        </div>
                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Step 4: Validation Confirmation
                        </h3>
                    </div>
                    <div class="text-muted mt-4">
                        <h5 class="text-black" style="text-align:left;">Validate all of your details with the documents you
                            provided for authentication.</h5>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="card"
                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px;margin-bottom: 0px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-2">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                style="background-color: #1a4f6e; background-image: linear-gradient(315deg, #1a4f6e 0%, #1a4f6e 74%);">
                                <i class="mdi mdi-check-decagram font-size-24" style="color: rgb(255, 255, 255);"></i>
                            </span>
                        </div>
                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Step 5: Acknowledgement</h3>
                    </div>
                    <div class="text-muted mt-4">
                        <h5 class="text-black" style="text-align:left;">Agreeing to all Terms and Conditions
                            stated in the agreement.</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end account-pages -->

    <form method="POST" action="{{ route('start-fica') }}" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center mt-3">
            <button type="submit" class="btn text-center w-md text-white"
                style="width: 20%; background-color: #1a4f6e; border-color: #1a4f6e">
                Get Started
            </button>
        </div>
    </form>
@endsection

@section('script')
@endsection
