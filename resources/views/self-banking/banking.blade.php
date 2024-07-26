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
                                        Banking Details
                                    </h4>
                                </div>
                            </div>




                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="accnumber">Account Number <span style="color:red;" class="required">*</span></label>
                                            <input id="accnumber" name="accnumber" placeholder="Enter Your Bank Account Number"
                                                type="text" style="border-radius: 15px;" class="form-control"
                                                value="{{ old('accnumber') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('accnumber')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>

                                            <div class="col-sm-12">
                                                <label for="BankName">Bank Name <span style="color:red;" class="required">*</span></label>
                                                <select class="form-select" autocomplete="off"
                                                style="border-radius: 15px; "
                                                    id="BankName" name="BankName">
                                                    <option value="" disabled selected style="" >
                                                        --Select Bank--
                                                    </option>
                                                    <option value="absa">ABSA Bank</option>
                                                    <option value="capitec">Capitec Bank</option>
                                                    <option value="fnb">First National Bank (FNB)</option>
                                                    <option value="investec">Investec Bank</option>
                                                    <option value="nedbank">Nedbank</option>
                                                    <option value="standard_bank">Standard Bank</option>
                                                    <option value="tyme_bank">Tyme Bank</option>
                                                    <option value="other">Other</option>


                                                </select>

                                                <span class="error-messg"></span>
                                                @error('BankName')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror

                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="branchcode">Branch Code <span style="color:red;" class="required">*</span></label>
                                            <input id="branchcode" name="branchcode" placeholder="Branch Code"
                                                type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                value="{{ old('branchcode') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('branchcode')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>


                                    </div>

                                    <div class="mt-4 text-center" style="display:none;" id="otherBank">
                                        <h5 class="mb-4" style="color: red;" id="info">We could not find/verify your picture.</h5>
                                        <p class="mb-4">We have not been able to verify your selfie. To finalize the verification
                                            , upload or take a photo of your South African ID Document or Smart ID Card. If using an ID Card, we require both sides.
                                            We will not accept blurry images, photocopies, or illegal information. Details of your ID document must
                                            be fully visible, clear, and east-to-read.
                                        </p>

                                        <input type="file" id="fileInput" name="file" accept="image/*,.pdf" style="display: none;" onchange="handleFileSelect(event)">

                                        <div class="row justify-content-center mt-3">
                                            <div id="dropZone" class="col-auto" style="border:3px dotted black; height:300px;width:300px; border-radius:5px;">

                                                <h5 class="mt-5">Drag Files Here</h5>
                                                <button type="button" style="border:none; background: none;" onclick="document.getElementById('fileInput').click();">
                                                    <img src="{{ URL::asset('/assets/images/upload-big-arrow.png') }}" style="width: 80px; margin-right: 5px;" />
                                                </button>
                                                <p style="font-size:16px;" class="mt-3">or</p>
                                                <h5 class="mt-1">Browse Image/PDF Files</h5>
                                            </div>
                                            <div class="col-auto" style="height:300px;width:300px;">
                                                <h5 class="mt-5">Take a Photo of your ID</h5>
                                                <button type="button" style="border:none; background: none;" >
                                                    <img id="openCam" src="{{ URL::asset('/assets/images/camera.png') }}" style="width: 140px; margin-right: 5px;" />
                                                </button>
                                                <p style="font-size:16px;" class="mt-1">Click on the camera above to take a picture</p>
                                            </div>
                                        </div>

                                        <h6 id="fileNameDisplay" style="margin-top: 10px;"></h6>

                                        <div class="mb-3 mt-3">
                                            <button type="submit" id="submit"
                                                style="background-color: #93186c; border-color: #93186c"
                                                class="btn btn-primary w-lg waves-effect waves-light">Upload</button>
                                        </div>

                                    </div>



                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                        <div class="mt-5">



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
        $('#BankName').on('change', function() {
            var value = $(this).val();
            if (value === 'other') { // Change this condition based on which option should show the div
                $('#otherBank').show();
            } else {
                $('#otherBank').hide();
            }
        });
    </script>
    <script>
        $(document).ready(function(){

            // Initialize select2
            $("#BankName").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#BankName option:selected').text();
                var userid = $('#BankName').val();

                $('#result').html("id : " + userid + ", name : " + username);

            });
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
