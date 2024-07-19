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
                                <form class="repeater" method="post" action="{{ route('sb-personalinfo') }}" id="sb-tnc-form">
                                    @csrf
                                    <div data-repeater-list="reflist">
                                        <?php $reflist = Request::old('reflist')!=null ? count(Request::old('reflist')) : 1;
                                            for ($i=0; $i < $reflist ; $i++) {
                                                $value = 'reflist.'.$i.'.refnum';
                                            ?>
                                            <div data-repeater-item class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="subject">Shareholder Reference Number<span style="color:red;">*</span></label>

                                                </div>
                                                <div class="mb-3 col-md-3">

                                                    <input style="border-radius: 15px; " id="subject" name="refnum" type="text" class="form-control" value="<?php echo Request::old($value);?>" placeholder="Enter Your Ref Number" required/>
                                                </div>


                                                <div class="mb-3 col-md-3" >
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
                                            <div class="mb-3 col-md-3" >
                                                <p data-repeater-delete style="cursor:pointer;"><img  src="{{ URL::asset('/assets/images/fail-cross.png') }}" style="width:22px; margin-right:5px;" />REMOVE</p>

                                        </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-3 mt-3">

                                            <p data-repeater-create style="cursor:pointer;"><img  src="{{ URL::asset('/assets/images/plus.png') }}" style="width:22px; margin-right:5px;" />ADD MORE</p>
                                        </div>


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
                                                <label for="Email">Email <span style="color:red;">*</span></label>
                                                <input id="Email" name="email" placeholder="Enter Email"
                                                    type="Email" style="border-radius: 15px;" class="form-control"
                                                    value="{{ old('Email') }}" required />

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

<script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
    @endsection
