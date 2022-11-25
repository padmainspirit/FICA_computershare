@extends('layouts.master')

@section('css')
    <style>
        /* Firefox */
        html {
            scrollbar-color: #93186c white;
            scrollbar-width: 10px;
        }

        /* WebKit and Chromiums */
        ::-webkit-scrollbar {
            width: 10px;
            height: 4px;
            background-color: white;
        }

        ::-webkit-scrollbar-thumb {
            background: #93186c;
            border-radius: 5px;
        }

        body {
            background-color: rgb(220, 220, 220);
        }

        input:hover {
            border: 2px solid #93186c;
            /* border: 2px solid #93186c; */
        }

        select:hover {
            border: 2px solid #93186c;
            /* border: 2px solid #93186c; */
        }

        #btn-hidden-address-modal-failed,
        #btn-hidden-id,
        #btn-hidden-failed,
        #btn-hidden-address,
        #btn-hidden-address-modal,
        #btn-hidden-bank,
        #btn-hidden-bank-failed,
        #btn-hidden-bank-modal,
        #btn-hidden-selfie,
        #seflie-text,
        #postalId,
        #submitBtn,
        #alertSuccess,
        #alertError,
        #btn-Okay,
        #submit-id,
        #submit-address,
        #submit-bank,
        #loading-briefcase,
        #loading-moneybag-address,
        #loading-briefcase-address,
        #loading-send-sms,
        #personal-save-btn,
        #foreign-tax-number,
        #validation-loading {
            display: none;
        }

        #public-offical-checkboxes,
        #public-offical-family-checkboxes,
        #varification-image-id,
        #userverification-success,
        #userverification-failed,
        #varification-image-kyc,
        #varification-image-avs,
        #varification-image-facial,
        #varification-image-compliance,
        #kyc-success,
        #kyc-failed,
        #avs-success,
        #avs-failed,
        #facial-success,
        #facial-failed,
        #compliance-success,
        #compliance-failed,
        #click-icon-static,
        #click-icon-static-address,
        #click-icon-static-bank,
        #click-icon-static-facial {
            display: none;
        }

        .close {
            display: none;
        }

        #loader,
        #loader-address,
        #loader-bank,
        #loader-selfie,
        #loader-address-model {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
            visibility: hidden;
            z-index: 10;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .center-input {
            margin: auto;
            text-align: center;
        }


        .image-upload input {
            display: none;
        }

        .image-upload img {
            width: 100px;
            cursor: pointer;
            margin: auto;
            text-align: center;
            border:
        }

        .image-upload {
            border: #411a6e dashed 1px;
            width: 65%;
            height: 240px;
            margin: auto;
            text-align: center;
            background-color: #fff;
            /* background-color: #f0f4fc; */
        }

        .personal-details {
            margin-left: 2%;
            margin-right: auto;
            margin-bottom: 5%;
            background-color: rgb(255, 255, 255);
            height: 500px;
            overflow-x: hidden;
        }

        .personal-financial {
            margin-left: 2%;
            margin-right: auto;
            margin-bottom: 5%;
            background-color: rgb(255, 255, 255);
            height: 400px;
            overflow-x: hidden;
        }

        #term-and-condition {
            padding-left: 6%;
            padding-right: 6%;
            margin-bottom: 2%;
            background-color: rgb(255, 255, 255);
            height: 410px;
            overflow: auto;
            text-align: justify;
            overflow-x: hidden;
        }

        .step-title {
            color: #93186c;
            padding-top: 10px;
            height: 50px;
            margin-top: 20px;
            text-align: center;
            margin-top: 0px;
            font-size: 18px;
        }

        .line-header {
            color: #93186c;
            border-top-style: solid;
            border-top-width: 2.5px;
            border-bottom-width: 2.5px;
            border: 1px solid #93186c;
            background-color: #93186c;
            margin-top: 0;
            opacity: 100%;
        }

        .financial-inform {
            padding-left: 10%;
        }

        .big-checkbox {
            width: 30px;
            height: 30px;
        }

        #form-btn {
            position: absolute;
            right: 5%;
        }

        #upload-icon {
            cursor: pointer;
        }

        .border-line {
            border-style: solid;
            border-width: thin;
            padding: 20px;
            padding-left: 20px;
            margin-right: 50px;
            border-color: #1a4f6e;
            background-color: #f0f4fc;
        }

        .border-line-validate {
            border-style: solid;
            border-width: medium;
            padding-left: 10px;
            padding-bottom: 10px;
            margin-right: 50px;
            border-color: #1a4f6e;
            /* background-color: #f0f4fc; */
        }

        .card-main {
            height: 70%;
            width: 100%;
            padding-left: 3%;
            padding-right: 3%
        }

        .heading-fica-id {
            /* height: 49px; */
            font-size: 18px;
            background-image: linear-gradient(#93186c, #93186c);
        }

        .section-style {
            color: #000;
        }

        #rcorners2 {
            margin-left: 5%;
            border-radius: 30px;
            border: 5px solid #93186c;
            padding: 20px;
            width: 1500px;
            height: auto;
        }

        /* #006400 - green */
    </style>
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('title')
            Fica Progress
        @endslot
    @endcomponent

    <body style="background-color: rgb(240, 240, 240);">
        <div class="card-main" id="mainpage" style="display: none">
            <div class="card">
                <div class="card-body">
                    <div id="vertical-example" class="vertical-wizard">
                        <h3>Identity Document
                            @if ($fica->ID_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 1: Upload Identity Document
                                    </h4>
                                </div>
                            </div>
                            <p style="display:none" id="progressStep">{{ Session::get('stepState') }}</p>
                            @if ($fica->ID_Status == null)
                                <br><br>
                                <div class="text-center">
                                    <div id="loading-briefcase" class="text-center">
                                        <img src="{{ URL::asset('/assets/images/briefcase.gif') }}" alt="cloud upload"
                                            width="100px" />
                                    </div>
                                    <br><br>
                                    <div id="loading-wait-identity" style="display: none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span>
                                                    <h4 class="aligncenter" style="color: #696969">Please wait while your
                                                        document is being processed
                                                    </h4>
                                                </span>
                                                <img src="{{ URL::asset('/assets/images/loading.gif') }}" alt="cloud upload"
                                                    width="50px" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="center-input">
                                    <form action="{{ route('fica') }}" method="post" enctype="multipart/form-data"
                                        style="font-size: 12px;" id="fileUpload">
                                        @csrf
                                        <div id="image-upload-identity">
                                            <p
                                                style="font-size: 18px; padding-bottom:20px; color:#696969; font-weight: bold; ">
                                                Upload your Identity document by simply clicking the icon below.
                                            </p>
                                            <p style="font-size: 18px; padding-bottom:20px; color:#696969; "> Once uploaded,
                                                please click<span> <b>Submit.</b></span>
                                            </p>
                                            <div class="image-upload">

                                                <div class="board-uplaod">
                                                    <label for="file-input">
                                                        <br>
                                                        <img id="click-icon"
                                                            src="{{ URL::asset('/assets/images/click.gif') }}"
                                                            alt="cloud upload" width="150px" />
                                                        <img id="click-icon-static"
                                                            src="{{ URL::asset('/assets/images/click.png') }}"
                                                            alt="cloud upload" width="150px" />
                                                    </label>
                                                    <input id="file-input" name="file" type="file" /><br>
                                                    <label class="w-25 text-truncate" id="file-name"></label>
                                                </div>
                                                <input type="type" id="stage" name="stage" value="id">
                                                <br>
                                                <div class="col-md-12">
                                                    <button type="submit" name="submit" id="submit-id"
                                                        class="btn btn-primary" value="Upload"
                                                        style="width: 100px; padding:.28rem; height:fit-content; background-color: #93186c; border-color: #93186c">Submit
                                                    </button>
                                                    <button type="button" class="btn btn-primary" id="btn-hidden-id"
                                                        data-bs-toggle="modal" data-bs-target="#composemodal-id">
                                                        Show PopUp
                                                    </button>
                                                    <button type="button" class="btn btn-primary" id="btn-hidden-failed"
                                                        data-bs-toggle="modal" data-bs-target="#composemodal-failed">
                                                        Show PopUp
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">

                                    <p style="color: #696969 ; background-color: #ffffff;font-size: 24px">Step Completed</p>
                                    {{-- <br><br><br><br> --}}

                                </div>
                            @endif

                        </section>

                        <!-- Company Document -->
                        <h3>Proof Of Address
                            @if ($fica->KYC_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif

                        </h3>
                        <section>
                            <div class="heading-fica-id rounded">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 2: Upload Proof of Address
                                    </h4>
                                </div>
                            </div>
                            @if ($fica->KYC_Status == null)
                                <br><br>

                                <div class="text-center">
                                    <div id="loading-briefcase-address">
                                        <img src="{{ URL::asset('/assets/images/location.gif') }}" alt="cloud upload"
                                            width="100px" />
                                    </div>
                                    <div id="loading-wait-address" style="display: none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span>
                                                    <h4 class="aligncenter" style="color: #696969">Please wait while your
                                                        document is being processed
                                                    </h4>
                                                </span>
                                                <img src="{{ URL::asset('/assets/images/loading.gif') }}"
                                                    alt="cloud upload" width="50px" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="image-upload-bank">
                                    <div class="center-input">
                                        <p style="font-size: 18px; padding-bottom:20px; color:#696969;">Upload
                                            your Proof of Address document by simply clicking the icon below.
                                        </p>
                                        <p style="font-size: 18px; padding-bottom:20px; color:#696969;"> Once uploaded,
                                            please
                                            click<span> <b>Submit.</b></span></p>
                                        <form action="{{ route('fica') }}" method="post" enctype="multipart/form-data"
                                            id="fileUpload-address">
                                            @csrf
                                            <div class="image-upload">
                                                <div class="board-uplaod">
                                                    <label for="file-input-address">
                                                        <br>
                                                        <img id="click-icon-address"
                                                            src="{{ URL::asset('/assets/images/click.gif') }}"
                                                            alt="cloud upload" width="150px" />
                                                        <img id="click-icon-static-address"
                                                            src="{{ URL::asset('/assets/images/click.png') }}"
                                                            alt="cloud upload" width="150px" />
                                                    </label>
                                                    <input id="file-input-address" name="file" type="file" /><br>
                                                    <label class="w-25 text-truncate" id="file-name-address"></label>
                                                </div>
                                                <input type="type" id="stage" name="stage" value="address">
                                                <div class="col-md-12">
                                                    <button type="submit" name="submit" id="submit-address"
                                                        class="btn btn-primary" value="Upload"
                                                        style="width: 100px; padding:.28rem; height:fit-content; background-color: #93186c; border-color: #93186c">Submit
                                                    </button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btn-hidden-address" data-bs-toggle="modal"
                                                        data-bs-target="#composemodal-address">
                                                        Show PopUp
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">

                                    <p style="color: #696969 ; background-color: #ffffff;font-size: 24px">Step Completed
                                    </p>

                                    {{-- <br><br><br><br>
                                    <div class="card border w-75 mx-auto"
                                        style="color: #000 ; background-color: #f0f4fc;">
                                        <br>
                                        <div class="card-header bg-transparent border-success">
                                            <h5 class="my-0 text-success2" style="font-size: 18px"></i>Step
                                                Completed
                                            </h5>

                                            <br>
                                        </div>
                                        <div class="card-body"
                                            style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 20px;">
                                            <div class="text-center">
                                                <img src="{{ URL::asset('/assets/images/checked2.png') }}" alt="cloud upload"
                                                    width="25%">
                                            </div>
                                        </div>
                                        <br>
                                    </div> --}}
                                </div>
                            @endif
                        </section>

                        <!-- Bank Details -->
                        <h3>Proof Of Bank Details
                            @if ($fica->AVS_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 3: Upload Proof Of Bank Details
                                    </h4>
                                </div>
                            </div>

                            @if ($fica->AVS_Status == null)
                                <br><br>
                                <div class="center-input">
                                    <div id="loading-moneybag-address">
                                        <img src="{{ URL::asset('/assets/images/money-bag.gif') }}" alt="cloud upload"
                                            width="120px" />
                                    </div>
                                    <div id="loading-wait-bank" style="display: none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span>
                                                    <h4 class="aligncenter" style="color: #696969">Please wait while your
                                                        document is being processed
                                                    </h4>
                                                </span>
                                                <img src="{{ URL::asset('/assets/images/loading.gif') }}"
                                                    alt="cloud upload" width="50px" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="image-upload-bank">
                                    <div class="center-input">
                                        <p style="font-size: 18px; padding-bottom:20px; color:#696969;">Upload
                                            your Proof of Bank document by simply clicking the icon below.
                                        </p>
                                        <p style="font-size: 18px; padding-bottom:20px; color:#696969; ">Once uploaded,
                                            please
                                            click<span> <b>Submit.</b></span></p>
                                        <div id="loader-bank" class="center"></div>
                                        <form action="{{ route('fica') }}" method="post" enctype="multipart/form-data"
                                            id="fileUpload-bank">
                                            @csrf
                                            <div class="image-upload">
                                                <div class="board-uplaod">
                                                    <label for="file-input-bank">
                                                        <br><br>
                                                        <img id="click-icon-bank"
                                                            src="{{ URL::asset('/assets/images/click.gif') }}"
                                                            alt="cloud upload" width="150px" />
                                                        <img id="click-icon-static-bank"
                                                            src="{{ URL::asset('/assets/images/click.png') }}"
                                                            alt="cloud upload" width="150px" />
                                                    </label>
                                                    <input id="file-input-bank" name="file" type="file" /><br>
                                                    <label class="w-25 text-truncate" id="file-name-bank"></label>
                                                </div>
                                                <input type="type" id="stage" name="stage" value="bank">
                                                <div class="col-md-12">
                                                    <button type="submit" name="submit" id="submit-bank"
                                                        class="btn btn-primary" value="Upload"
                                                        style="width: 100px; padding:.28rem; height:fit-content; background-color: #93186c; border-color: #93186c">Submit
                                                    </button>
                                                    <button type="button" class="btn btn-primary" id="btn-hidden-bank"
                                                        data-bs-toggle="modal" data-bs-target="#composemodal-bank">
                                                        Show PopUp
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">

                                    <p style="color: #696969 ; background-color: #ffffff;font-size: 24px">Step Completed
                                    </p>

                                    {{-- <br><br><br><br>
                                    <div class="card border w-75 mx-auto"
                                        style="color: #000 ; background-color: #f0f4fc;">
                                        <br>
                                        <div class="card-header bg-transparent border-success">
                                            <h5 class="my-0 text-success2" style="font-size: 18px"></i>Step
                                                Completed
                                            </h5>

                                            <br>
                                        </div>
                                        <div class="card-body"
                                            style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 20px;">
                                            <div class="text-center">
                                                <img src="{{ URL::asset('/assets/images/checked2.png') }}" alt="cloud upload"
                                                    width="25%">
                                            </div>
                                        </div>
                                        <br>
                                    </div> --}}
                                </div>
                            @endif
                        </section>

                        <!-- Facial Recognition -->
                        <h3>Facial Recognition
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->DOVS_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 4: Facial Verification
                                    </h4>
                                </div>
                            </div>
                            <div class="center-input">
                                @if ($fica->DOVS_Status == null)
                                    <div id="loading-send-sms">
                                        <img src="{{ URL::asset('/assets/images/message.gif') }}" alt="cloud upload"
                                            width="100px" />
                                    </div>
                                    <br><br>
                                    <p style="font-size: 18px; padding-bottom:20px; color:#696969; ">Send a seflie link
                                        to you phone by simply clicking the <span><b>Selfie Link</b></span> button below.
                                    </p>
                                    <br>

                                    <form action="{{ route('selfie') }}" method="post" enctype="multipart/form-data"
                                        id="selfieLink">
                                        @csrf
                                        <div class="image-upload">

                                            <div class="col-md-12">
                                                <br><br>
                                                <button type="submit" name="submit" id="submit-facial"
                                                    class="btn btn-primary"
                                                    style="width: 100px; padding:.28rem; height:fit-content; background-color: #93186c; border-color: #93186c">Selfie
                                                    Link
                                                </button>

                                                <button type="button" class="btn btn-primary" id="btn-hidden-selfie"
                                                    data-bs-toggle="modal" data-bs-target="#composemodal-selfie">
                                                    Show PopUp
                                                </button>

                                            </div>
                                            <img id="click-icon-facial"
                                                src="{{ URL::asset('/assets/images/click.gif') }}" alt="cloud upload"
                                                width="150px" />
                                            <img id="click-icon-static-facial"
                                                src="{{ URL::asset('/assets/images/click.png') }}" alt="cloud upload"
                                                width="150px" />
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center">

                                        <p style="color: #696969 ; background-color: #ffffff;font-size: 24px">Step
                                            Completed</p>

                                        {{-- <br><br><br><br>
                                        <div class="card border w-75 mx-auto"
                                            style="color: #000 ; background-color: #f0f4fc;">
                                            <br>
                                            <div class="card-header bg-transparent border-success">
                                                <h5 class="my-0 text-success2" style="font-size: 18px"></i>Step
                                                    Completed
                                                </h5>

                                                <br>
                                            </div>
                                            <div class="card-body"
                                                style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 20px;">
                                                <div class="text-center">
                                                    <img src="{{ URL::asset('/assets/images/checked2.png') }}"
                                                        alt="cloud upload" width="25%">
                                                </div>
                                            </div>
                                            <br>
                                        </div> --}}
                                    </div>
                                @endif

                        </section>

                        <h3>Personal Details
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->Personal_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif

                        </h3>
                        <section>
                            <div class="heading-fica-id rounded mb-3">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 5: Personal Details
                                    </h4>
                                </div>
                            </div>

                            <form action="{{ route('personal-user-detail') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="personal-details">

                                    <div class="col-lg-12">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);  ">Surname:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text"
                                                        class="form-control input-sm" readonly
                                                        style="height:27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                        id="surname-input" name="surname-input"
                                                        placeholder="Enter Surname" value="{{ $consumer->Surname }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0); padding-left:3%">Name:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">

                                                        <input autocomplete="off" type="text" class="form-control"
                                                            style="height:27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="name-input" name="name-input" placeholder="Enter Name"
                                                            readonly value="{{ $consumer->FirstName }}" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0); ">ID
                                                        Number:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text"
                                                        class="form-control input-sm"
                                                        style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                        id="idnumber-input" name="idnumber-input" readonly
                                                        placeholder="Enter ID Number" value="{{ $consumer->IDNUMBER }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0); ">Date
                                                        of
                                                        Birth:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">

                                                        <input autocomplete="off" type="date" class="form-control"
                                                            style="height: 27px;padding-left: 10%;padding-bottom: 2px;padding-top: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="dob-input" name="dob-input" value="{{ $DOB }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">
                                                        Title:
                                                    </label>

                                                    <span style="color: red; font-size: 20px;" class="required">
                                                        *
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">

                                                    <div class="input-group" style="height: 27px; width: 200px;">
                                                        <select class="form-select @error('titleId') is-invalid @enderror"
                                                            autocomplete="off"
                                                            style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="titleId" name="titleId"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}>
                                                            <option selected disabled> Select </option>

                                                            <option value="3"
                                                                {{ old('titleId') == 3 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '3' ? 'selected' : '' }}>
                                                                Mr
                                                            </option>
                                                            <option value="4"
                                                                {{ old('titleId') == 4 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '4' ? 'selected' : '' }}>
                                                                Mrs
                                                            </option>
                                                            <option value="5"
                                                                {{ old('titleId') == 5 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '5' ? 'selected' : '' }}>
                                                                Ms
                                                            </option>
                                                            <option value="6"
                                                                {{ old('titleId') == 6 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '6' ? 'selected' : '' }}>
                                                                Miss
                                                            </option>
                                                            <option value="8"
                                                                {{ old('titleId') == 8 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '8' ? 'selected' : '' }}>
                                                                Dr
                                                            </option>
                                                            <option value="7"
                                                                {{ old('titleId') == 7 ? 'selected' : '' }}
                                                                {{ isset($consumer->TitleCode) && $consumer->TitleCode == '7' ? 'selected' : '' }}>
                                                                Professor
                                                            </option>
                                                        </select>

                                                    </div>
                                                    @error('titleId')
                                                        <div class="mb-3" style="color: red">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Country:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">

                                                        <div class="input-group" style="height: 27px; width: 200px;">
                                                            <select
                                                                class="form-select @error('country-input') is-invalid @enderror"
                                                                autocomplete="off"
                                                                style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                                                id="country-input" name="country-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}>
                                                                <option value=""> Select Country </option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country }}"
                                                                        {{ $country == $consumerIdentity->ID_CountryResidence ? 'selected' : '' }}>
                                                                        {{ $country }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('country-input')
                                                            <div style="color: red">
                                                                {{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0); padding-top:4%;">ID Issue
                                                        Date:
                                                    </label>

                                                    <span style="color: red; font-size: 20px;" class="required">
                                                        *
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div>
                                                    <input autocomplete="off" type="date"
                                                        class="form-control input-sm @error('id-issuedate-input') is-invalid @enderror"
                                                        style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;padding-top: 0px;padding-bottom: 0px;"
                                                        id="id-issuedate-input" name="id-issuedate-input" 
                                                        value="{{ old('id-issuedate-input')}}"
                                                        {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                        value="{{ isset($consumerIdentity->ID_DateofIssue) ? substr(date('Y-m-d', strtotime($consumerIdentity->ID_DateofIssue)), 0, 10) : old('id-issuedate-input') }}">
                                                </div>
                                                @error('id-issuedate-input')
                                                    <div style="color: red">
                                                        {{ $message = 'Field is required' }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}

                                    <br>
                                    <br>

                                    {{-- Residential Address --}}
                                    <br>
                                    <div class="col-lg-12">

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Street
                                                            Address Line 1:
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm @error('street-address-line1') is-invalid @enderror"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="street-address-line1" name="street-address-line1"
                                                            placeholder="Enter Street Address Line 1"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Home != null ? $Home->OriginalAddress1 : '' }}">
                                                        @error('street-address-line1')
                                                            <div style="color: red">
                                                                {{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Street
                                                            Address
                                                            Line
                                                            2:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm @error('street-address-line2') is-invalid @enderror"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="street-address-line2" name="street-address-line2"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter Street Address Line 2"
                                                            value="{{ $Home != null ? $Home->OriginalAddress2 : '' }}">

                                                        @error('street-address-line2')
                                                            <div style="color: red">
                                                                {{ $message = 'Field is required' }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">City:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm @error('city-physical') is-invalid @enderror"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="city-physical" name="city-physical"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter City"
                                                            value="{{ $Home != null ? $Home->OriginalAddress3 : '' }}"
                                                            autofocus>

                                                        @error('city-physical')
                                                            <div style="color: red">{{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Residential
                                                            Province:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm @error('province-physical') is-invalid @enderror"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="province-physical" name="province-physical"
                                                            placeholder="Enter Province Physical"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Home != null ? $Home->OriginalAddress4 : '' }}">

                                                        @error('province-physical')
                                                            <div style="color: red">{{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Residential
                                                            Zip:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm @error('zip-physical') is-invalid @enderror"
                                                            style="height: 27px;  padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="zip-physical" name="zip-physical"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Home != null ? $Home->OriginalPostalCode : '' }}"
                                                            placeholder="Enter Zip">

                                                        @error('zip-physical')
                                                            <div style="color: red">{{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    {{-- Residential Address End --}}
                                    <br><br>

                                    {{-- Postal Address --}}
                                    <br>
                                    <div class="col-lg-12">

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Postal
                                                            Address Line 1:
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="postal-address-line1" name="postal-address-line1"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter Postal Address Line 1:"
                                                            value="{{ $Postal != null ? $Postal->OriginalAddress1 : '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Postal
                                                            Address Line 2:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="postal-address-line2" name="postal-address-line2"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter Postal Address Line 2:"
                                                            value="{{ $Postal != null ? $Postal->OriginalAddress2 : '' }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">City:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="city-postal" name="city-postal" placeholder="Enter City"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Postal != null ? $Postal->OriginalAddress3 : '' }}" />

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Postal
                                                            Province:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="province-postal" name="province-postal"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Postal != null ? $Postal->OriginalAddress4 : '' }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0); ">Postal
                                                            Zip:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                            id="zip-postal" name="zip-postal"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            value="{{ $Postal != null ? $Postal->OriginalPostalCode : '' }}"
                                                            placeholder="Enter Zip" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    {{-- Postal Address End --}}
                                    <br><br>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Home
                                                        Telephone:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text"
                                                        class="form-control input-sm"
                                                        style="height: 27px;  padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                        id="telephone-home-input" name="telephone-home-input"
                                                        {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                        placeholder="Enter Telephone Home"
                                                        value="{{ isset($TelHome) ? $TelHome : null }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Mobile
                                                        Telephone:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">

                                                        <input autocomplete="off" type="text" class="form-control"
                                                            style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="mobile-input" name="mobile-input" readonly
                                                            placeholder="Enter Mobile"
                                                            value="{{ $customerUser->PhoneNumber }}" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Email:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text"
                                                        class="form-control input-sm"
                                                        style="height: 27px; padding-left: 24px; width: 200px; font-size:12px; text-transform: uppercase;"
                                                        id="email-input" name="email-input" placeholder="Enter Email"
                                                        readonly value="{{ $consumer->Email }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Work:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 200px; font-size: 12px; text-transform: uppercase;"
                                                            id="work-number-input" name="work-number-input"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter Work Number"
                                                            value="{{ isset($TelWork) ? $TelWork : null }}">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Employment
                                                        Status:
                                                    </label>
                                                    <span style="color: red; font-size: 20px;" class="required">
                                                        *
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">
                                                        <select
                                                            class="form-select @error('employee-status-input') is-invalid @enderror"
                                                            autocomplete="off"
                                                            style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px;  text-transform: uppercase;"
                                                            id="employee-status-input" name="employee-status-input"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}>
                                                            <option selected disabled>Select</option>

                                                            <option value="Employed"
                                                                {{ old('employee-status-input') == 'Employed' ? 'selected' : '' }}
                                                                {{ isset($consumer->Employmentstatus) && $consumer->Employmentstatus == 'Employed' ? 'selected' : '' }}>
                                                                Employed</option>
                                                            <option value="Unemployed"
                                                                {{ old('employee-status-input') == 'Unemployed' ? 'selected' : '' }}
                                                                {{ isset($consumer->Employmentstatus) && $consumer->Employmentstatus == 'Unemployed' ? 'selected' : '' }}>
                                                                Unemployed</option>
                                                        </select>
                                                    </div>
                                                    {{-- <div style="padding-bottom: 2px"> --}}
                                                    @error('employee-status-input')
                                                        <div style="color: red">
                                                            {{ $message = 'Field is required' }}</div>
                                                    @enderror
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Name
                                                        Of Employer:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 200px;">
                                                        <input autocomplete="off" type="text" class="form-control"
                                                            style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                            id="employeer-name-input" name="employeer-name-input"
                                                            {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                            placeholder="Enter Employer Name"
                                                            value="{{ $consumer->Nameofemployer != null ? $consumer->Nameofemployer : '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- address --}}
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Industry
                                                            Of Occupation:
                                                        </label>
                                                        <span style="color: red; font-size: 20px;" class="required">
                                                            *
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">
                                                            <select
                                                                class="form-select @error('industry-of-occupation-input') is-invalid @enderror"
                                                                autocomplete="off"
                                                                style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px;  text-transform: uppercase;"
                                                                id="industry-of-occupation-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                                name="industry-of-occupation-input">

                                                                <option value=""> Select Industry Of Occupation
                                                                </option>
                                                                @foreach ($occupation as $industry)
                                                                    <option value="{{ $industry }}"
                                                                        {{ old('industry-of-occupation-input') == $industry ? 'selected' : '' }}
                                                                        {{ $industry == $selectedIndustryofoccupation ? 'selected' : '' }}>
                                                                        {{ $industry }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('industry-of-occupation-input')
                                                            <div style="color: red;">
                                                                {{ $message = 'Field is required' }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Employer
                                                            Addr Line 1:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">

                                                            <input autocomplete="off" type="text" class="form-control"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                id="employeer-street-address-line1-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                                name="employeer-street-address-line1-input"
                                                                placeholder="Enter Street Address Line 1"
                                                                value="{{ $Work != null ? $Work->OriginalAddress1 : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Employer
                                                            Addr Line 2:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">
                                                            <input autocomplete="off" type="text" class="form-control"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                id="employeer-street-address-line2-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                                name="employeer-street-address-line2-input"
                                                                placeholder="Enter Street Address Line 2"
                                                                value="{{ $Work != null ? $Work->OriginalAddress2 : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">City:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">

                                                            <input autocomplete="off" type="text" class="form-control"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                id="employeer-city-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                                name="employeer-city-input" placeholder="Enter City"
                                                                value="{{ $Work != null ? $Work->OriginalAddress3 : '' }}">



                                                            {{-- <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; font-size:12px; text-transform: uppercase;"
                                                                id="employeer-city-input" name="employeer-city-input"
                                                                placeholder="Select City"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}>
                                                                <option hidden>Select City</option>

                                                                @foreach ($citiesNames as $city)
                                                                    <option value="{{ isset($city) ? $city : null }}">
                                                                        {{ $city }}
                                                                    </option>
                                                                @endforeach

                                                                @foreach ($citiesNames as $city)
                                                                    <option value="{{ isset($city) ? $city : null }}" {{ isset($workAddress->OriginalAddress3) && $workAddress->OriginalAddress3 == $city ? 'selected' : '' }}>
                                                                        {{ $city }}
                                                                    </option>
                                                                @endforeach

                                                            </select> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Province:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">
                                                            <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                id="employeer-province-input"
                                                                name="employeer-province-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}>
                                                                <option selected
                                                                    style="text-transform: uppercase;font-size: 12px;"
                                                                    disabled>
                                                                    Select
                                                                </option>

                                                                <option value="Eastern Cape" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Eastern Cape' ? 'selected' : '' }}>
                                                                    Eastern Cape
                                                                </option>

                                                                <option value="Free State" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Free State' ? 'selected' : '' }}>
                                                                    Free State
                                                                </option>

                                                                <option value="KwaZulu-Natal" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'KwaZulu-Natal' ? 'selected' : '' }}>
                                                                    KwaZulu-Natal
                                                                </option>

                                                                <option value="Gauteng" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Gauteng' ? 'selected' : '' }}>
                                                                    Gauteng
                                                                </option>

                                                                <option value="Limpopo" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Limpopo' ? 'selected' : '' }}>
                                                                    Limpopo
                                                                </option>

                                                                <option value="Mpumalanga" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Mpumalanga' ? 'selected' : '' }}>
                                                                    Mpumalanga
                                                                </option>

                                                                <option value="North West" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'North West' ? 'selected' : '' }}>
                                                                    North West
                                                                </option>

                                                                <option value="Northern Cape" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Northern Cape' ? 'selected' : '' }}>
                                                                    Northern Cape
                                                                </option>

                                                                <option value="Western Cape" style="font-size: 12px;"
                                                                    {{ isset($Work->OriginalAddress4) && $Work->OriginalAddress4 == 'Western Cape' ? 'selected' : '' }}>
                                                                    Western Cape
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Postal
                                                            Code:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 200px;">
                                                            <input autocomplete="off" type="text"
                                                                class="form-control input-sm @error('employeer-postal-code-input') is-invalid @enderror"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                id="employeer-postal-code-input"
                                                                {{ $fica->Personal_Status !== null ? 'disabled' : '' }}
                                                                name="employeer-postal-code-input"
                                                                placeholder="Enter Postal Code"
                                                                value="{{ $Work != null ? $Work->OriginalPostalCode : '' }}">
                                                        </div>

                                                    </div>
                                                    @error('employeer-postal-code-input')
                                                        <div style="color: red;width:200px">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end address --}}
                                    </div>

                                    <br>

                                </div>

                                <div class="text-center">
                                    @if ($fica->Personal_Status !== null)
                                        <div id="personal-edit-btn">
                                            <button type="button" class="btn text-center w-md text-white"
                                                id="personal-edit-btn"
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Edit
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="personal-cancel-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    @endif
                                    <div id="personal-save-btn">
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="personal-cancel-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </section>

                        <h3>Financial Infomation
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->Financial_status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif

                        </h3>
                        <section>
                            <div class="heading-fica-id rounded">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 6: Financial Infomation
                                    </h4>
                                </div>
                            </div>

                            <form action="{{ route('financial-detail') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="personal-financial">
                                    <br><br>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-6" style="padding-left: 15%;">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Source
                                                        of Funds:
                                                    </label>
                                                    <span style="color: red; font-size: 20px;" class="required">
                                                        *
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="input-group"
                                                        style="height: 27px; width: 210px;  @error('funds-input') is-invalid @enderror">
                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="funds-input" name="funds-input" required
                                                            {{ $fica->Financial_status !== null ? 'disabled' : '' }}>
                                                            <option selected disabled> Select Source of Funds </option>
                                                            @foreach ($funds as $fund)
                                                                <option value="{{ $fund }}"
                                                                    {{ old('funds-input') == $fund ? 'selected' : '' }}
                                                                    {{ isset($selectSourceOfFunds) && $fund == $selectSourceOfFunds ? 'selected' : '' }}>
                                                                    {{ $fund }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('funds-input')
                                                        <div style="color: red">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-lg-12">
                                        <div class="row">
                                            <div class="col-md-6" style="padding-left: 15%;">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Income Tax
                                                        Number:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text"
                                                        class="form-control input-sm"
                                                        style="height: 27px; width: 10px; padding-left: 24px; width: 210px;"
                                                        id="tax-number-input" name="tax-number-input"
                                                        {{ $fica->Financial_status !== null ? 'disabled' : '' }}
                                                        placeholder="Enter Income Tax Number"
                                                        value="{{ isset($financial->Tax_Number) ? $financial->Tax_Number : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-6" style="padding-left: 15%; padding-right:5%">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0);">Do
                                                        you have any tax obligations ouside of SA?
                                                    </label>

                                                    {{-- <p style="color: #0000FF">{{$financial->Tax_Oblig_outside_SA}}</p> --}}

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 210px;">
                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                                            id="Tax_Oblig_outside_SA" name="Tax_Oblig_outside_SA"
                                                            {{ $fica->Financial_status !== null ? 'disabled' : '' }}>
                                                            <option disabled>Select an Option</option>
                                                            <option value=0
                                                                {{ isset($financial->Tax_Oblig_outside_SA) && $financial->Tax_Oblig_outside_SA == 0 ? 'selected' : '' }}>
                                                                NO
                                                            </option>
                                                            <option value=1
                                                                {{ isset($financial->Tax_Oblig_outside_SA) && $financial->Tax_Oblig_outside_SA == 1 ? 'selected' : '' }}>
                                                                YES
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="foreign-tax-number">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-6" style="padding-left: 15%;">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Foreign
                                                            Tax Number:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 210px;"
                                                            id="foreign-tax-number-input" name="foreign-tax-number-input"
                                                            value="{{ isset($financial->Foreign_Tax_Number) ? $financial->Foreign_Tax_Number : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-6"style="padding-left: 15%;">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">Country
                                                            Of Tax Code:
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 210px;"
                                                            id="country-of-tax-code-input"
                                                            name="country-of-tax-code-input" placeholder=""
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-6"style="padding-left: 15%;">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0);">No
                                                            Foreign Tax Number Reason:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <input autocomplete="off" type="text"
                                                            class="form-control input-sm"
                                                            style="height: 27px; width: 10px; padding-left: 24px; width: 210px;"
                                                            id="no-foreign-tax-number-reason-input"
                                                            name="no-foreign-tax-number-reason-input" placeholder=""
                                                            value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    @if ($fica->Financial_status !== null)
                                        <div id="edit-financial-btn" style="display: box">
                                            <button type="button" class="btn text-center w-md text-white"
                                                id="edit-financial-btn"
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Edit
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-financial-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    @endif
                                    <div id="save-and-cancel-financial-btn" style="display: none">
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-financial-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </section>

                        <h3>Screening
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->Screening_status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded mb-3">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 7: Screening
                                    </h4>
                                </div>
                            </div>

                            <form action="{{ route('screening') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="personal-details">
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-md-7 mb-2">
                                            <div class="mb-3">
                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0);">Do
                                                    you occupy a prominent official position or perform a public
                                                    function at a senior level?
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="input-group" style="height: 27px; width: 165px;">
                                                <select class="form-select" id="public-officia-dropdown"
                                                    style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                    name="public-officia-dropdown" id="public-officia-dropdown" required
                                                    {{ $fica->Screening_status !== null ? 'disabled' : '' }}>
                                                    {{-- <option value=-1>Select</option> --}}
                                                    <option disabled> Select </option>
                                                    <option value=1 id="public-officia-dropdown-YES"
                                                        {{ isset($financial->Public_official) && $financial->Public_official == 1 ? 'selected' : '' }}>
                                                        YES
                                                    </option>
                                                    <option selected value=0 id="public-officia-dropdown-NO"
                                                        {{ isset($financial->Public_official) && $financial->Public_official == 0 ? 'selected' : '' }}>
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-8 mb-5" id="public-offical-checkboxes">
                                            <div class="form-check">
                                                <input class="form-check-input big-checkbox" type="checkbox"
                                                    value="Domestic Prominent influential Persons"
                                                    id="public-offical-domestic-prominent-checkbox"
                                                    name="public-offical-domestic-prominent-checkbox"
                                                    style="width: 20px; height:20px;"
                                                    {{ isset($financial->Public_official_type_DPIP) && $financial->Public_official_type_DPIP == 'Domestic Prominent influential Persons' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="salary-checkbox"
                                                    style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                    DPPO (Domestic Prominent Influential Person)
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input big-checkbox" type="checkbox"
                                                    value="FPPO (Foreign Prominent Public Officials)"
                                                    id="public-offical-eppo-checkbox" name="public-offical-eppo-checkbox"
                                                    style="width: 20px; height:20px;"
                                                    {{ isset($financial->Public_official_type_FPPO) && $financial->Public_official_type_FPPO == 'FPPO (Foreign Prominent Public Officials)' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="salary-checkbox"
                                                    style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0); ">
                                                    FPPO (Foreign Prominent Public Official)
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 justify-content-center">
                                        <div class="col-md-7">
                                            <div class="mb-2">
                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0);">Do
                                                    you have any immediate family members/close
                                                    associates that are Domestic Prominent Influential Persons?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="input-group mb-3" style="height: 27px; width: 165px;">
                                                <select class="form-select" id="public-officia-family-dropdwon"
                                                    style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                    name="public-officia-family-dropdwon"
                                                    id="public-officia-family-dropdwon" required
                                                    {{ $fica->Screening_status !== null ? 'disabled' : '' }}>
                                                    <option disabled> Select </option>
                                                    <option value=1 id="public-officia-fimaly-dropdown-YES"
                                                        {{ isset($financial->Public_official_Family) && $financial->Public_official_Family == 1 ? 'selected' : '' }}>
                                                        YES
                                                    </option>
                                                    <option selected value=0 id="public-officia-fimaly-dropdown-NO"
                                                        {{ isset($financial->Public_official_Family) && $financial->Public_official_Family == 0 ? 'selected' : '' }}>
                                                        NO
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mb-4">
                                        <div class="col-md-8 mb-4" id="public-offical-family-checkboxes">
                                            <div class="form-check">
                                                <input class="form-check-input big-checkbox" type="checkbox"
                                                    value="Domestic Prominent influential Persons"
                                                    id="public-offical-family-domestic-prominent-checkbox"
                                                    name="public-offical-family-domestic-prominent-checkbox"
                                                    style="width: 20px; height:20px;"
                                                    {{ isset($financial->Public_official_type_family_DPIP) && $financial->Public_official_type_family_DPIP == 'Domestic Prominent influential Persons' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="salary-checkbox"
                                                    style="padding-left:15px;padding-right:15px;padding-top:5px; font-size: 12px; color: rgb(0, 0, 0);">
                                                    DPPO (Domestic Prominent Influential Person)
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input big-checkbox" type="checkbox"
                                                    value="FPPO (Foreign Prominent Public Officials)"
                                                    id="public-offical-family-eppo-checkbox"
                                                    name="public-offical-family-eppo-checkbox"
                                                    style="width: 20px; height:20px;"
                                                    {{ isset($financial->Public_official_type_family_FPPO) && $financial->Public_official_type_family_FPPO == 'FPPO (Foreign Prominent Public Officials)' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="salary-checkbox"
                                                    style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0); ">
                                                    FPPO (Foreign Prominent Public Official)
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-7 mb-2">
                                            <div class="mb-3">
                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0);">Have
                                                    you appeared on any sanctions list in relation to anti-money
                                                    laundering or counter-terrorists financing?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-3" style="height: 27px; width: 165px;">
                                                <select class="form-select" id="sanctions-list-dropdown"
                                                    style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                    name="sanctions-list-dropdown" id="sanctions-list-dropdown" required
                                                    {{ $fica->Screening_status !== null ? 'disabled' : '' }}>>
                                                    <option disabled>Select</option>
                                                    <option value=1
                                                        {{ isset($financial->SanctionList) && $financial->SanctionList == 1 ? 'selected' : '' }}>
                                                        YES</option>
                                                    <option selected value=0
                                                        {{ isset($financial->SanctionList) && $financial->SanctionList == 0 ? 'selected' : '' }}>
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-7 mb-3">
                                            <div class="mb-3">
                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0);">Have
                                                    you been associated with any
                                                    adverse or negative media published in the domain?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group mb-3" style="height: 27px; width: 165px;">
                                                <select class="form-select" id="adverse-medai-dropdown"
                                                    style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                    name="adverse-medai-dropdown" id="adverse-medai-dropdown" required
                                                    {{ $fica->Screening_status !== null ? 'disabled' : '' }}>
                                                    <option disabled>Select</option>
                                                    <option value=1
                                                        {{ isset($financial->AdverseMedia) && $financial->AdverseMedia == 1 ? 'selected' : '' }}>
                                                        YES</option>
                                                    <option selected value=0
                                                        {{ isset($financial->AdverseMedia) && $financial->AdverseMedia == 0 ? 'selected' : '' }}>
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="text-center">
                                    @if ($fica->Screening_status !== null)
                                        <div style="display: box">
                                            <button type="button" class="btn text-center w-md text-white"
                                                id="edit-screen-btn"
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Edit
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-screen-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    @endif
                                    <div id="save-and-cancel-screen-btn" style="display: none">
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-screen-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </section>

                        <h3>Declarations
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->Declaration_status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded mb-3">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 8: Declarations
                                    </h4>
                                </div>
                            </div>

                            <form action="{{ route('declarations') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="personal-details">
                                    <h6 style="color: rgb(0, 0, 0);">K. Client Due Diligence</h6>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select
                                            class="form-select @error('client-due-diligence-dropdown') is-invalid @enderror"
                                            id="client-due-diligence-dropdown" name="client-due-diligence-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>

                                            <option selected disabled>Select</option>

                                            <option value="Once off sale transaction"
                                                {{ old('client-due-diligence-dropdown') == 'Once off sale transaction' ? 'selected' : '' }}
                                                {{ isset($declaration->ClientDueDiligence) && $declaration->ClientDueDiligence == 'Once off sale transaction' ? 'selected' : '' }}>
                                                Once off sale transaction</option>
                                            <option value="Ongoing trading(R50 000 above)"
                                                {{ isset($declaration->ClientDueDiligence) && $declaration->ClientDueDiligence == 'Ongoing trading(R50 000 above)' ? 'selected' : '' }}>
                                                Ongoing trading (R50 000 above)</option>

                                            <option value="Ongoing trading (estimated value R1 to R50 000)"
                                                {{ old('client-due-diligence-dropdown') == 'Ongoing trading (estimated value R1 to R50 000)' ? 'selected' : '' }}
                                                {{ isset($declaration->ClientDueDiligence) && $declaration->ClientDueDiligence == 'Ongoing trading (estimated value R1 to R50 000)' ? 'selected' : '' }}>
                                                Ongoing trading (estimated value R1 to R50 000)</option>

                                            {{-- <option value="Other - please specify"
                                                {{ isset($declaration->ClientDueDiligence) && $declaration->ClientDueDiligence == 'Other - please specify' ? 'selected' : '' }}>
                                                Other - please specify
                                            </option> --}}

                                        </select>

                                    </div>
                                    @error('client-due-diligence-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                    <br>
                                    <h6 style="color: rgb(0, 0, 0);">C. Nominee Declaration</h6>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select {{-- class="form-select @error('nominee-declaration-dropdown') is-invalid @enderror" --}} class="form-select"
                                            id="nominee-declaration-dropdown" name="nominee-declaration-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>
                                            <option disabled>Select</option>

                                            <option selected value="NO"
                                                {{ isset($declaration->NomineeDeclaration) && $declaration->NomineeDeclaration == 'NO' ? 'selected' : '' }}>
                                                NO
                                            </option>

                                            <option
                                                value='I confirm  that I am  not acting in the capacity of nominee intending to hold securities on behalf of a beneficial owner.'
                                                {{ isset($declaration->NomineeDeclaration) &&
                                                $declaration->NomineeDeclaration ==
                                                    'I confirm  that I am  not acting in the capacity of nominee intending to hold securities on behalf of a beneficial owner.'
                                                    ? 'selected'
                                                    : '' }}>
                                                I confirm that I am not acting in the capacity of nominee intending to hold
                                                securities on behalf of a beneficial owner.
                                            </option>

                                            <option
                                                value="I/We confirm that I  am/we  are a nominee and intend to hold Securities on behalf of the beneficial owners."
                                                {{ isset($declaration->NomineeDeclaration) && $declaration->NomineeDeclaration == 'I/We confirm that I  am/we  are a nominee and intend to hold Securities on behalf of the beneficial owners.' ? 'selected' : '' }}>
                                                I/We confirm that I am/we are a nominee and intend to hold Securities on
                                                behalf of the beneficial owners.
                                            </option>
                                        </select>

                                    </div>
                                    {{-- @error('nominee-declaration-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror --}}
                                    <br>
                                    <h6 style="color: rgb(0, 0, 0);">D. Issuer Communication Selection
                                    </h6>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select
                                            class="form-select @error('issuer-communication-selection-dropdown') is-invalid @enderror"
                                            id="issuer-communication-selection-dropdown"
                                            name="issuer-communication-selection-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>
                                            <option disabled>Select</option>
                                            <option value="I wish to continue to receive an annual report"
                                                {{ isset($declaration->IssuerCommunication) && $declaration->IssuerCommunication == 'I wish to continue to receive an annual report' ? 'selected' : '' }}>
                                                I wish to continue to receive an annual report</option>
                                            <option value="I do not wish to receive a report"
                                                {{ isset($declaration->IssuerCommunication) && $declaration->IssuerCommunication == 'I do not wish to receive an report' ? 'selected' : '' }}>
                                                I do not wish to receive an report</option>
                                            <option selected value="Summary financial statement for Securities"
                                                {{ isset($declaration->IssuerCommunication) && $declaration->IssuerCommunication == 'Summary financial statement for Securities' ? 'selected' : '' }}>
                                                Summary financial statement for Securities</option>
                                            {{-- <option value="Electronic communication"
                                                {{ isset($declaration->IssuerCommunication) && $declaration->IssuerCommunication == 'Electronic communication' ? 'selected' : '' }}>
                                                Electronic communication</option> --}}
                                        </select>

                                    </div>
                                    @error('issuer-communication-selection-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror

                                    <br>

                                    <h6 style="color: rgb(0, 0, 0);">Communication Type </h6>

                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select
                                            class="form-select @error('communication-type-selection-dropdown') is-invalid @enderror"
                                            id="communication-type-selection-dropdown"
                                            name="communication-type-selection-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>

                                            <option disabled>Select</option>

                                            <option selected value="Electronic"
                                                {{ isset($declaration->CommunicationType) && $declaration->CommunicationType == 'Electronic' ? 'selected' : '' }}>
                                                Electronic
                                            </option>

                                            <option value="Postal"
                                                {{ isset($declaration->CommunicationType) && $declaration->CommunicationType == 'Postal' ? 'selected' : '' }}>
                                                Postal
                                            </option>
                                        </select>
                                    </div>
                                    @error('communication-type-selection-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror

                                    <br>
                                    <h6 style="color: rgb(0, 0, 0);">
                                        E. Custody Service Selection
                                    </h6>

                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select
                                            class="form-select @error('custody-service-selection-dropdown') is-invalid @enderror"
                                            id="custody-service-selection-dropdown"
                                            name="custody-service-selection-dropdown" onchange="status(this)"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>
                                            <option disabled>Select</option>
                                            <option selected value="Securities held on my behalf must be register"
                                                {{ isset($declaration->CustodyService) && $declaration->CustodyService == 'Securities held on my behalf must be register' ? 'selected' : '' }}>
                                                Securities must be registered in my own name and maintained by
                                                ComputerShare's Deal Routing Service.</option>
                                            <option value="Securities must be registered in my Own Name"
                                                {{ isset($declaration->CustodyService) && $declaration->CustodyService == 'Securities must be registered in my Own Name' ? 'selected' : '' }}>
                                                Securities must be registered in my own name and maintained by ComputerShare
                                                utilizing my own broker.</option>
                                        </select>

                                    </div>
                                    @error('custody-service-selection-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                    <br>

                                    <div class="col-md-12" style="padding-right: 2%; display: none;" id="brokerinfo">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 style="color: rgb(0, 0, 0);">Broker Name</h6>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="broker-name-input" name="broker-name-input"
                                                        {{ $fica->Declaration_status !== null ? 'disabled' : '' }}
                                                        placeholder="Enter Broker Name"
                                                        value="{{ $declaration->Broker != null ? $consumer->Broker : '' }}">

                                                    @error('broker-name-input')
                                                        <div style="color: red">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 style="color: rgb(0, 0, 0);">Broker Contact</h6>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        id="broker-contact-input" name="broker-contact-input"
                                                        {{ $fica->Declaration_status !== null ? 'disabled' : '' }}
                                                        placeholder="Enter Broker Contact"
                                                        value="{{ $declaration->BrokerContact != null ? $declaration->BrokerContact : '' }}">

                                                    @error('broker-contact-input')
                                                        <div style="color: red">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <h6 style="color: rgb(0, 0, 0);">F. Segregated Depository
                                        Acounts</h6>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select
                                            class="form-select @error('segregated-depository-acounts-dropdown') is-invalid @enderror"
                                            id="segregated-depository-acounts-dropdown"
                                            name="segregated-depository-acounts-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>

                                            <option selected disabled>Select</option>

                                            <option value="Confirm SDA"
                                                {{ old('segregated-depository-acounts-dropdown') == 'Confirm SDA' ? 'selected' : '' }}
                                                {{ isset($declaration->SegregatedDeposit) && $declaration->SegregatedDeposit == 'Confirm SDA' ? 'selected' : '' }}>
                                                I confirm that I would not like to open a SDA Strate.
                                            </option>

                                            <option value="Do not confirm SDA"
                                                {{ old('segregated-depository-acounts-dropdown') == 'Do not confirm SDA' ? 'selected' : '' }}
                                                {{ isset($declaration->SegregatedDeposit) && $declaration->SegregatedDeposit == 'Do not confirm SDA' ? 'selected' : '' }}>
                                                I confirm that I would like to open a SDA Strate.
                                            </option>

                                        </select>

                                    </div>
                                    @error('segregated-depository-acounts-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror

                                    <br>

                                    <h6 style="color: rgb(0, 0, 0);">H. Dividends Tax</h6>
                                    <p style="color: rgb(0, 0, 0);">Are you exempt for Dividends Tax
                                        in are subject to a reduced rate of Dividends Tax?</p>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select {{-- class="form-select @error('dividends-tax-dropdown') is-invalid @enderror" --}} class="form-select" id="dividends-tax-dropdown"
                                            name="dividends-tax-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>
                                            <option disabled>Select</option>
                                            <option value=1
                                                {{ isset($declaration->DividendTax) && $declaration->DividendTax == 1 ? 'selected' : '' }}>
                                                YES</option>
                                            <option selected value=0
                                                {{ isset($declaration->DividendTax) && $declaration->DividendTax == 0 ? 'selected' : '' }}>
                                                NO
                                            </option>
                                        </select>

                                    </div>
                                    {{-- @error('dividends-tax-dropdown')
                                    <div style="color: red">
                                        {{ $message = 'Field is required' }}
                                    </div>
                                    @enderror --}}
                                    <br>

                                    <h6 style="color: rgb(0, 0, 0);">I. BEE Shareholders</h6>
                                    <p style="color: rgb(0, 0, 0);">Do you want to purchase BEE
                                        shares?</p>
                                    <div class="col-md-12" style="padding-right: 2%;">
                                        <select {{-- class="form-select @error('bee-shareholders-dropdown') is-invalid @enderror" --}} class="form-select"
                                            id="bee-shareholders-dropdown" name="bee-shareholders-dropdown"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}>
                                            <option disabled>Select</option>
                                            <option value=1
                                                {{ isset($declaration->BeeShareholder) && $declaration->BeeShareholder == 1 ? 'selected' : '' }}>
                                                YES</option>
                                            <option selected value=0
                                                {{ isset($declaration->BeeShareholder) && $declaration->BeeShareholder == 0 ? 'selected' : '' }}>
                                                NO</option>
                                        </select>

                                    </div>
                                    @error('bee-shareholders-dropdown')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror

                                    <br>

                                    <h6 style="color: rgb(0, 0, 0);">J. Stamp Duty Reserve Tax</h6>
                                    <div class="form-check">
                                        <input {{-- class="form-check-input big-checkbox @error('stamp-duty-reserve-tax-checkbox') is-invalid @enderror" --}} class="form-check-input big-checkbox"
                                            type="checkbox" value=1 id="stamp-duty-reserve-tax-checkbox"
                                            name="stamp-duty-reserve-tax-checkbox"
                                            style="width: 20px; height:20px; color:rgb(0, 0, 0);border-color: #93186c"
                                            {{ $fica->Declaration_status !== null ? 'disabled' : '' }}
                                            {{ isset($declaration->StampDuty) && $declaration->StampDuty == 1 ? 'checked' : '' }}>

                                        <label class="form-check-label" for="salary-checkbox"
                                            style="padding-left:15px;padding-right:15px;padding-top:5px;color:#000;">
                                            I/We confirm that I/We will not hold in the Securities Account any
                                            securities which would on transfer into the Securities Account
                                        </label>
                                    </div>

                                    {{-- @error('stamp-duty-reserve-tax-checkbox')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror --}}

                                </div>

                                <div class="text-center">
                                    @if ($fica->Declaration_status !== null)
                                        <div style="display: box">
                                            <button type="button" class="btn text-center w-md text-white"
                                                id="edit-declaration-btn"
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Edit
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-declaration-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    @endif
                                    <div id="save-and-cancel-declaration-btn" style="display: none">
                                        <button type="button" class="btn text-center w-md text-white"
                                            id="cancel-declaration-btn"
                                            style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                            Previous
                                        </button>
                                        <button type="submit" class="btn text-center w-md text-white"
                                            style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                            Continue
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </section>

                        <!-- Confirm Details -->
                        <h3>Validation
                            {{-- <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 20%; padding-top:8px" width="20px"> --}}

                            @if ($fica->Validation_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded mb-3">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 9: Validation
                                    </h4>
                                </div>
                            </div>
                            <br>
                            <div class="text-center" id="validation-loading">
                                <i class="fas fa-sync fa-spin fa-5x" style="color:#93186c"></i>
                            </div>
                            <div id="fica-validation-status">
                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                    @if ($isValidationPassed == 1)
                                        <div class="alert alert-success text-center" role="alert">
                                            <h4 style="color: rgb(16, 144, 16)">
                                                Validation Completed
                                            </h4>
                                        </div>
                                        {{-- @elseif ($isValidationPassed == 0)
                                        <div class="alert alert-danger text-center" role="alert">
                                            <h4 style="color: rgb(208, 21, 21)">
                                                Validation Failed
                                            </h4>
                                        </div> --}}
                                    @endif
                                @endif
                            </div>
                            <div id="loading-wait-validation" style="display: none" class="text-center">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span>
                                            <h5 class="aligncenter" style="color: #696969">Please wait </h5>
                                        </span>
                                        <img src="{{ URL::asset('/assets/images/loading.gif') }}" alt="cloud upload"
                                            width="50px" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center"
                                style="margin-left: 0px;margin-right: 12px;padding-right: 12px;">

                                <br>
                                <br>
                                <br>

                                <div id="rcorners2">

                                    <div id="validate-status" class="row d-flex justify-content-center">
                                        {{-- User Verification --}}
                                        <div class="col-sm-2">
                                            <div style="width: 95%;padding:1%;">
                                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                                    @if ($APIResultStatus['IDAS_Status'] == 1)
                                                        <div class="text-center" style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                                width="20%" />
                                                        </div>
                                                    @elseif ($APIResultStatus['IDAS_Status'] == 0)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @elseif ($APIResultStatus['IDAS_Status'] == 2)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="padding: 4%" id="userverification-warning">
                                                        <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                            width="20%" style="margin-left: 40%;" />
                                                    </div>
                                                @endif
                                                <div style="padding: 4%" id="userverification-success">
                                                    <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>

                                                <div style="padding: 4%" id="userverification-failed">
                                                    <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div class="text-center">
                                                    <img id="varification-image-static-id"
                                                        src="{{ URL::asset('/assets/images/verification-static.png') }}"
                                                        width="60%" />
                                                    <img id="varification-image-id"
                                                        src="{{ URL::asset('/assets/images/verification.gif') }}"
                                                        width="60%" />
                                                    <br><br>
                                                    <h6 style="color: #000; ">User Verification</h6>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- KYC --}}
                                        <div class="col-sm-2">
                                            <div style="width: 95%;padding:1%">
                                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                                    @if ($APIResultStatus['KYC_Status'] == 1)
                                                        <div class="text-center" style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                                width="20%" />
                                                        </div>
                                                    @elseif ($APIResultStatus['KYC_Status'] == 0)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @elseif ($APIResultStatus['KYC_Status'] == 2)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="padding: 4%" id="kyc-warning">
                                                        <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                            width="20%" style="margin-left: 40%;" />
                                                    </div>
                                                @endif

                                                <div style="padding: 4%" id="kyc-success">
                                                    <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div style="padding: 4%" id="kyc-failed">
                                                    <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div class="text-center">
                                                    <img id="varification-image-static-kyc"
                                                        src="{{ URL::asset('/assets/images/KYC.png') }}"
                                                        width="60%" />
                                                    <img id="varification-image-kyc" style="margin-left: 18px;"
                                                        src="{{ URL::asset('/assets/images/KYC.gif') }}"
                                                        width="60%" />
                                                    <br><br>
                                                    <h6 style="color: #000; ">KYC</h6>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Bank Verification --}}
                                        <div class="col-sm-2">
                                            <div style="width: 95%;padding:1%">
                                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                                    @if ($APIResultStatus['AVS_Status'] == 1)
                                                        <div class="text-center" style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                                width="20%" />
                                                        </div>
                                                    @elseif ($APIResultStatus['AVS_Status'] == 0)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @elseif ($APIResultStatus['AVS_Status'] == 2)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="padding: 4%" id="avs-warning">
                                                        <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                            width="20%" style="margin-left: 40%;" />
                                                    </div>
                                                @endif
                                                <div style="padding: 4%" id="avs-success">
                                                    <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div style="padding: 4%" id="avs-failed">
                                                    <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div class="text-center">
                                                    <img id="varification-image-static-avs"
                                                        src="{{ URL::asset('/assets/images/payment.png') }}"
                                                        width="60%" />
                                                    <img id="varification-image-avs"
                                                        src="{{ URL::asset('/assets/images/payment.gif') }}"
                                                        width="60%" />
                                                    <br><br>
                                                    <h6 style="color: #000; ">Bank Verification</h6>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Facial Recognition --}}
                                        <div class="col-sm-2">
                                            <div style="width: 95%;padding:1%">
                                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                                    @if ($APIResultStatus['DOVS_Status'] == 1)
                                                        <div class="text-center" style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                                width="20%" />
                                                        </div>
                                                    @elseif ($APIResultStatus['DOVS_Status'] == 0)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @elseif ($APIResultStatus['DOVS_Status'] == 2)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="padding: 4%" id="facial-warning">
                                                        <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                            width="20%" style="margin-left: 40%;" />
                                                    </div>
                                                @endif
                                                <div style="padding: 4%" id="facial-success">
                                                    <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div style="padding: 4%" id="facial-failed">
                                                    <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div class="text-center">
                                                    <img id="varification-image-static-facial"
                                                        src="{{ URL::asset('/assets/images/facial.png') }}"
                                                        width="60%" />
                                                    <img id="varification-image-facial"
                                                        src="{{ URL::asset('/assets/images/facial.gif') }}"
                                                        width="60%" />
                                                    <br><br>
                                                    <h6 style="color: #000; ">Facial Recognition</h6>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Compliance --}}
                                        <div class="col-sm-2">
                                            <div style="width: 95%;padding:1%">
                                                @if ($fica->Validation_Status != null || $fica->Correction_Status != null)
                                                    @if ($APIResultStatus['Compliance_Status'] == 1)
                                                        <div class="text-center" style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                                width="20%" />
                                                        </div>
                                                    @elseif ($APIResultStatus['Compliance_Status'] == 0)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @elseif ($APIResultStatus['Compliance_Status'] == 2)
                                                        <div style="padding: 4%">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;" />
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="padding: 4%" id="compliance-warning">
                                                        <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                            width="20%" style="margin-left: 40%;" />
                                                    </div>
                                                @endif
                                                <div style="padding: 4%" id="compliance-success">
                                                    <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                {{-- <div style="padding: 4%" id="compliance-warning">
                                                            <img src="{{ URL::asset('/assets/images/warning2.svg') }}"
                                                                width="20%" style="margin-left: 40%;">
                                                        </div> --}}
                                                <div style="padding: 4%" id="compliance-failed">
                                                    <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}"
                                                        width="20%" style="margin-left: 40%;" />
                                                </div>
                                                <div class="text-center">
                                                    <img id="varification-image-static-compliance"
                                                        src="{{ URL::asset('/assets/images/compliance.png') }}"
                                                        width="60%" />
                                                    <img id="varification-image-compliance"
                                                        src="{{ URL::asset('/assets/images/compliance.gif') }}"
                                                        width="60%" />
                                                    <br><br>
                                                    <h6 style="color: #000;">Compliance</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Execute APIs Buttons --}}
                                {{-- <div class="col-lg-6">
                                    <div class="text-center">
                                        <form method="post" action="{{ route('kyc-api') }}"
                                            enctype="multipart/form-data" id="kyc-api">
                                            @csrf
                                            <div class="col-md-12">
                                                <br>
                                                <button type="submit" name="submit-kyc" id="submit-kyc"
                                                    class="btn btn-primary">Validate KYC</button>
                                            </div>
                                        </form>
                                        <form method="post" action="{{ route('avs-api') }}"
                                            enctype="multipart/form-data" id="avs-api">
                                            @csrf
                                            <div class="col-md-12">
                                                <br>
                                                <button type="submit" name="submit-avs" id="submit-avs"
                                                    class="btn btn-primary">Validate AVS
                                                </button>
                                            </div>
                                        </form>
                                        <form method="post" action="{{ route('compliance-api') }}"
                                            enctype="multipart/form-data" id="compliance-api">
                                            @csrf
                                            <div class="col-md-12">
                                                <br>
                                                <button type="submit" name="submit-compliance" id="submit-compliance"
                                                    class="btn btn-primary">Validate Compliance
                                                </button </div>
                                        </form>
                                    </div>
                                </div> --}}

                                <div class="text-center">
                                    <br>
                                    <form method="post" action="{{ route('validateapi') }}"
                                        enctype="multipart/form-data" id="validateapi">
                                        @csrf
                                        <br><br>
                                        {{-- @if ($fica->Correction_Status === null) --}}
                                        @if ($fica->Validation_Status !== null)
                                            <button type="submit" name="validation-submit" id="validation-submit"
                                                class="btn text-center w-md text-white" disabled
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Validate
                                            </button>
                                        @else
                                            <button type="submit" name="validation-submit" id="validation-submit"
                                                class="btn text-center w-md text-white"
                                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                                Validate
                                            </button>
                                        @endif
                                        @if ($fica->Validation_Status !== null)
                                            @if ($fica->FICAStatus !== 'Failed')
                                                <button type="button" name="continue-validation"
                                                    id="continue-validation" class="btn text-center w-md text-white"
                                                    style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                                    Continue
                                                </button>
                                            @else
                                                <button type="button" name="continue-validation"
                                                    class="btn text-center w-md text-white"
                                                    style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;"
                                                    data-bs-toggle="modal" data-bs-target="#validation-failed-model">
                                                    Continue
                                                </button>
                                            @endif
                                        @else
                                            <button type="button" name="continue-validation" id="continue-validation"
                                                class="btn text-center w-md text-white" disabled
                                                style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;">
                                                Continue
                                            </button>
                                        @endif
                                        {{-- @endif --}}

                                    </form>
                                </div>
                            </div>
                        </section>

                        <h3>Acknowledgement
                            @if ($fica->Signed_Status != null)
                                <img src="{{ URL::asset('/assets/images/success.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @else
                                <img src="{{ URL::asset('/assets/images/incomplete.svg') }}"
                                    style="float: right; margin-right: 5%; padding-top:6px" width="22px" />
                            @endif
                        </h3>
                        <section>
                            <div class="heading-fica-id rounded mb-4">
                                <div class="text-center">
                                    <h4
                                        style="color: #f3f3f3;padding-top: 8px;padding-bottom: 8px;padding-right: 8px;padding-left: 8px;">
                                        Step 10: Acknowledgement
                                    </h4>
                                </div>
                            </div>
                            <form method="post" action="{{ route('acknowledgement') }}"
                                enctype="multipart/form-data">
                                @csrf


                                <div style="padding-left:6%">
                                    <br>
                                    {{-- <div id="fica-final-status"> --}}
                                    {{-- @if ($fica->FICAStatus == 'Completed')
                                        <div class="alert alert-success text-center" role="alert">
                                            <h4 style="color: green">
                                                Congratulations, your Fica has been Completed
                                            </h4>
                                        </div>
                                    @endif --}}
                                    {{-- </div> --}}
                                    <br>
                                    <div class="col-lg-12">

                                        <div class="row justify-content-center">
                                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="mb-3">
                                                    <label for="surname-lbl" class="form-label"
                                                        class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Full Name:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="mb-3">
                                                    <input type="text" autocomplete="off" class="form-control"
                                                        style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; width: 200px; text-transform: uppercase;"
                                                        id="fullname-input" name="fullname-input"
                                                        placeholder="Enter Full Name"
                                                        value="{{ $consumer->FirstName }} {{ $consumer->Surname }}"
                                                        readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row justify-content-center">

                                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="mb-3">
                                                    <label for="name-lbl" class="form-label" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Signed
                                                        Place:
                                                        <span style="color: red; font-size: 20px;" class="required">*
                                                        </span>
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="mb-3">

                                                    <input type="text"
                                                        class="form-control @error('signed-place-input') is-invalid @enderror"
                                                        value="{{ $fica->Signed_Place != null ? $fica->Signed_Place : '' }}"
                                                        id="signed-place-input" name="signed-place-input"
                                                        style="height: 27px; width:200px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                        placeholder="Enter Signed Place">
                                                    @error('signed-place-input')
                                                        <div style="color: red">
                                                            {{ $message = 'Field is required' }}
                                                        </div>
                                                    @enderror

                                                </div>

                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-4"> --}}
                                        <div style="display: flex; justify-content: center;">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input big-checkbox @error('terms-and-conditions-checkbox') is-invalid @enderror"
                                                    type="checkbox" value=1
                                                    {{ $fica->TandC_Status != null ? 'checked' : '' }}
                                                    id="terms-and-conditions-checkbox"
                                                    name="terms-and-conditions-checkbox"
                                                    style="border-bottom-width: 2px;border-top-width: 2px;border-right-width: 2px;border-left-width: 2px;margin-top: 5%;">

                                                {{-- <label class="form-check-label" for="salary-checkbox" style="padding-left:15px;font-size: 12px; color: rgb(0, 0, 0);padding-top: 0.25em;">
                                                        I agree to the 
                                                        <a style="color: red" href="{{ $customer->CustomerTerms_URL }}" target="_blank">
                                                            Terms and Conditions 
                                                        </a>
                                                    </label> --}}

                                                <a type="button" class="fw-medium text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#TandC">
                                                    Terms and Conditions
                                                </a>

                                                <span style="color: red; font-size: 20px;" class="required">
                                                    *
                                                </span>

                                                @error('terms-and-conditions-checkbox')
                                                    <div style="color: red">
                                                        {{ $message = 'Field is required' }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>
                                        {{-- </div> --}}

                                    </div>

                                    <div class="row justify-content-center" style="padding-top:6%">
                                        @if ($fica->FICAStatus == 'Completed')
                                            <button type="submit" class="btn text-center text-white w-md mt-4" disabled
                                                style="width: 15%; background-color: #93186c; border-color: #93186c"
                                                {{-- data-bs-toggle="modal" data-bs-target="#acknowledgement-success-model" --}}>
                                                Submit
                                            </button>
                                        @else
                                            <button type="submit" class="btn text-center text-white w-md mt-4"
                                                style="width: 15%; background-color: #93186c; border-color: #93186c">
                                                {{-- data-bs-toggle="modal" data-bs-target="#acknowledgement-success-model" --}}
                                                Submit </button>
                                        @endif
                                        @if ($fica->FICAStatus == 'Completed')
                                            <button type="button" id="complete-fica-popup" data-bs-toggle="modal"
                                                data-bs-target="#acknowledgement-success-model" style="display: none">
                                                Complete Fica
                                            </button>
                                        @endif

                                    </div>

                                </div>

                                <br>

                            </form>
                        </section>

                    </div>
                </div>
            </div>

        </div>
    </body>

    <!-- start T and C-->
    <div>
        <!-- sample modal content -->
        <div id="TandC" class="modal fade" tabindex="-1" aria-labelledby="TandCLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TandCLabel">Terms and
                            Conditions</h5>
                        <button type="button" style="border-color: #93186c;background-color: #93186c"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- <h5>Overflowing text to show scroll behavior</h5> --}}
                        <p>
                            The following terms and conditions describe the
                            terms on which Inspirit Data Analytics Services
                            (Pty) Ltd (IDAS), an Authorised Agent of Xpert
                            Decision Systems (Pty) Ltd (XDS), offers you use of
                            website (www.inspiritdata.co.za), mobile application
                            software and access to our services. All Products
                            and Services offered by IDAS is Powered by XDS
                        </p>

                        <p>
                            Important - read carefully. These terms are a legal
                            agreement between you, the licensed user (either an
                            individual or organization) (“you” or “your”) and
                            Inspirit Data Analytics Services, for use of our
                            services including our website, dashboard, mobile
                            application, our associated printed and online
                            documentation (collectively, the "services"). Only
                            the licensee may accept these terms and use the
                            services. The licensee is the individual or entity
                            designated as such on the Data Services Agreement
                            which details the services that were licensed from
                            us. Do not use the services and exit now if you are
                            not the licensee, or a person with authority to bind
                            the licensee to these terms. By accepting these
                            terms or using the services you, as an individual
                            and in your personal capacity, represent and warrant
                            to us that you are either (i) the individual
                            licensed to use the services, or (ii) a person duly
                            authorized to act on behalf of the organization that
                            is the licensee of the services, or (iii) a person
                            that has been authorized by a licensee to use the
                            services under the licensee’s license to use the
                            services. If this is not the case, your use of the
                            services is not authorized and you are personally
                            liable and responsible for any damage incurred by
                            IDAS.
                        </p>

                        <p>
                            If you do not agree to these terms, do not install
                            or use the services and exit now.
                        </p>

                        <p>
                            By accessing this web site, you are agreeing to be
                            bound by these web site Terms and Conditions of Use.
                            The materials contained in this web site are
                            protected by applicable copyright and trade mark
                            laws.
                        </p>

                        <p>
                            When you create an account with us, you guarantee
                            that you are above the age of 18, and that the
                            information you provide us is accurate, complete,
                            and current at all times. Inaccurate, incomplete, or
                            obsolete information may result in the immediate
                            termination of your account on the Service. You are
                            responsible for maintaining the confidentiality of
                            your account and password, including but not limited
                            to the restriction of access to your computer and/or
                            account. You agree to accept responsibility for any
                            and all activities or actions that occur under your
                            account and/or password, whether your password is
                            with our Service or a third-party service. You must
                            notify us immediately upon becoming aware of any
                            breach of security or unauthorized use of your
                            account.
                        </p>

                        <p>
                            By creating an Account on our service, you agree to
                            subscribe to newsletters, marketing or promotional
                            materials and other information we may send.
                            However, you may opt out of receiving any, or all,
                            of these communications from us by following the
                            unsubscribe link or instructions provided in any
                            email we send.
                        </p>

                        <p>
                            In no event shall IDAS or its suppliers be liable
                            for any damages (including, without limitation,
                            damages for loss of profit, or due to business
                            interruption,) arising out of the use or inability
                            to use the materials on IDASs’ website, even if IDAS
                            or an IDAS authorised representative has been
                            notified orally or in writing of the possibility of
                            such damage.
                        </p>

                        <p>
                            You agree that You will use the Services in a manner
                            consistent with any and all applicable laws and
                            regulations. We reserve the right but are not
                            obligated to investigate and terminate Your use or
                            access to the Services if You have misused the
                            Services or behaved in a way which could be regarded
                            as inappropriate or whose conduct is unlawful or
                            illegal. With respect to Your use of the Service,
                            You agree that You will not: (a) Impersonate any
                            person or entity; (b) "Stalk" or otherwise harass
                            any person; (c) Express or imply that any statements
                            You make are endorsed by IDAS, without Our specific
                            prior written consent; (d) use any robot, spider,
                            site search/retrieval application, or other manual
                            or automatic device or process to retrieve, index,
                            "data mine", or in any way reproduce or circumvent
                            the navigational structure or presentation of the
                            Service or its contents; (e) post, distribute or
                            reproduce in any way any copyrighted material,
                            trademarks, or other proprietary information without
                            obtaining the prior consent of the owner of such
                            proprietary rights and (f) remove any copyright,
                            trademark or other proprietary rights notices
                            contained in the applications or with respect to the
                            Service.
                        </p>

                        <p>
                            Our Service may contain links to third party web
                            sites or services that are not owned or controlled
                            by IDAS. Our Service also permits Users to
                            communicate with other users of the Service (“Other
                            Users”).
                        </p>

                        <p>
                            IDAS has no control over, and assumes no
                            responsibility for the content, privacy policies, or
                            practices of any third-party web sites or services
                            or posted or shared by Other Users. We do not
                            warrant the offerings or information of any of these
                            entities/individuals or their websites.
                        </p>

                        <p>
                            You acknowledge and agree that IDAS shall not be
                            responsible or liable, directly or indirectly, for
                            any damage or loss caused or alleged to be caused by
                            or in connection with use of or reliance on any such
                            content, goods or services available on or through
                            any such third-party web sites or services or Other
                            Users.
                        </p>

                        <p>
                            We strongly advise you to read the terms and
                            conditions and privacy policies of any third-party
                            web sites or services that you visit, and to
                            exercise due diligence and care when deciding
                            whether or not to engage in a potential transaction
                            with any Other User.
                        </p>

                        <p>
                            The materials on IDAS’s web site are provided “as
                            is”. IDAS makes no warranties, expressed or implied,
                            and hereby disclaims and negates all other
                            warranties, including without limitation, implied
                            warranties. Further, IDAS does not warrant or make
                            any representations concerning the accuracy, likely
                            results, or reliability of the use of the materials
                            on its Internet web site or otherwise relating to
                            such materials or on any sites linked to this site.
                        </p>

                        <p>
                            IDAS may revise these terms of use for its web site
                            at any time without notice. By using this website,
                            you are agreeing to be bound by the then current
                            version of these Terms and Conditions of Use.
                        </p>

                        <p>
                            Any claim relating to IDAS’s web site shall be
                            governed by the laws of the State of South Africa
                            without regard to its conflict of law provisions.
                        </p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end T and C-->

    {{-- ID Popup Modal --}}
    {{-- Success Popup --}}
    <div class="modal fade" id="composemodal-id" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
        aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding-botton:20px ">
                    <br>
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('/assets/images/success2.svg') }}" width="90px" />

                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Please confirm identity number.</h4>
                                <h4 style="color: #696969">ID Number:
                                    <span>
                                        <strong id="textid" style="color: #696969">
                                        </strong>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>
                <hr>

                <div class="d-flex justify-content-center mb-3">
                    {{-- <div class="row"> --}}
                    <div style="padding-right:2px">
                        <form method="post" action='{{ route('submitID') }}' enctype="multipart/form-data">
                            @csrf
                            {{-- <a href="javascript:window.location = window.location"> --}}
                            <button type="submit" class="btn btn-primary" id='id-model-yes'
                                style="width: 120px; background-color: #93186c; border-color: #93186c">Yes
                            </button>
                            {{-- </a> --}}
                        </form>
                    </div>
                    {{-- <a href="javascript:window.location = window.location"> --}}
                    <a href="javascript:window.history.forward(1)">
                        <div style="padding-left:2px">
                            <button type="button" class="btn btn-secondary" id='id-model-no'
                                data-bs-dismiss="modal"
                                style="width: 120px; background-color: #5e7b00; border-color: #5e7b00">No</button>
                        </div>
                    </a>
                </div>
            </div>
            <br>
            {{-- </form> --}}
        </div>
    </div>

    {{-- Failed Popup --}}
    <div class="modal fade" id="composemodal-failed" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mb-10">
                        <br>
                        <img src="{{ URL::asset('/assets/images/fail-cross.png') }}" alt="cloud upload"
                            width="100px" />
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Document upload failed.</h4>
                                <p class="font-size-14 mb-2" style="color: #696969">Account number cannot be retrieved.
                                </p>
                                <p class="font-size-14 mb-2" style="color: #696969">Document is encrypted or unreadable.
                                </p>
                                <p class="font-size-14" style="color: #696969">Please upload an image.</p>
                                {{-- <p class="text-muted font-size-14 mb-4" style="color: #1a4f6e" id="pid">
                                    We can not determine a valid ID Number.
                                </p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center mb-3">
                    {{-- <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="width: 150px">No</button> --}}
                    <button type="button" class="btn btn-primary" id="btn-reupload"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK
                    </button>
                </div>

                <br>
            </div>
        </div>
    </div>
    {{-- End ID Popup Modal --}}

    {{-- Address Popup Modal --}}
    <div class="modal fade" id="composemodal-address" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-body">
                    <div id="loader-address-model" class="center"></div>
                    <form id="fileUpload-address-input" action='{{ route('proofofaddress') }}' method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <div class=" text-center">
                                <h4 class="card-title mb-4" style="color: #93186c"><strong>Physical Address</strong>
                                </h4>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="py-street-line-1" class="form-label">Street Address Line 1</label>
                                    <input type="type" class="form-control" placeholder="ENTER ADDRESS LINE 1"
                                        id="py-street-line-1" name="py-street-line-1" style="padding-left: 24px"
                                        autocomplete="off" required>                                        
                                        <span id= "error-py-street-line-1" class="text-danger" role="alert">
                                            </span>
                                    {{-- @if ($errors->has('py-street-line-1'))
                                        <span class="text-danger">{{ $errors->first('py-street-line-1') }}</span>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="py-street-line-2" class="form-label">Street Address Line 2</label>
                                    <input type="type" class="form-control" id="py-street-line-2"
                                        style="padding-left: 24px" name="py-street-line-2"
                                        placeholder="ENTER ADDRESS LINE 2" autocomplete="off"  required>
                                    <span id= "error-py-street-line-2" class="text-danger" role="alert">
                                            </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="py-city" class="form-label">City:</label>

                                    <div class="input-group" style="height: 35px; width: 100%;">

                                        <input type="text" class="form-control"
                                            style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                            id="py-city" name="py-city" placeholder="ENTER CITY" autocomplete="off" required>
                                        <span id= "error-py-city" class="text-danger" role="alert">
                                            </span>
                                        {{-- <select class="form-select" autocomplete="off"
                                            style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                            id="py-city" name="py-city" required>
                                            <option hidden>Select City</option>
                                            @foreach ($citiesNames as $city)
                                                <option value="{{ isset($city) ? $city : null }}">
                                                    {{ $city }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    {{-- <label for="py-state" class="form-label">State/Province/Region</label>
                                    <input type="type" class="form-control" id="py-state"
                                        name="py-state"required> --}}
                                    <label for="py-state" class="form-label">State/Province/Region</label>
                                    <div class="input-group" style="height: 35px; width: 100%;">
                                        <select class="form-select" autocomplete="off"
                                            style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                            id="py-state" name="py-state" required>
                                            <option hidden>Select Province</option>
                                            @foreach ($provincesNames as $province)
                                                <option value="{{ isset($province) ? $province : null }}">
                                                    {{ $province }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id= "error-py-state" class="text-danger" role="alert">
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="py-zip" class="form-label">ZIP</label>
                                    <input type="type" class="form-control" id="py-zip"
                                        style="padding-left: 24px" name="py-zip" placeholder="ENTER ZIP" autocomplete="off" required>
                                    <span id= "error-py-zip" class="text-danger" role="alert">
                                            </span>
                                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="checkbox-address"
                                            name="checkbox-address"
                                            style="background-color: #93186c; border-color: #93186c" checked>
                                        <label class="form-check-label" for="horizontalLayout-Check">
                                            Same as Physical Address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col" id="postalId">
                            <div class=" text-center">
                                <h4 class="card-title mb-4" style="color: #93186c"><strong> Postal Address</strong></h4>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="po-street-line-1" class="form-label">Postal Address Line 1</label>
                                    <input type="type" class="form-control" id="po-street-line-1"
                                        name="po-street-line-1" placeholder="ENTER ADDRESS LINE 1" autocomplete="off"
                                        style="padding-left: 24px">
                                    <span id= "error-po-street-line-1" class="text-danger" role="alert">
                                            </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="po-street-line-2" class="form-label">Postal Address Line 2</label>
                                    <input type="type" class="form-control" id="po-street-line-2"
                                        name="po-street-line-2" placeholder="ENTER ADDRESS LINE 2" autocomplete="off"
                                        style="padding-left: 24px">
                                    <span id= "error-po-street-line-2" class="text-danger" role="alert">
                                            </span>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="po-city" class="form-label">City</label>
                                    {{-- <input type="type" class="form-control" id="po-city" name="po-city"> --}}

                                    <input autocomplete="off" type="text" class="form-control"
                                        style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                        id="po-city" name="po-city" autocomplete="off" placeholder="ENTER CITY">
                                    <span id= "error-po-city" class="text-danger" role="alert">
                                            </span>

                                    {{-- <select class="form-select" autocomplete="off"
                                        style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                        id="po-city" name="po-city" required>
                                        <option hidden>Select City</option>
                                        @foreach ($citiesNames as $city)
                                            <option value="{{ isset($city) ? $city : null }}">
                                                {{ $city }}
                                            </option>
                                        @endforeach
                                    </select> --}}

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="po-state" class="form-label">State/Province/Region</label>
                                    {{-- <input type="type" class="form-control" id="po-state" name="po-state"> --}}

                                    <select class="form-select" autocomplete="off"
                                        style="height: 35px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                        id="po-state" name="po-state" required>
                                        <option hidden>Select Province</option>
                                        @foreach ($provincesNames as $province)
                                            <option value="{{ isset($province) ? $province : null }}">
                                                {{ $province }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id= "error-po-state" class="text-danger" role="alert">
                                            </span>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="po-zip" class="form-label">ZIP</label>
                                    <input type="type" class="form-control" id="po-zip" name="po-zip"
                                        placeholder="ENTER ZIP" style="padding-left: 24px" autocomplete="off">
                                    <span id= "error-po-zip" class="text-danger" role="alert">
                                            </span>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                            <div class="mb-3">
                                <label for="po-country" class="form-label">Country</label>
                                <input type="type" class="form-control" id="po-country" name="po-country">
                                <span id= "error-po-country" class="text-danger" role="alert">
                                            </span>
                            </div>
                        </div> --}}

                        </div>
                        <div class=" text-center">
                            <button type="submit" class="btn btn-primary w-md"
                                style="background-color: #93186c; border-color: #93186c">Submit</button>
                            <button type="button" class="btn btn-primary" id="btn-hidden-address-modal"
                                data-bs-toggle="modal" data-bs-target="#composemodal-address-model-success">
                                Show PopUp
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-hidden-address-modal-failed"
                                data-bs-toggle="modal" data-bs-target="#composemodal-address-model-failed">
                                Show PopUp
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Address Popup Mode --}}
    <div class="modal fade" id="composemodal-address-model-success" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding-botton:20px ">
                    <br>
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('/assets/images/success2.svg') }}" width="90px" />

                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Information matches document.</h4>
                                {{-- <h4 style="color: #1a4f6e">ID Number: <span><strong id="textid" style="color: #1a4f6e">
                                    </strong> </span></h4> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="text-center mb-3">
                    {{-- <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="width: 150px">No</button> --}}
                    <button type="button" class="btn btn-primary" id="btn-address-success-model"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK</button>
                </div>

                <br>
                {{-- </form> --}}
            </div>
        </div>
    </div>

    {{-- Failed Address Popup Mode --}}
    <div class="modal fade" id="composemodal-address-model-failed" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mb-10">
                        <br>
                        <img src="{{ URL::asset('/assets/images/fail-cross.png') }}" alt="cloud upload"
                            width="100px" />
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Please try again.</h4>
                                <h4 style="color: #696969">Data differs from document.</h4>
                                <p class="text-muted font-size-14 mb-4" style="color: #696969"
                                    id="address-failed-model">
                                    {{-- Document date is more then 3 --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center mb-3">
                    {{-- <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="width: 150px">No</button> --}}
                    <button type="button" class="btn btn-primary" id="btn-refresh-address"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK</button>
                </div>

                <br>
            </div>
        </div>
    </div>

    <div class="modal fade" id="composemodal-failed" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-header bg-transparent border-danger">
                        <h5 class="my-0 text-danger"><i class="mdi mdi-block-helper me-3"></i>Failed</h5>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-10">

                        <img src="{{ URL::asset('/assets/images/cross.png') }}" alt="cloud upload" width="100px" />
                        <br><br>

                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Address failed to validate.</h4>
                                <p class="text-muted font-size-14 mb-4">Document date is more then 3 month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mb-3">
                    <button type="submit" style="background-color: #5e7b00; border-color: #5e7b00"
                        class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="btnYes-failed">Yes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Address Popup Modal --}}

    {{-- Bank Popup Modal --}}
    <div class="modal fade" id="composemodal-bank" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-body">
                    <div id="loader-address-model" class="center"></div>
                    <form id="fileUpload-bank-model" action='{{ route('proofofbank') }}' method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <div class=" text-center">
                                <h4 class="card-title mb-4" style="color: #93186c"><strong> Bank Account
                                        Details</strong></h4>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="initials" class="form-label">Initials</label>
                                    <input type="type" class="form-control @error('initials') is-invalid @enderror"
                                        id="initials" name="initials" placeholder="ENTER INITIALS"
                                        autocomplete="off">
                                    @error('initials')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="surname"
                                        class="form-label  @error('surname') is-invalid @enderror">Surname</label>
                                    <input type="type" class="form-control" id="surname" name="surname"
                                        autocomplete="off" placeholder="ENTER SURNAME">
                                    @error('surname')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="acc-number" class="form-label">Account Number</label>
                                    <input type="type"
                                        class="form-control @error('acc-number') is-invalid @enderror" id="acc-number"
                                        autocomplete="off" name="acc-number" placeholder="ENTER ACCOUNT NUMBER">
                                    @error('acc-number')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="bank-name-dd" class="form-label">Bank Name</label>
                                    <div class="input-group" style="height: 35px; width: 100%;">
                                        <select class="form-select @error('bank-name-dd') is-invalid @enderror"
                                            autocomplete="off"
                                            style="height: 35px; padding-left: 12px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                            id="bank-name-dd" name="bank-name-dd" placeholder="ENTER BANK NAME">
                                            <option hidden>Select Bank Name</option>
                                            @foreach ($bankNames as $bank)
                                                <option value="{{ isset($bank) ? $bank : null }}">
                                                    {{ $bank }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bank-name-dd')
                                            <div style="color: red">
                                                {{ $message = 'Field is required' }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="acc-number" class="form-label">Account Type</label>
                                    <div class="input-group" style="height: 35px; width: 100%;">
                                        <select class="form-select @error('BankTypeid') is-invalid @enderror"
                                            autocomplete="off"
                                            style="height: 35px; padding-left: 12px;padding-top: 2px;padding-bottom: 2px; font-size:12px; text-transform: uppercase;"
                                            id="BankTypeid" name="BankTypeid">
                                            @if ($bankTpye->count())
                                                <option hidden>Select Bank Type</option>
                                                @foreach ($bankTpye as $type)
                                                    <option
                                                        value="{{ isset($type->BankTypeid) ? $type->BankTypeid : null }}">
                                                        {{ $type->AccountType }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('BankTypeid')
                                            <div style="color: red">
                                                {{ $message = 'Field is required' }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="branch" class="form-label">Branch Code</label>
                                    <input type="type" class="form-control @error('branch') is-invalid @enderror"
                                        autocomplete="off" autocomplete="off" id="branch" name="branch"
                                        placeholder="ENTER BRANCH CODE">
                                    @error('branch')
                                        <div style="color: red">
                                            {{ $message = 'Field is required' }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn text-center w-md text-white"
                                style="width: 10%; background-color: #93186c; border-color: #93186c">
                                Submit
                            </button>

                            <button type="button" class="btn btn-primary" id="btn-hidden-bank-modal"
                                data-bs-toggle="modal" data-bs-target="#composemodal-bank-model-success">
                                Show PopUp
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-hidden-bank-failed"
                                data-bs-toggle="modal" data-bs-target="#composemodal-bank-failed">
                                Show PopUp
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Bank Popup Modal --}}

    {{-- Bank Success Popup --}}
    <div class="modal fade" id="composemodal-bank-model-success" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding-botton:20px ">
                    <br>
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('/assets/images/success2.svg') }}" width="90px" />

                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Information matches document.</h4>
                                {{-- <h4 style="color: #1a4f6e">ID Number: <span><strong id="textid" style="color: #1a4f6e">
                                    </strong> </span></h4> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary" id="btn-bank-refresh"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK</button>
                </div>

                <br>
                {{-- </form> --}}
            </div>
        </div>
    </div>
    {{-- End Bank Success Popup --}}

    {{-- Bank Fail Popup --}}
    <div class="modal fade" id="composemodal-bank-failed" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mb-10">
                        <br>
                        <img src="{{ URL::asset('/assets/images/fail-cross.png') }}" alt="cloud upload"
                            width="100px" />
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969">Please try again.</h4>

                                <p class="font-size-14 mb-2" style="color: #696969">Account number cannot be retrieved.
                                </p>
                                <p class="font-size-14 mb-2" style="color: #696969">Document is encrypted or unreadable.
                                </p>
                                <p class="font-size-14" style="color: #696969">Please upload an image.</p>

                                {{-- <h4 style="color: #1a4f6e">We can not determine a valid ID Number, document is encrypted or unreadable.</h4>
                                <h4 style="color: #1a4f6e">Please upload again or take a picture.</h4> --}}
                                {{-- <p id="errorMessage" class="text-muted font-size-14 mb-4" style="color: #1a4f6e"></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary" id="btn-bank-refresh2"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK</button>
                </div>

                <br>
            </div>
        </div>
    </div>
    {{-- End Bank Popup Modal --}}

    {{-- Selfie Popup Modal --}}
    <div class="modal fade" id="composemodal-selfie" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('getselfieresult') }}" method="post" enctype="multipart/form-data"
                    id="getselfieResult">
                    @csrf
                    <div class="modal-body">
                        <br><br>
                        <div class="text-center mb-4">
                            <div id="facial-loading-dynamic">
                                <img src="{{ URL::asset('/assets/images/selfie2.gif') }}" width="120px" />
                            </div>
                            <div id="facial-loading-static" style="display: none">
                                <img src="{{ URL::asset('/assets/images/selfie2.png') }}" width="120px" />
                            </div>
                            <br><br>
                            <div class="row justify-content-center">
                                <br>
                                <div class="col-xl-10" id="selfie-link-title">
                                    <h4 style="color: #696969">Selfie Link SMS has been sent.
                                    </h4>
                                </div>
                                <div id="alertSuccess" class="alert alert-success" role="alert">
                                    <br>
                                    <p id="seflie-text" style="color: rgb(0, 116, 0); font-size: 15px;"></p>
                                </div>

                                <div id="alertError" class="alert alert-danger" role="alert">
                                    <br>
                                    <p id="seflie-text-error" style="color: rgb(182, 37, 37); font-size: 15px;"></p>
                                </div>
                            </div>
                            <br>
                            {{-- <p class="text-muted font-size-14 mb-4" style="color:#1a4f6e;">1. Please click the link sent
                                in
                                your phone to take a
                                selfie.
                            </p> --}}
                            <p class="text-muted font-size-14 mb-4" style="color:#696969;margin-bottom: 3%;">Please
                                click the
                                button below to continue.
                            </p>
                        </div>
                        <div class="text-center mb-3">
                            {{-- <div id="save-and-cancel-declaration-btn" style="display: none"> --}}
                            <button type="submit" id="submitBtn" class="btn text-center w-md text-white"
                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;">
                                Continue
                            </button>

                            <button type="button" id="selfie-continue" class="btn text-center w-md text-white"
                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;"
                                disabled data-bs-dismiss="modal">
                                Continue
                            </button>

                            <button type="button" id="selfie-cancel" class="btn text-center w-md text-white"
                                style="width: 10%; background-color: #5e7b00; border-color: #5e7b00;margin-bottom: 3%;"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="button" class="btn text-center w-md text-white" id="btn-Okay"
                                style="width: 10%; background-color: #93186c; border-color: #93186c;margin-bottom: 3%;"
                                data-bs-dismiss="modal">
                                OK
                            </button>

                            {{-- </div> --}}
                        </div>

                    </div>
                </form>
                <br><br><br>
            </div>
            {{-- </form> --}}
        </div>
    </div>
    {{-- End Selfie Popup Modal --}}

    {{-- Validation Failed Popup --}}
    <div class="modal fade" id="validation-failed-model" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding-botton:20px ">
                    <br>
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('/assets/images/fail-cross.svg') }}" width="90px" />

                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 style="color: #696969"> Your submission requires additional verification. An
                                    administrator will be in touch.
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary" id="btn-bank-refresh" data-bs-dismiss="modal"
                        style="width: 150px; background-color: #93186c; border-color: #93186c">OK</button>
                </div>
                <br>
            </div>
        </div>
    </div>
    {{-- Validation Failed Popup End --}}

    {{-- Acknowledgement Success Popup --}}
    <div class="modal fade" id="acknowledgement-success-model" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding-botton:20px ">
                    <br>
                    <div class="text-center mb-4">
                        <img src="{{ URL::asset('/assets/images/success2.svg') }}" width="90px" />
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h5 style="color: #696969"> Congratulations, your Fica has been Completed, click logout
                                    button to logout.
                                </h5>
                            </div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="text-center mb-3">
                    <form id="logout-form"
                        action="{{ route('logout', ['customer' => $customer, 'customerName' => $customerName]) }}"
                        method="POST">
                        @csrf
                        <button type="submit" style="background-color: #93186c;border-color: #93186c"
                            class="btn btn-primary" data-bs-dismiss="modal" style="width: 150px">Logout</button>
                    </form>
                </div>
                <br>
            </div>
        </div>
    </div>

    <!-- Static Backdrop modal Button -->
    <button id="modalbtn" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
        data-bs-target="#staticBackdrop" hidden>
        Static backdrop modal
    </button>


    <!-- Static Backdrop Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Your Session is About to Expire</h5>
                    <button type="button" style="background-color: #93186c;border-color: #93186c" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: #696969">Your Session will expire in 2 mins, please click on the logout button to
                        logout or on stay connected to continue.</p>
                </div>
                <div class="modal-footer">
                    <button id="logoutbtn" type="button" onclick="logout()" class="btn btn-light"
                        data-bs-dismiss="modal">Logout</button>
                    <button id="staybtn" style="background-color: #93186c; border-color: #93186c" type="button"
                        onclick="stayconnected()" class="btn btn-primary" data-bs-dismiss="modal">Stay
                        Connected</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    {{-- ID upload --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // $(#file-input).show();
            $('#file-input').change(function() {
                var filename = 'File name: ' + $('#file-input').val().split('\\').pop();
                console.log(filename, $('#file-name'));

                var lastIndex = filename.lastIndexOf("\\");
                $('#file-name').text(filename);
                // $(':input[type="submit"]').prop('disabled', false);
                $('#submit-id').show();

                $('#click-icon-static').show();
                $('#click-icon').hide();

            });
            $("#composemodal-id").modal({
                backdrop: "static ",
                keyboard: false
            });
            $('#fileUpload').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('fica') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loading-briefcase').show();
                        $('#loading-wait-identity').show();
                        $('#image-upload-identity').hide();
                    },
                    complete: function() {
                        $('#loading-briefcase').hide();
                        $('#loading-wait-identity').hide();
                        $('#image-upload-identity').hide();
                    },
                    success: function(response) {
                        if (response.data.status == true) {
                            $('#textid').append(response.data.IdNumber);
                            // console.log(response.data)
                            $("#btn-hidden-id").click();
                        } else {
                            $("#btn-hidden-failed").click();
                            console.log(response.data)
                        }
                    },
                    error: function(response) {
                        //$("#btn-hidden-id").click();
                        //  console.log('error')
                        // $("#btn-hidden-failed").click();
                    }

                });
            });

            $("#btnYes").click(function() {
                location.reload();
            });
            $("#btnYes-failed").click(function() {
                location.reload();
            });

        });
    </script>

    {{-- Address upload --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#file-input-address').change(function() {
                var filename = 'File name: ' + $('#file-input-address').val().split(
                    '\\').pop();
                // var filename = $('#file-input-address').val().split('\\').pop();
                // console.log(filename, $('#file-name-address'));
                var lastIndex = filename.lastIndexOf("\\");
                $('#file-name-address').text(filename);
                // $(':input[type="submit"]').prop('disabled', false);
                $('#submit-address').show();
                $('#click-icon-address').hide();
                $('#click-icon-static-address').show();
            });
            $("#composemodal-address").modal({
                backdrop: "static ",
                keyboard: false
            });

            $('#fileUpload-address').on('submit', function(e) {
                //  var verified = '<?php $IDN; ?>';
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('fica') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loading-briefcase-address').show();
                        $('#loading-wait-address').show();
                        $('#image-upload-bank').hide();
                    },
                    complete: function() {
                        $('#loading-briefcase-address').hide();
                        $('#loading-wait-address').show();
                        $('#image-upload-bank').hide();
                    },
                    success: function(response) {
                        console.log('success!')
                        $("#btn-hidden-address").click();
                    },
                    error: function() {
                        $("#btn-hidden-failed").click();

                    }

                });
            });


            $("#btn-reupload").click(function() {
                location.reload();
            });
            $("#btnYes-failed").click(function() {
                location.reload();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#fileUpload-address-input').on('submit', function(e) {
                //  var verified = '<?php $IDN; ?>';
                e.preventDefault();
                $('#error-po-street-line-1').hide();
                $('#error-po-street-line-2').hide();
                $('#error-po-city').hide();
                $('#error-po-state').hide();
                $('#error-po-zip').hide();
                $('#error-py-street-line-1').hide();
                $('#error-py-street-line-2').hide();
                $('#error-py-city').hide();
                $('#error-py-state').hide();
                $('#error-py-zip').hide();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('proofofaddress') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {


                    },
                    complete: function() {

                    },
                    success: function(response) {
                        // console.log(response.data.status)
                        if (response.data.status == true) {
                            console.log(response.data.status);
                            $("#btn-hidden-address-modal").click();
                            console.log('PASSED');
                            // location.reload();
                        } else {
                            $("#btn-hidden-address-modal-failed").click();
                            console.log(response.data);
                            $('#address-failed-model').text(response.data.message);
                            console.log('FAILED');
                        }

                    },
                    error: function(response) {
                        console.log('ERROR');
                        var errorRes = response.responseJSON.errors;
                        console.log(errorRes);
                        for (var key in errorRes) {
                            var value = errorRes[key][0];
                            $('#error-'+key).html(value);
                            $('#error-'+key).show();
                        }
                        // $("#btn-hidden-failed").click();
                    }

                });
                $("#btn-ok").click(function() {
                    location.reload();
                });
                $("#btn-address-success-model").click(function() {
                    location.reload();
                });
                $("#btn-refresh-address").click(function() {
                    location.reload();
                });

            });

            $("#checkbox-address").on("click", function() {
                var isChecked = $('#checkbox-address').is(':checked');
                if (isChecked) {
                    document.querySelector("#postalId").style.display = "none";
                } else {
                    document.querySelector("#postalId").style.display = "block";
                }
            });

        });
    </script>

    {{-- Bank upload --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#file-input-bank').change(function() {
                var filename = 'File name: ' + $('#file-input-bank').val().split('\\').pop();
                // console.log(filename, $('#file-name-address'));
                var lastIndex = filename.lastIndexOf("\\");
                $('#file-name-bank').text(filename);
                // $(':input[type="submit"]').prop('disabled', false);
                $('#submit-bank').show();
                $('#click-icon-static-bank').show();
                $('#click-icon-bank').hide();

            });

            $('#fileUpload-bank').on('submit', function(e) {
                //  var verified = '<?php $IDN; ?>';
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('fica') }}',
                    method: 'POST',
                    data: form_data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loading-moneybag-address').show();
                        $('#loading-wait-bank').show();
                        $('#image-upload-bank').hide();
                    },
                    complete: function() {
                        $('#loading-moneybag-address').hide();
                        $('#loading-wait-bank').hide();
                        $('#image-upload-bank').hide();
                    },
                    success: function(response) {

                        $('#bank-name').val(response.bankAccount[0])
                        // $('#acc-number').attr("disabled", true)
                        //$("input_name").val() =
                        $("#btn-hidden-bank").click();
                        //location.reload();

                    },
                    error: function() {
                        $("#btn-hidden-bank").click();
                    }

                });
            });

            $("#btnYes").click(function() {
                location.reload();
            });
            $("#btnYes-failed").click(function() {
                location.reload();
            });

            $("#btn-bank-refresh").click(function() {
                location.reload();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#composemodal-bank").modal({
                backdrop: "static ",
                keyboard: false
            });

            $('#fileUpload-bank-model').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('proofofbank') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // document.querySelector("#loader-address-model").style.visibility =
                        //     "visible";
                    },
                    complete: function() {
                        // document.querySelector("#loader-address-model").style.display = "none";
                    },
                    success: function(response) {
                        if (response.data.status) {
                            console.log(response.data);
                            console.log('PASSED');
                            // $('#bankMessage').text(response.msg);
                            $("#btn-hidden-bank-modal").click();
                        } else {
                            $('#errorMessage').text(response.data.message);
                            // $('#error-message-bank').text(response.data.message);
                            $("#btn-hidden-bank-failed").click();

                            // $('#address-failed-model').text(response.data.message);
                            console.log(response.data);
                            console.log('FAILED');
                        }

                        //location.reload();

                    },
                    error: function() {
                        // $("#btn-hidden-failed").click();
                    }

                });

                $("#btnYes-cancel").click(function() {
                    location.reload();

                });

                $("#btn-bank-refresh2").click(function() {
                    location.reload();
                });
            });

        });
    </script>

    {{-- take selfie --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#submit-facial').on('click', function(e) {

            // });

            // $("#submit-facial").click(function() {
            //     $('#click-icon-facial').hide();
            //     $('#click-icon-static-facial').show();
            // });
            $("#composemodal-selfie").modal({
                backdrop: "static ",
                keyboard: false
            });
            $('#selfieLink').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('selfie') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // document.querySelector("#loader-selfie").style.visibility =
                        //     "visible";
                        $('#loading-send-sms').show();
                        $('#click-icon-facial').hide();
                        $('#click-icon-static-facial').show();
                    },
                    complete: function() {
                        $('#loading-send-sms').hide();
                        $('#click-icon-facial').hide();
                        $('#click-icon-static-facial').show();
                        // document.querySelector("#loader-selfie").style.display = "none";
                    },
                    success: function(response) {
                        $("#btn-hidden-selfie").click();
                        // $("#composemodal-selfie").modal({
                        //     backdrop: 'static',
                        //     keyboard: false,
                        //     show: true // added property here
                        // });
                        var i = 1;
                        var x = setInterval(function() {
                            var text = $('#seflie-text').html();
                            console.log(text);
                            if (text !== 'Consumer') {
                                $("#submitBtn").click();

                                var text2 = $('#seflie-text').html();
                                if (text2 == 'Consumer') {
                                    clearInterval(x);
                                }
                                if (i > 50) {
                                    $('#selfie-link-title').hide();
                                    $('#facial-loading-dynamic').hide();
                                    $('#facial-loading-static').show();
                                    $('#seflie-text-error').text(
                                        'Selfie has not been taken successfully. Please click the selfie link button again to resend the link!'
                                    );
                                    $("#selfie-continue").hide();
                                    $("#selfie-cancel").hide();
                                    $("#alertError").show();
                                    $("#seflie-text-error").show();
                                    $("#btn-Okay").show();
                                    console.log(
                                        'Selfie has not been taken Successfully. Please click the selfie link button again to resend the link!'
                                    );
                                    clearInterval(x);
                                }
                                i++;
                            }

                            if (text === 'Consumer') {
                                clearInterval(x);
                                console.log('Selfie has been taken successfully!');
                                $('#selfie-link-title').hide();
                                $('#facial-loading-dynamic').hide();
                                $('#facial-loading-static').show();
                                $('#seflie-text').text(
                                    'Selfie has been taken successfully!');
                                //$("#selfie-continue").hide();
                                $("#seflie-text").show();
                                // $("#submitBtn").show();
                                $("#selfie-continue").prop("disabled", false);
                                $("#alertSuccess").show();
                                $("#selfie-cancel").prop("disabled", true);
                                $('#seflie-text').text(
                                    'Selfie has been taken successfully!');
                                // $("#submitBtn").prop("disabled", false);
                                clearInterval(x);
                            }
                        }, 10000);
                        // alert(response.msg);
                        //location.reload();
                    },
                    error: function() {
                        // $("#btn-hidden-failed").click();
                    }
                });
            });
            $("#selfie-continue").click(function() {
                location.reload();

            });

            $("#selfie-cancel").click(function() {
                location.reload();

            });

        });
    </script>

    {{-- Selfie Results --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#getselfieResult').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('getselfieresult') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // document.querySelector("#loader-selfie").style.visibility =
                        //     "visible";

                    },
                    complete: function() {
                        // document.querySelector("#loader-selfie").style.display = "none";
                        //  $('#loading-send-sms').hide();
                    },
                    success: function(output_data) {
                        // if (output_data.data === 'Consumer') {
                        $('#seflie-text').text(output_data.data);
                        // console.log('textResult: ' + textResult);
                        // }

                    },
                    error: function() {
                        // $("#btn-hidden-failed").click();
                    }
                });
            });
        });
    </script>

    {{-- KYC --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#kyc-api').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('kyc-api') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function() {

                    },
                    error: function() {}

                });


            });

        });
    </script>

    {{-- AVS --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#avs-api').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('avs-api') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // document.querySelector("#loader-selfie").style.visibility =
                        //     "visible";

                    },
                    complete: function() {
                        // document.querySelector("#loader-selfie").style.display = "none";
                    },
                    success: function(response) {
                        // alert(response.msg);
                        console.log('Passed');
                        //location.reload();

                    },
                    error: function() {
                        console.log('Failed');
                        // $("#btn-hidden-failed").click();
                    }

                });


            });

        });
    </script>

    {{-- Complaince --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#compliance-api').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('compliance-api') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {},
                    complete: function() {},
                    success: function(response) {

                        // alert(response.msg);

                        //location.reload();

                    },
                    error: function() {
                        // $("#btn-hidden-failed").click();
                    }

                });


            });

        });
    </script>

    {{-- APIs --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#validateapi').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                $.ajax({
                    url: '{{ route('validateapi') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // $("#validation-loading").show()
                        $("#varification-image-static-id").hide();
                        $("#varification-image-static-kyc").hide();
                        $("#varification-image-static-avs").hide();
                        $("#varification-image-static-facial").hide();
                        $("#varification-image-static-compliance").hide();

                        $("#varification-image-id").show();
                        $("#varification-image-kyc").show();
                        $("#varification-image-avs").show();
                        $("#varification-image-facial").show();
                        $("#varification-image-compliance").show();

                        $('#validation-submit').prop('disabled', true);

                        $("#loading-wait-validation").show();
                    },
                    complete: function() {
                        $("#varification-image-static-id").show();
                        $("#varification-image-static-kyc").show();
                        $("#varification-image-static-avs").show();
                        $("#varification-image-static-facial").show();
                        $("#varification-image-static-compliance").show();

                        $("#varification-image-id").hide();
                        $("#varification-image-kyc").hide();
                        $("#varification-image-avs").hide();
                        $("#varification-image-facial").hide();
                        $("#varification-image-compliance").hide();

                        $('#validation-submit').prop('disabled', true);
                        $('#continue-validation').prop('disabled', false);

                        $("#loading-wait-validation").hide();
                    },
                    success: function(response) {
                        console.log('Passed');
                        console.log(response.data);
                        if (response.data.IDAS_Status == 1) {
                            $('#userverification-success').show();
                            $('#userverification-failed').hide();
                            $('#userverification-warning').hide();
                        } else if (response.data.IDAS_Status === 0) {
                            $('#userverification-success').hide();
                            $('#userverification-failed').show();
                            $('#userverification-warning').hide();
                        }
                        if (response.data.KYC_Status === 1) {
                            $('#kyc-success').show();
                            $('#kyc-failed').hide();
                            $('#kyc-warning').hide();
                        } else if (response.data.KYC_Status === 0) {
                            $('#kyc-success').hide();
                            $('#kyc-failed').show();
                            $('#kyc-warning').hide();
                        }
                        if (response.data.AVS_Status === 1) {
                            $('#avs-success').show();
                            $('#avs-failed').hide();
                            $('#avs-warning').hide();
                        } else if (response.data.AVS_Status === 0) {
                            $('#avs-success').hide();
                            $('#avs-failed').show();
                            $('#avs-warning').hide();
                        }
                        if (response.data.DOVS_Status === 1) {
                            $('#facial-success').show();
                            $('#facial-failed').hide();
                            $('#facial-warning').hide();
                        } else if (response.data.DOVS_Status === 0) {
                            $('#facial-success').hide();
                            $('#facial-failed').show();
                            $('#facial-warning').hide();
                        }
                        if (response.data.Compliance_Status === 1) {
                            $('#compliance-success').show();
                            $('#compliance-failed').hide();
                            $('#compliance-warning').hide();
                        } else if (response.data.Compliance_Status === 0) {
                            $('#compliance-success').hide();
                            $('#compliance-failed').show();
                            $('#compliance-warning').hide();
                        }


                        $('#validation-submit').prop('disabled', true);
                        $('#continue-validation').prop('disabled', false);

                        // update fica validationstatut
                        $("#fica-validation-status").load(location.href +
                            " #fica-validation-status");

                        //update validate status
                        $("#validate-status").load(location.href +
                            " #validate-status");

                    },

                    error: function() {
                        console.log('Failed');
                        // $("#btn-hidden-failed").click();
                    }

                    // function updateDiv(string id) {
                    //     $(`#${id}`).load(window.location.href + ` # ${id}`);
                    // }
                });

            });
            $("#continue-validation").click(function() {
                //  $("#mydiv").load(location.href + " #mydiv");
                location.reload();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            //Personal
            $("#personal-edit-btn").click(function() {
                $('#personal-edit-btn').hide();
                $('#personal-save-btn').show();


                $('#country-input').prop('disabled', false);
                $('#titleId').prop('disabled', false);
                $('#id-issuedate-input').prop('disabled', false);
                $('#tax-number-input').prop('disabled', false);
                $('#employee-status-input').prop('disabled', false);
                $('#industry-of-occupation-input').prop('disabled', false);
                $('#employeer-name-input').prop('disabled', false);

                $('#street-address-line1').prop('disabled', false);
                $('#street-address-line2').prop('disabled', false);
                $('#city-physical').prop('disabled', false);
                $('#province-physical').prop('disabled', false);
                $('#zip-physical').prop('disabled', false);

                $('#postal-address-line1').prop('disabled', false);
                $('#postal-address-line2').prop('disabled', false);
                $('#city-postal').prop('disabled', false);
                $('#province-postal').prop('disabled', false);
                $('#zip-postal').prop('disabled', false);

                $('#employeer-street-address-line1-input').prop('disabled', false);
                $('#employeer-street-address-line2-input').prop('disabled', false);
                $('#employeer-city-input').prop('disabled', false);
                $('#employeer-province-input').prop('disabled', false);
                $('#employeer-postal-code-input').prop('disabled', false);

                $('#telephone-home-input').prop('disabled', false);
                $('#work-number-input').prop('disabled', false);
                console.log('Edit button clicked');
            });


            $("#personal-cancel-btn").click(function() {
                $('#personal-edit-btn').hide();
                $('#personal-save-btn').show();


                $('#country-input').prop('disabled', true);
                $('#titleId').prop('disabled', true);
                $('#id-issuedate-input').prop('disabled', true);
                $('#tax-number-input').prop('disabled', true);
                $('#employee-status-input').prop('disabled', true);
                $('#industry-of-occupation-input').prop('disabled', true);
                $('#employeer-name-input').prop('disabled', true);

                $('#street-address-line1').prop('disabled', true);
                $('#street-address-line2').prop('disabled', true);
                $('#city-physical').prop('disabled', true);
                $('#province-physical').prop('disabled', true);
                $('#zip-physical').prop('disabled', true);

                $('#postal-address-line1').prop('disabled', true);
                $('#postal-address-line2').prop('disabled', true);
                $('#city-postal').prop('disabled', true);
                $('#province-postal').prop('disabled', true);
                $('#zip-postal').prop('disabled', true);

                $('#employeer-street-address-line1-input').prop('disabled', true);
                $('#employeer-street-address-line2-input').prop('disabled', true);
                $('#employeer-city-input').prop('disabled', true);
                $('#employeer-province-input').prop('disabled', true);
                $('#employeer-postal-code-input').prop('disabled', true);

                $('#telephone-home-input').prop('disabled', true);
                $('#work-number-input').prop('disabled', true);

                console.log('Edit button clicked');
            });

            //Personal Details
            $("#personal-save-btn").click(function() {
                $('#personal-edit-btn').show();
                $('#personal-save-btn').hide();
                console.log('Save button clicked');
            });

            $("#Tax_Oblig_outside_SA").change(function() {
                var value = this.value;
                console.log(value);
                value == 0 ? $("#foreign-tax-number").hide() : $("#foreign-tax-number").show();

            });

            //Screening
            $("#public-officia-dropdown").change(function() {
                var value = this.value;
                console.log(value);
                value == 0 ? $("#public-offical-checkboxes").hide() : $("#public-offical-checkboxes")
                    .show();
            });
            $("#public-officia-family-dropdwon").change(function() {
                var value = this.value;
                console.log(value);
                value == 0 ? $("#public-offical-family-checkboxes").hide() : $(
                    "#public-offical-family-checkboxes").show();
            });


            $("#personal-save-btn").click(function() {
                $('#personal-edit-btn').show();
                $('#personal-save-btn').hide();
                console.log('Save button clicked');
            });


            //Financial Details
            $("#edit-financial-btn").click(function() {
                $('#save-and-cancel-financial-btn').show();
                $('#edit-financial-btn').hide();


                $('#tax-number-input').prop('disabled', false);
                $('#funds-input').prop('disabled', false);
                $('#Tax_Oblig_outside_SA').prop('disabled', false);
            });


            $("#cancel-financial-btn").click(function() {
                $('#save-and-cancel-financial-btn').hide();
                $('#edit-financial-btn').show();


                $('#tax-number-input').prop('disabled', true);
                $('#funds-input').prop('disabled', true);
                $('#Tax_Oblig_outside_SA').prop('disabled', true);
            });

            //Screen Details
            $("#edit-screen-btn").click(function() {

                $('#save-and-cancel-screen-btn').show();
                $('#edit-screen-btn').hide();

                $('#public-officia-dropdown').prop('disabled', false);
                $('#public-officia-family-dropdwon').prop('disabled', false);
                $('#sanctions-list-dropdown').prop('disabled', false);
                $('#adverse-medai-dropdown').prop('disabled', false);

                $('#public-offical-domestic-prominent-checkbox').prop('disabled', false);
                $('#public-offical-eppo-checkbox').prop('disabled', false);
                $('#public-offical-family-domestic-prominent-checkbox').prop('disabled', false);
                $('#public-offical-family-eppo-checkbox').prop('disabled', false);

                publicOffical = $('#public-officia-dropdown option:selected').val();
                if (publicOffical == 1) {
                    $('#public-offical-checkboxes').show();
                }

                publicFimalyOffical = $('#public-officia-family-dropdwon option:selected').val();
                if (publicFimalyOffical == 1) {
                    $('#public-offical-family-checkboxes').show();
                }

            });


            $("#cancel-screen-btn").click(function() {
                $('#save-and-cancel-screen-btn').hide();
                $('#edit-screen-btn').show();

                $('#public-officia-dropdown').prop('disabled', true);
                $('#public-officia-family-dropdwon').prop('disabled', true);
                $('#sanctions-list-dropdown').prop('disabled', true);
                $('#adverse-medai-dropdown').prop('disabled', true);

                $('#public-offical-domestic-prominent-checkbox').prop('disabled', true);
                $('#public-offical-eppo-checkbox').prop('disabled', true);
                $('#public-offical-family-domestic-prominent-checkbox').prop('disabled', true);
                $('#public-offical-family-eppo-checkbox').prop('disabled', true);
            });

            //Declaraction
            $("#edit-declaration-btn").click(function() {
                $('#save-and-cancel-declaration-btn').show();
                $('#edit-declaration-btn').hide();


                $('#client-due-diligence-dropdown').prop('disabled', false);
                $('#nominee-declaration-dropdown').prop('disabled', false);
                $('#issuer-communication-selection-dropdown').prop('disabled', false);
                $('#custody-service-selection-dropdown').prop('disabled', false);
                $('#segregated-depository-acounts-dropdown').prop('disabled', false);
                $('#dividends-tax-dropdown').prop('disabled', false);
                $('#bee-shareholders-dropdown').prop('disabled', false);
                $('#stamp-duty-reserve-tax-checkbox').prop('disabled', false);
                $('#communication-type-selection-dropdown').prop('disabled', false);
                $('#broker-contact-input').prop('disabled', false);
                $('#broker-name-input').prop('disabled', false);
            });


            $("#cancel-declaration-btn").click(function() {
                $('#save-and-cancel-declaration-btn').hide();
                $('#edit-declaration-btn').show();


                $('#client-due-diligence-dropdown').prop('disabled', true);
                $('#nominee-declaration-dropdown').prop('disabled', true);
                $('#issuer-communication-selection-dropdown').prop('disabled', true);
                $('#custody-service-selection-dropdown').prop('disabled', true);
                $('#segregated-depository-acounts-dropdown').prop('disabled', true);
                $('#dividends-tax-dropdown').prop('disabled', true);
                $('#bee-shareholders-dropdown').prop('disabled', true);
                $('#stamp-duty-reserve-tax-checkbox').prop('disabled', true);
                $('#communication-type-selection-dropdown').prop('disabled', true);
                $('#broker-contact-input').prop('disabled', true);
                $('#broker-name-input').prop('disabled', true);
            });


            //Previous buttons
            $("#personal-cancel-btn").click(function() {
                $('a#previous-btn').trigger('click');
            });

            $("#cancel-financial-btn").click(function() {
                $('a#previous-btn').trigger('click');
            });

            $("#cancel-screen-btn").click(function() {
                $('a#previous-btn').trigger('click');
            });

            $("#cancel-declaration-btn").click(function() {
                $('a#previous-btn').trigger('click');
            });


            // Employee Status
            $("#employee-status-input").change(function() {
                var value = this.value;
                if (value == 'Unemployed') {
                    $('#employeer-name-input').prop('disabled', true);
                    $('#employeer-street-address-line1-input').prop('disabled', true);
                    $('#employeer-street-address-line2-input').prop('disabled', true);
                    $('#employeer-province-input').prop('disabled', true);
                    $('#employeer-province-input').prop('disabled', true);
                    $('#employeer-postal-code-input').prop('disabled', true);
                    $('#employeer-city-input').prop('disabled', true);

                } else if (value == 'Employed') {
                    $('#employeer-name-input').prop('disabled', false);
                    $('#employeer-street-address-line1-input').prop('disabled', false);
                    $('#employeer-street-address-line2-input').prop('disabled', false);
                    $('#employeer-province-input').prop('disabled', false);
                    $('#employeer-province-input').prop('disabled', false);
                    $('#employeer-postal-code-input').prop('disabled', false);
                    $('#employeer-city-input').prop('disabled', false);
                }
            });

            $("#id-model-no").click(function() {
                location.reload();
            });

            $("#complete-fica-popup").click();

            //Refresh acknowledgement status
            // $("#acknowledgement-submit-btn").click(function() {
            //     $("#fica-final-status").load(location.href + "#fica-final-status");

            // });
        });
    </script>

    <script>
        document.getElementById('Tax_Oblig_outside_SA').addEventListener('change', function() {
            var style = this.value == 1 ? 'block' : 'none';
            document.getElementById("foreign-tax-number").style.display = style;
        });
    </script>

    <script>
        function status(select) {

            // document.getElementById('brokerinfo').style.display = "none";

            if (select.value == 'Securities must be registered in my Own Name') {
                document.getElementById('brokerinfo').style.display = "block";
            } else {
                document.getElementById('brokerinfo').style.display = "none";
            }
        }
    </script>

    <script>
        var timer = setInterval(function() {
            document.getElementById("mainpage").style.display = "block";
        }, 150);
    </script>

    <script>
        $(document).ready(function() {
            var idleState = false;
            var idleTimer = null;
            var idleTimer2 = null;
            const timeout = 300000; // 300000 ms = 5 minutes
            const modaltime = 180000;

            $('*').bind(
                'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick',
                function() {
                    clearTimeout(idleTimer);
                    idleState = false;
                    idleTimer = setTimeout(function() {
                        document.getElementById('modalbtn').click();

                        idleTimer2 = setTimeout(function() {
                            document.getElementById('logout-form').submit();
                            idleState = true;
                        }, timeout);
                    }, modaltime);

                });
            $("body").trigger("mousemove");
        });
    </script>

    <script>
        function logout() {
            document.getElementById('logout-form').submit();
        };
    </script>

    <script>
        $(document).ready(function() {
            var idleState = false;
            var idleTimer = null;
            var idleTimer2 = null;
            const timeout = 300000; // 300000 ms = 5 minutes
            const modaltime = 180000;

            $('*').bind(
                'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick',
                function stayconnected() {
                    clearTimeout(idleTimer);
                    idleState = false;
                    const timeout = 0;

                });
            $("body").trigger("mousemove");
            document.getElementById('staticBackdrop').hide();
        });
    </script>
@endsection
