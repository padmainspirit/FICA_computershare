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
                    <div class="card overflow-hidden">

                        <div style="background-image: linear-gradient(#93186c, #93186c);">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h5 class="text-white">Self service banking Process</h5>
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


                                <form method="post" action="{{ route('sb-personalinfo') }}" id="sb-tnc-form">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="IDNUMBER">IDNUMBER <span class="required">*</span></label>
                                            <input id="IDNUMBER" name="IDNUMBER" placeholder="Enter First Name"
                                                type="text" class="form-control" 
                                                value="{{ old('IDNUMBER') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('FirstName')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>

                                            <div class="col-sm-6">
                                                <label for="FirstName">First Name <span class="required">*</span></label>
                                                <input id="FirstName" name="FirstName" placeholder="Enter First Name"
                                                    type="text" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
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
                                            <label for="Surname">Surname <span class="required">*</span></label>
                                            <input id="Surname" name="Surname" placeholder="Enter Surname"
                                                type="text" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
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
                                                    type="text" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
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
                                                <label for="PhoneNumber">Phone Number <span class="required">*</span></label>
                                                <input id="PhoneNumber" name="PhoneNumber" placeholder="Enter PhoneNumber"
                                                    type="text" class="form-control" pattern="^([0-9]{10} ?)+$"
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
                                                <input id="ThirdName" name="ThirdName" placeholder="Enter ThirdName"
                                                    type="text" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
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
                                                <label for="Email">Email <span class="required">*</span></label>
                                                <input id="Email" name="Email" placeholder="Enter Email"
                                                    type="email" class="form-control" 
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

                                        <div class="mt-3 text-center">

                                            <button type="submit" class="btn w-md text-white" id="personaldetails"
                                                style="background-color: #93186c; border-color: #93186c;">Next</button>

                                            <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c"
                                                class="btn w-md text-white">Clear</button>

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


    @endsection