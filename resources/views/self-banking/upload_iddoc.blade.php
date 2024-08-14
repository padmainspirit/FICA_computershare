@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.Login')
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
    <img src="{{ URL::asset('/assets/images/location-pin.png') }}" style="height:45px;width:45px;">

    </div>
    <div class="step text-center">

    </div>
    <div class="step text-center">

    </div>
</div>
                <div class="progress mb-4 mt-3" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;background-color: green;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="card overflow-hidden">


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


                            <form method="post" action="" id="sb-tnc-form"  enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                        <div class="heading-fica-id mb-1">
                                            <div class="">
                                                <h4 class="font-size-18"
                                                    style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                                    Digital ID Verification
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <h5 class="mb-4" style="color: red;" id="info">We could not find/verify your picture.</h5>
                                            <p class="mb-4">We have not been able to verify your selfie. To finalize the verification
                                                , upload or take a photo of your South African ID Document or Smart ID Card. If using an ID Card, we require both sides.
                                                We will not accept blurry images, photocopies, or illegal information. Details of your ID document must
                                                be fully visible, clear, and east-to-read.
                                            </p>
                                            <div class="col-lg-3 mt-3">

<p title="If the shareholder is uploading an ID card, Take a clear photo of ID document"
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
                                                    <h5 class="mt-5">Take a Photo of your ID</h5>
                                                    <button type="button" style="border:none; background: none;" >
                                                        <img id="openCam" src="{{ URL::asset('/assets/images/camera.png') }}" style="width: 140px; margin-right: 5px;" />
                                                    </button>
                                                    <p style="font-size:16px;" class="mt-1">Click on the camera above to take a picture</p>
                                                </div>--}}
                                            </div>

                                            <h6 id="fileNameDisplay" style="margin-top: 10px;"></h6>

                                            <div class="mb-3 mt-3">
                                                <button type="submit" id="submit"
                                                    style="background-color: #93186c; border-color: #93186c"
                                                    class="btn btn-primary w-lg waves-effect waves-light">Upload</button>
                                            </div>

                                        </div>


                                    </div>



                                      {{-- store Recaptcha token --}}
                                      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">


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
