@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.sb_digi_verify')
@endsection


@section('body')

<body style="background-color: rgb(230, 230, 230)">
    @endsection

    @section('content')

    <div class="container">
        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset('assets/images/logo/computershare.png') }}" class="img-fluid responsive-logo" alt="Computershare Logo">
        </div>
    </div>
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-md-10 mt-4">
                    <div class="container mt-4">
                        <div class="container mt-4" style="position: relative; width:85%; margin: auto;">
                            <img class="mb-2" src="{{ URL::asset('/assets/images/location-pin.png') }}"
                                 style="height:45px;width:45px; position: absolute; left: 50%; transform: translateX(-50%); top: -55px;">
                            <div class="progress mx-auto mb-4 mt-4" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 50%; background-color: #91C60F" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                                    <div class="container">
                                        <div class="row justify-content-between align-items-center">
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center mb-3">
                                            <img id="openCam" src="{{ URL::asset('/assets/images/octicon--info-16.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Welcome</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center mb-3">
                                            <img id="openCam2" src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Personal Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Digital ID Verification</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Banking Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="openCam3" src="{{ URL::asset('/assets/images/mdi--tick-circle-outline.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Finish</h5>
                                          </div>
                                        </div>
                                      </div>
                    <div class="card overflow-hidden">


                        <div style="background-image: linear-gradient(#93186c, #93186c);" class="text-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h4 class="text-white">Digital ID verification</h4>
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


                                <form method="post" action="{{ route('idvlink') }}" id="sb-tnc-form">

                                @csrf
                                    <div class="row">

                                        <div class="container mt-4">
                                            <div class="row">
                                              <div class="col-12 col-md-4 d-flex justify-content-center align-items-center mb-3">
                                                <img id="openCam" src="{{ URL::asset('/assets/images/1.jpg') }}" class="img-fluid" />
                                              </div>
                                              <div class="col-12 col-md-4 d-flex justify-content-center align-items-center mb-3">
                                                <img id="openCam2" src="{{ URL::asset('/assets/images/2.jpg') }}" class="img-fluid" />
                                              </div>
                                              <div class="col-12 col-md-4 d-flex justify-content-center align-items-center mb-3">
                                                <img id="openCam3" src="{{ URL::asset('/assets/images/3.jpg') }}" class="img-fluid" />
                                              </div>
                                            </div>
                                          </div>



                                        <div id="" class="mt-2 text-center">

                                            <button class="btn w-md text-white" style="background-color: #91C60F; border-color: #91C60F;" type="submit" style="">
                                                Proceed
                                                {{--<img id="openCam" src="{{ URL::asset('/assets/images/camera.png') }}" style="width: 240px; margin-right: 5px;" />--}}
                                            </button>
                                                {{--<p id="info">Click on the camera icon above to start with your ID Verification process</p>--}}
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

    </script>
    @endsection
