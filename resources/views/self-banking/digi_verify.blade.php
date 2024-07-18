@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Login')
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


                                <form method="post" action="{{ route('agree-selfbanking-tnc') }}" id="sb-tnc-form">
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

                                        <div id="" class="mt-4 text-center">

                                            <img id="openCam" src="{{ URL::asset('/assets/images/camera.png') }}" style="cursor:pointer;width:140px; margin-right:5px;" />
                                            <input type="file" id="cameraInput" accept="image/*" capture="camera" style="display:none;">

                                                <p id="info">Click on the camera icon above to start with your ID Verification process</p>
                                            </div>
                                    </div>
                                    <div class="text-center d-flex justify-content-center align-items-center">
                                        <div>
                                            <video style="display: none; height: 400px; width: 400px;" id="video" autoplay></video>

                                            <div style="height: 400px; width: 400px; display: none;" id="capturedPhoto"></div>
                                        </div>
                                    </div>
                                    <div class="text-center d-flex justify-content-center align-items-center">
                                    <button id="capture" style="display: none; background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Capture Photo</button>
                                    </div>


                                      {{-- store Recaptcha token --}}
                                      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                      <div class="mt-3">



                                          <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c"
                                              class="btn w-md text-white">Back</button>


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
    const openCameraButton = document.getElementById('openCam');
    const video = document.getElementById('video');
    const captureButton = document.getElementById('capture');
    const capturedPhotoDiv = document.getElementById('capturedPhoto');
    const ptag = document.getElementById('info');

    openCameraButton.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = 'block'; // Show the video element
            captureButton.style.display = 'block'; // Show the capture button
            openCameraButton.style.display = 'none';
            ptag.style.display = 'none';
        } catch (err) {
            console.error('Error accessing the camera: ', err);
        }
    });

    captureButton.addEventListener('click', () => {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop the video stream
        const stream = video.srcObject;
        const tracks = stream.getTracks();
        tracks.forEach(track => track.stop());
        video.srcObject = null;

        // Show the captured photo
        const img = document.createElement('img');
        img.src = canvas.toDataURL('image/png');
        capturedPhotoDiv.innerHTML = ''; // Clear previous images
        capturedPhotoDiv.appendChild(img);

        // Hide the video and capture button after capturing
        video.style.display = 'none';
        captureButton.style.display = 'none';
    });
</script>

    @endsection
