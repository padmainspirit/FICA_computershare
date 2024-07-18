@extends('layouts.master-without-nav')

@section('title')
@lang('translation.selfbankingservice')
@endsection

@section('css')
<style>
    .required{
        color:"#ff0000" !important;
    }

</style>

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
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="heading-fica-id mb-1">
                                <div class="">
                                    <h4 class="font-size-18"
                                        style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Account Details
                                    </h4>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-lg-12">
                                    <div class="row">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Shareholder Reference Number <span style="color:red;" class="required">*</span></label>



                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="border-radius: 15px; "
                                                    id="ShareholderRef1" name="ShareholderRef1" placeholder="Enter Shareholder Reference Number"
                                                    value="{{ old('ShareholderRef') }}">

                                                    <span class="error-messg"></span>
                                                    @error('ShareholderRef1')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                        style="border-radius: 15px; "
                                                            id="company1" name="company1">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                --SELECT COMPANY--
                                                            </option>

                                                            <option value="Vodacom" style="font-size: 12px;">
                                                                Vodacom
                                                            </option>

                                                            <option value="MTN" style="font-size: 12px;">
                                                                MTN
                                                            </option>

                                                            <option value="Telkom" style="font-size: 12px;">
                                                                Telkom
                                                            </option>

                                                            <option value="Hullet" style="font-size: 12px;">
                                                                Hullet
                                                            </option>

                                                            <option value="KMPG" style="font-size: 12px;">
                                                                KMPG
                                                            </option>
                                                            <option value="Sasol" style="font-size: 12px;">
                                                                Sasol
                                                            </option>
                                                            <option value="Delloite" style="font-size: 12px;">
                                                                Delloite
                                                            </option>
                                                            <option value="EY" style="font-size: 12px;">
                                                                EY
                                                            </option>
                                                            <option value="Mukuru" style="font-size: 12px;">
                                                                Mukuru
                                                            </option>
                                                            <option value="Unilever" style="font-size: 12px;">
                                                                Unilever
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div style="display:none;" class="row hidden" id = "div2">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Shareholder Reference Number <span style="color:red;" class="required">*</span></label>



                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="border-radius: 15px; "
                                                    id="ShareholderRef" name="ShareholderRef" placeholder="Enter Shareholder Reference Number"
                                                    value="{{ old('ShareholderRef2') }}">

                                                    <span class="error-messg"></span>
                                                    @error('ShareholderRef2')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                        style="border-radius: 15px; "
                                                            id="company2" name="company2">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                --SELECT COMPANY--
                                                            </option>

                                                            <option value="Vodacom" style="font-size: 12px;">
                                                                Vodacom
                                                            </option>

                                                            <option value="MTN" style="font-size: 12px;">
                                                                MTN
                                                            </option>

                                                            <option value="Telkom" style="font-size: 12px;">
                                                                Telkom
                                                            </option>

                                                            <option value="Hullet" style="font-size: 12px;">
                                                                Hullet
                                                            </option>

                                                            <option value="KMPG" style="font-size: 12px;">
                                                                KMPG
                                                            </option>
                                                            <option value="Sasol" style="font-size: 12px;">
                                                                Sasol
                                                            </option>
                                                            <option value="Delloite" style="font-size: 12px;">
                                                                Delloite
                                                            </option>
                                                            <option value="EY" style="font-size: 12px;">
                                                                EY
                                                            </option>
                                                            <option value="Mukuru" style="font-size: 12px;">
                                                                Mukuru
                                                            </option>
                                                            <option value="Unilever" style="font-size: 12px;">
                                                                Unilever
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div style="display:none;" class="row hidden" id = "div3">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Shareholder Reference Number <span style="color:red;" class="required">*</span></label>



                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="border-radius: 15px; "
                                                    id="ShareholderRef3" name="ShareholderRef3" placeholder="Enter Shareholder Reference Number"
                                                    value="{{ old('ShareholderRef3') }}">

                                                    <span class="error-messg"></span>
                                                    @error('ShareholderRef3')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                        style="border-radius: 15px; "
                                                            id="company3" name="company3">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                --SELECT COMPANY--
                                                            </option>

                                                            <option value="Vodacom" style="font-size: 12px;">
                                                                Vodacom
                                                            </option>

                                                            <option value="MTN" style="font-size: 12px;">
                                                                MTN
                                                            </option>

                                                            <option value="Telkom" style="font-size: 12px;">
                                                                Telkom
                                                            </option>

                                                            <option value="Hullet" style="font-size: 12px;">
                                                                Hullet
                                                            </option>

                                                            <option value="KMPG" style="font-size: 12px;">
                                                                KMPG
                                                            </option>
                                                            <option value="Sasol" style="font-size: 12px;">
                                                                Sasol
                                                            </option>
                                                            <option value="Delloite" style="font-size: 12px;">
                                                                Delloite
                                                            </option>
                                                            <option value="EY" style="font-size: 12px;">
                                                                EY
                                                            </option>
                                                            <option value="Mukuru" style="font-size: 12px;">
                                                                Mukuru
                                                            </option>
                                                            <option value="Unilever" style="font-size: 12px;">
                                                                Unilever
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div style="display:none;" class="row hidden" id = "div4">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Shareholder Reference Number <span style="color:red;" class="required">*</span></label>



                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="border-radius: 15px; "
                                                    id="ShareholderRef4" name="ShareholderRef4" placeholder="Enter Shareholder Reference Number"
                                                    value="{{ old('ShareholderRef4') }}">

                                                    <span class="error-messg"></span>
                                                    @error('ShareholderRef4')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                        style="border-radius: 15px; "
                                                            id="company4" name="company4">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                --SELECT COMPANY--
                                                            </option>

                                                            <option value="Vodacom" style="font-size: 12px;">
                                                                Vodacom
                                                            </option>

                                                            <option value="MTN" style="font-size: 12px;">
                                                                MTN
                                                            </option>

                                                            <option value="Telkom" style="font-size: 12px;">
                                                                Telkom
                                                            </option>

                                                            <option value="Hullet" style="font-size: 12px;">
                                                                Hullet
                                                            </option>

                                                            <option value="KMPG" style="font-size: 12px;">
                                                                KMPG
                                                            </option>
                                                            <option value="Sasol" style="font-size: 12px;">
                                                                Sasol
                                                            </option>
                                                            <option value="Delloite" style="font-size: 12px;">
                                                                Delloite
                                                            </option>
                                                            <option value="EY" style="font-size: 12px;">
                                                                EY
                                                            </option>
                                                            <option value="Mukuru" style="font-size: 12px;">
                                                                Mukuru
                                                            </option>
                                                            <option value="Unilever" style="font-size: 12px;">
                                                                Unilever
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div style="display:none;" class="row hidden" id = "div5">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Shareholder Reference Number <span style="color:red;" class="required">*</span></label>



                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="border-radius: 15px; "
                                                    id="ShareholderRef5" name="ShareholderRef5" placeholder="Enter Shareholder Reference Number"
                                                    value="{{ old('ShareholderRef5') }}">

                                                    <span class="error-messg"></span>
                                                    @error('ShareholderRef5')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                        style="border-radius: 15px; "
                                                            id="company5" name="company5">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                --SELECT COMPANY--
                                                            </option>

                                                            <option value="Vodacom" style="font-size: 12px;">
                                                                Vodacom
                                                            </option>

                                                            <option value="MTN" style="font-size: 12px;">
                                                                MTN
                                                            </option>

                                                            <option value="Telkom" style="font-size: 12px;">
                                                                Telkom
                                                            </option>

                                                            <option value="Hullet" style="font-size: 12px;">
                                                                Hullet
                                                            </option>

                                                            <option value="KMPG" style="font-size: 12px;">
                                                                KMPG
                                                            </option>
                                                            <option value="Sasol" style="font-size: 12px;">
                                                                Sasol
                                                            </option>
                                                            <option value="Delloite" style="font-size: 12px;">
                                                                Delloite
                                                            </option>
                                                            <option value="EY" style="font-size: 12px;">
                                                                EY
                                                            </option>
                                                            <option value="Mukuru" style="font-size: 12px;">
                                                                Mukuru
                                                            </option>
                                                            <option value="Unilever" style="font-size: 12px;">
                                                                Unilever
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                </div>
                                <div class="mt-2">

                                    <p ><img id="addmore" src="{{ URL::asset('/assets/images/plus.png') }}" style="width:22px; margin-right:5px;" />ADD MORE</p>


                                    </div>


                            <hr style="color: rgb(238, 226, 226) ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid rgb(238, 226, 226); background-color: rgb(238, 226, 226); opacity: 100%;">

                            <div class="heading-fica-id mb-1">
                                <div class="">
                                    <h4 class="font-size-18"
                                        style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Personal Details
                                    </h4>
                                </div>
                            </div>


                                <form method="post" action="{{ route('sb-personalinfo') }}" id="sb-tnc-form">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="IDNUMBER">ID NUMBER <span style="color:red;" class="required">*</span></label>
                                            <input id="IDNUMBER" name="IDNUMBER" placeholder="Enter 13 digit ID Number"
                                                type="text" style="border-radius: 15px;" class="form-control"
                                                value="{{ old('IDNUMBER') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('FirstName')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>

                                            <div class="col-sm-6">
                                                <label for="FirstName">First Name <span style="color:red;" class="required">*</span></label>
                                                <input id="FirstName" name="FirstName" placeholder="Enter First Name"
                                                    type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                    value="{{ old('FirstName') }}" required="required" />

                                                <span class="error-messg"></span>
                                                @error('FirstName')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror

                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="Surname">Surname <span style="color:red;" class="required">*</span></label>
                                            <input id="Surname" name="Surname" placeholder="Enter Surname"
                                                type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                value="{{ old('Surname') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('Surname')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>

                                            <div class="col-sm-6">
                                                <label for="SecondName">Second Name </label>
                                                <input id="SecondName" name="SecondName" placeholder="Enter Second Name"
                                                    type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                    value="{{ old('SecondName') }}" />

                                                <span class="error-messg"></span>
                                                @error('SecondName')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror

                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                                <label for="PhoneNumber">Phone Number <span style="color:red;" class="required">*</span></label>
                                                <input id="PhoneNumber" name="PhoneNumber" placeholder="Enter PhoneNumber"
                                                    type="text" style="border-radius: 15px;" class="form-control" pattern="^([0-9]{10} ?)+$"
                                                    value="{{ old('PhoneNumber') }}" required="required" />

                                                <span class="error-messg"></span>
                                                @error('PhoneNumber')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="ThirdName">Third Name </label>
                                                <input id="ThirdName" name="ThirdName" placeholder="Enter Third Name"
                                                    type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                    value="{{ old('ThirdName') }}" />

                                                <span class="error-messg"></span>
                                                @error('ThirdName')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror

                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                                <label for="Email">Email <span style="color:red;" class="required">*</span></label>
                                                <input id="Email" name="Email" placeholder="Enter Email"
                                                    type="email" style="border-radius: 15px;" class="form-control"
                                                    value="{{ old('Email') }}" required="required" />

                                                <span class="error-messg"></span>
                                                @error('Email')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>

                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                        <div class="mt-3">



                                            <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c"
                                                class="btn w-md text-white">Clear</button>
                                                <button type="submit" class="btn w-md text-white" id="personaldetails"
                                                style="float: right;background-color: #93186c; border-color: #93186c;">Next</button>

                                        </div>

                                </form>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->
    @endsection

    @section('script')
    <script>
        let currentDiv = 0;
        const divs = document.querySelectorAll('.row .hidden');

        document.getElementById('addmore').addEventListener('click', () => {
            if (currentDiv < divs.length) {
                divs[currentDiv].style.display = 'block';
                currentDiv++;
            }
        });
    </script>

    @endsection
