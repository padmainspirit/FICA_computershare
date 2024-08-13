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
        <img src="{{ URL::asset('assets\images\logo\computershare.png') }}" style="max-width: 200px; max-height: 200px;" alt="" class="img-fluid">
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
                                    <div class="progress-bar" role="progressbar" style="width: 75%;background-color: green;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="text-center mb-4 mt-2 d-flex justify-content-between align-items-center">
                                    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/octicon--info-16.png') }}" style="height:45px;width:45px;">
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
                                @if (Session::has('Success'))
                                    <div class="alert alert-success">
                                    {{ Session::get('Success') }}
                                    </div>
                                @endif
                                @if (Session::has('message'))
                                    <div class="alert alert-danger">
                                    {{ Session::get('message') }}
                                    </div>
                                @endif

                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif


                                <form method="post" action="" id="sb-tnc-form"  enctype="multipart/form-data">
                                @csrf

                                <div class="heading-fica-id mb-1">
                                    <div class="">
                                        <h4 class="font-size-18" style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                            Banking Details
                                        </h4>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="branchcode">Account Holders Initial <span style="color:red;" class="required">*</span></label>
                                        <input id="initial" name="initial" placeholder="Account Holder Initial" type="text" style="border-radius: 15px;" class="form-control" value="{{ old('initial') ? old('initial') : $selfbankinglinkdetails->selfBankingDetails->AccountHolderInitial }}" required="required" />

                                        <span class="error-messg"></span>
                                        @error('initial')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $initial }}</small>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <div class="col-sm-12">
                                        <label for="branchcode">Account holder's initial <span style="color:red;" class="required">*</span></label>
                                        <input id="initial" name="initial" placeholder="Account holder initial" type="text" style="border-radius: 15px;" class="form-control" value="{{ old('initial') ? old('initial') : $selfbankinglinkdetails->selfBankingDetails->AccountHolderInitial }}" required="required" />

                                        <span class="error-messg"></span>
                                        @error('initial')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $initial }}</small>
                                        </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="form-group row mb-1">
                                    <div class="col-sm-12">
                                        <label for="accnumber">Account number <span style="color:red;" class="required">*</span></label>
                                        <input id="accnumber" name="accnumber" placeholder="Enter your bank account number" type="text" style="border-radius: 15px;" class="form-control" value="{{ old('accnumber') ? old('accnumber') : $selfbankinglinkdetails->selfBankingDetails->AccountNumber }}" required="required" />

                                        <span class="error-messg"></span>
                                        @error('accnumber')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $accnumber }}</small>
                                        </span>
                                        @enderror

                                    </div>

                                    <div class="col-sm-12 mt-1">
                                        <label for="BankName">Bank name <span style="color:red;" class="required">*</span></label>
                                        <select class="form-select" autocomplete="off" style="border-radius: 15px; " id="BankName" name="BankName">
                                            <option value="" style="">
                                                --Select Bank--
                                            </option>
                                            @foreach ($bankNames as $bank)
                                            <?php
                                                $selected = '';
                                                if(old('BankName') == $bank->bankname){
                                                    $selected = 'selected';
                                                }else if($selfbankinglinkdetails->selfBankingDetails->BankName == $bank->bankname){
                                                    $selected = 'selected';
                                                }
                                            ?>
                                            <option value="{{ $bank->bankname }}" data-price="{{ $bank->branchcode}}" {{ $selected }}>
                                                {{ $bank->bankname }}
                                            </option>
                                            @endforeach
                                            <option value="other" data-price='' {{ old('BankName') == 'other' ? 'selected' : '' }}>Other</option>


                                        </select>

                                        <span class="error-messg"></span>
                                        @error('BankName')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12 mb-1">
                                    <label for="BankName">Bank type <span style="color:red;" class="required">*</span></label>
                                        <select class="form-select" autocomplete="off" style="border-radius: 15px; " id="AccountType" name="AccountType">
                                            @if ($bankTpye->count())
                                            <option value="">Select Bank Type</option>
                                            @foreach ($bankTpye as $type)
                                            <?php
                                                $selected = '';
                                                if(old('AccountType') == $type->BankTypeid){
                                                    $selected = 'selected';
                                                }else if($selfbankinglinkdetails->selfBankingDetails->AccountType == $type->BankTypeid){
                                                    $selected = 'selected';
                                                }
                                            ?>
                                            <option value="{{ $type->BankTypeid }}" {{ $selected }}>
                                                {{ $type->AccountType }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>

                                <div class="form-group row mb-1">
                                    <div class="col-sm-12">
                                        <label for="branchcode">Branch code <span style="color:red;" class="required">*</span></label>
                                        <input id="branchcode" name="branchcode" placeholder="Branch code" type="text" style="border-radius: 15px;" class="form-control" value="{{ old('branchcode') ? old('branchcode') : $selfbankinglinkdetails->selfBankingDetails->BranchCode }}" required="required" />

                                        <span class="error-messg"></span>
                                        @error('branchcode')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                        @enderror

                                    </div>


                                </div>

                                <div class="mt-4 text-center" style="display:<?=  old('BankName') == 'other' ? 'block' : 'none'; ?> ;" id="otherBank">

                                    <p class="mb-4">Please upload a picture of your bank statement. We will not accept blurry
                                        images, photocopies or illegible information. Your bank account number must be fully visible,
                                        clear easy-to-read.
                                    </p>
                                    <div class="col-lg-3 mt-3">

<p title="Please upload a 3-month bank statement"
style="cursor:pointer;"><img src="{{ URL::asset('/assets/images/information.png') }}" style="width:22px; margin-right:5px;" /></p>
</div>

                                    <input type="file" id="fileInput" name="file" accept="image/*,.pdf" style="display: none;" onchange="handleFileSelect(event)">

                                    <div class="row justify-content-center mt-3">
                                        <div id="dropZone" class="col-auto" style="border:3px dotted black; height:300px;width:300px; border-radius:15px;">

                                            <h5 class="mt-5">Drag Files Here</h5>
                                            <button type="button" style="border:none; background: none;" onclick="document.getElementById('fileInput').click();">
                                                <img src="{{ URL::asset('/assets/images/upload-big-arrow.png') }}" style="width: 80px; margin-right: 5px;" />
                                            </button>
                                            <p style="font-size:16px;" class="mt-3">or</p>
                                            <h5 class="mt-1">Browse Image/PDF Files</h5>
                                        </div>
                                        {{--<div class="col-auto" style="height:300px;width:300px;">
                                            <h5 class="mt-5">Take a Photo</h5>
                                            <button type="button" style="border:none; background: none;">
                                                <img id="openCam" src="{{ URL::asset('/assets/images/camera.png') }}" style="width: 140px; margin-right: 5px;" />
                                            </button>
                                            <p style="font-size:16px;" class="mt-1">Click on the camera above to take a picture</p>
                                        </div> --}}
                                    </div>

                                    <h6 id="fileNameDisplay" style="margin-top: 10px;"></h6>

                                   <!--  <div class="mb-3 mt-3">
                                        <button type="button" id="upload" style="background-color: #93186c; border-color: #93186c" class="btn btn-primary w-lg waves-effect waves-light">Upload</button>
                                    </div> -->

                                </div>



                                {{-- store Recaptcha token --}}
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                <div class="mt-5">



                                    <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Clear</button>
                                    <button type="submit" class="btn w-md text-white" id="personaldetails" style="float: right;background-color: #93186c; border-color: #93186c;">Next</button>

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

        $('#BankName').on('change', function() {

            var price = $(this).children('option:selected').data('price');
            $('#branchcode').val(price);

            var value = $(this).val();
            if (value === 'other') { // Change this condition based on which option should show the div
                $('#otherBank').show();
            } else {
                $('#otherBank').hide();
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            // Initialize select2
            //$("#BankName").select2();
        });
    </script>


    <!-- jQuery -->

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('fileInput');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            // Prevent default behaviors for drag events
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = 'blue';
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = '#ccc';
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = '#ccc';

                // Handle the dropped files
                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    // Show the name of the first file
                    fileNameDisplay.textContent = files[0].name;
                } else {
                    fileNameDisplay.textContent = '';
                }
            }

            // Trigger file input when drop zone is clicked
            dropZone.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle file input change event
            fileInput.addEventListener('change', function() {
                const files = fileInput.files;
                handleFiles(files);
            });
        });
    </script>



    @endsection
