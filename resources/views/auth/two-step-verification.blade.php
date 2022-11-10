@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Two_step_verification')
@endsection

@section('body')

    <body style="background-color: rgb(230, 230, 230)">
    @endsection

    @section('content')
        {{-- <div class="row d-flex justify-content-center mb-3 mt-4">
        <img src="{{ URL::asset($customer->Client_Logo) }}" style="width: 190px; height: 35px;" alt="" class="img-fluid">
    </div> --}}

        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset($customer->Client_Logo) }}"  style="max-width: 300px; max-height: 300px;" alt="" class="img-fluid">
        </div>

        <div class="account-pages">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- <div class="text-center mb-5 text-muted">
                        <a href="index" class="d-block auth-logo">
                            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="20"
                                class="auth-logo-dark mx-auto">
                            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="20"
                                class="auth-logo-light mx-auto">
                        </a>
                        <p class="mt-3">Responsive Bootstrap 5 Admin Dashboard</p>
                    </div> --}}
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card overflow-hidden">
                            <div style="background-image: linear-gradient(#0e425b, #056895);">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Two-Factor Authentication</h5>
                                            <p>To Continue, please type the OTP sent to you.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="text-center">
                                    <div class="p-2 mt-4">

                                        <h4>Two Factor Authentication</h4>
                                        <p class="mb-5">Please enter the 6 digit code sent to your Phone or Email address.
                                        </p>

                                        <form method="POST" action="{{ route('otp') }}" enctype="multipart/form-data">

                                            @csrf

                                            {{-- <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit1" class="visually-hidden">Digit 1</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit1-input" name="digit1-input" maxLength="1">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit2" class="visually-hidden">Digit 2</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit2-input" name="digit2-input" maxLength="1">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit3" class="visually-hidden">Digit 3</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit3-input" name="digit3-input" maxLength="1">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit4" class="visually-hidden">Digit 4</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit4-input" name="digit4-input" maxLength="1">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit4" class="visually-hidden">Digit 5</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit5-input" name="digit5-input" maxLength="1">
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit4" class="visually-hidden">Digit 6</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="digit6-input" name="digit6-input" maxLength="1">
                                                    </div>
                                                </div>
                                            </div> --}}
                                            
                                            @if (Session::get('fail'))
                                                <div class="alert alert-danger" role="alert">
                                                    {{ Session::get('fail') }}
                                                </div>
                                            @endif

                                            <div class="row justify-content-center">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="digit1" class="visually-hidden">Digit 1</label>
                                                        <input type="text"
                                                            style="padding-top: 0%;padding-bottom: 0%;padding-left: 0%;padding-right: 0%;"
                                                            class="form-control form-control-lg text-center two-step"
                                                            id="otp-input" name="otp-input" maxLength="6">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 text-center">

                                                <button type="submit" class="btn w-md text-white"
                                                    style="background-color: #1a4f6e; border-color: #1a4f6e;">Confirm</button>

                                            </div>

                                        </form>

                                        <div class="mt-5 text-center">
                                            <form action="{{ route('resendOTP') }}" method="POST">
                                                @csrf
                                                <div>
                                                    <p>Have not received message? <span><button type="submit"
                                                                style="color: blue;  background: none; border: none;">Resend
                                                            </button></span></p>
                                                    <p>© {{$customer->RegistrationName}}
                                                        <script>
                                                            document.write(new Date().getFullYear())
                                                        </script>
                                                        | Powered by Inspirit Data.
                                                    </p>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="mt-5 text-center">
                            <p>Did't receive a code ? <a href="#" class="fw-medium text-primary"> Resend </a> </p>
                            <p>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                                Themesbrand
                            </p>
                        </div> --}}
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <!-- two-step-verification js -->
        <script src="{{ URL::asset('/assets/js/pages/two-step-verification.init.js') }}" type="text/javascript"></script>
    @endsection
