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




                                <form method="post" action="{{ route('sbEmailorPhone') }}" id="sb-tnc-form">
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


                                                <h5 style="color:red;">Sorry, we are unable to detect a camera on this device</h5>

                                                <p class="font-size-16">Please Select an alternative device with a camera</p>


                                        <div class="form-group row">

                                            <div class="col-lg-12">
                                                <div class="row justify-content-center align-items-center">

                                                    {{-- <p style="color: #000000;">{{ $exception }}</p> --}}
                                                    <form method="post" action="{{ route('sbEmailorPhone') }}" id="">
                                                    <div class="col-md-6">
                                                        <div class="mb-3 justify-content-center align-items-center;">
                                                           {{-- <div class="form-check form-check-inline font-size-16">
                                                                <input class="form-check-input" checked type="radio" id="emailOption" name="option" value="Email">
                                                                <label class="form-check-label" for="emailOption">Email</label>
                                                            </div>--}}
                                                            <div class="form-check form-check-inline font-size-16">
                                                                <input class="form-check-input" checked type="radio" id="smsOption" name="option" value="SMS">
                                                                <label class="form-check-label" for="smsOption">SMS</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3 font-size-16">


                                                                   {{-- <input autocomplete="off" type="text" class="form-control input-sm" style="border-radius: 15px;" id="emailInput" name="email" placeholder="Enter Email Address" value="">--}}
                                                                    <input autocomplete="off" type="text" class="form-control input-sm" style="border-radius: 15px;" id="smsInput" name="phone" placeholder="Enter Cellphone Number" value="{{$phoneNumber}}">

                                                                <span class="error-messg"></span>
                                                                @error('email')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                                @error('phone')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                                <div class="text-center d-flex justify-content-center align-items-center mt-2">
                                                    <button id="capture" type="submit" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Send Link</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="text-center d-flex justify-content-center align-items-center">
                                        <div>
                                            <video style="display: none; height: 400px; width: 400px;" id="video" autoplay></video>

                                            <div style="height: 400px; width: 400px; display: none;" id="capturedPhoto"></div>
                                        </div>
                                    </div>
                                    <div class="text-center d-flex justify-content-center align-items-center">
                                    <button id="capture" type="submit" style="display: none; background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Capture Photo</button>
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




    @endsection
