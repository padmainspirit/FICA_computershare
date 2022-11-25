<!doctype html>
@extends('layouts.master-without-nav')
<html lang="en">

@section('css')
    <style>
        .messg {
            font-size: .85rem;
            color: red;
        }
    </style>
@endsection

{{-- Recaptcha --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{!! RecaptchaV3::initJs() !!}
<script src="https://www.google.com/recaptcha/api.js?render=6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s"></script>

@section('body')

    <body style="background-color: rgb(230, 230, 230)">


    @section('content')
        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset($customer->Client_Logo) }}" style="max-width: 300px; max-height: 300px;" alt="" class="img-fluid">
        </div>

        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">

                            <div style="background-image: linear-gradient(#0e425b, #056895);">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Recover your login</h5>
                                            <p class="text-white">Enter your Email and a reset link will be sent to you.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">

                                <form action="{{ route('forget.password.post') }}" method="post" id="forget-form">
                                    @csrf
                                    <div class="p-2 mt-2">
                                        {{-- <div class="alert alert-success text-center mb-4" role="alert">
                                                Enter your Email and a reset link will be sent to you.
                                            </div> --}}

                                        @if ($message == 'No registered user found.')
                                            <div class="alert alert-danger text-center mb-4" role="alert">
                                                {{-- {{ Session::get('message') }} --}}
                                                No registered user was found.
                                            </div>
                                        @elseif ($message == 'We have e-mailed your password reset link.')
                                            <div class="alert alert-success text-center mb-4" role="alert">
                                                {{-- {{ Session::get('message') }} --}}
                                                We have e-mailed your password reset link.
                                            </div>
                                        @elseif ($message == 'Please contact Administrator')
                                            <div class="alert alert-success text-center mb-4" role="alert">
                                                {{-- {{ Session::get('message') }} --}}
                                                Please contact Administrator
                                            </div>
                                        @endif

                                        <div class="mb-3 text-center">
                                            <input type="Email" name="Email" id="Email"
                                                placeholder="Enter a valid Email" class="form-control" />
                                            <span class="messg"></span>
                                            @error('Email')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="mb-3">
                                            <label for="email">Email: <span class="required">*</span></label>
                                            <input type="email" name="Email" value="{{ old('Email') }}" id="Email"
                                                placeholder="Your email" class="form-control" required="required" />
                                            <span class="error-m4"></span>
                                        </div> --}}


                                        {{-- <button type="submit" class="btn btn-primary">
                                                 Password Reset Link
                                            </button> --}}

                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response-forget"
                                            id="g-recaptcha-response-forget">

                                        <div class="mt-3 text-center">

                                            <button type="button" class="btn w-md text-white" id="forget-btn"
                                                style="background-color: #1a4f6e; border-color: #1a4f6e;">Send</button>

                                            <button type="button" id="clearall"
                                                onClick="document.getElementById('Email').value = ''"
                                                style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                class="btn w-md text-white">Clear</button>

                                        </div>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p>Remember It? <a href="{{ route('login', ['customer' => $customer->RegistrationName]) }}"
                                        class="fw-medium text-primary">Sign In here</a>
                                    </p>

                                    <p>© {{ $customer->RegistrationName }}
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script>
                                        | Powered by Inspirit Data.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>
@endsection
@section('script')
<script>
    document.getElementById("forget-btn").addEventListener('click', () => {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s', {
                action: 'register'
            }).then(function(token) {
                console.log(token)
                document.getElementById("g-recaptcha-response-forget").value = token;
                // $('g-recaptcha-response').val(token);
                document.getElementById("forget-form").submit();
            });
        });
    }).click();
</script>

<script>
    //to validate email
    document.querySelector('#Email').addEventListener('blur', (event) => {
        validateEmail(event);
    });

    //function to check email and confirm email validation
    function validateEmail(event) {
        let error = event.target.nextElementSibling;
        error.innerText = "";
        try {

            if (event.target.validity.valueMissing)
                throw event.target.validationMessage;

            else if ((!event.target.validity.valid || event.target.value.slice(-4) != '.com') && (!event.target.validity
                    .valid || event.target.value.slice(-6) != '.co.za' && (!event.target.validity.valid || event.target
                        .value.slice(-6) != '.org')))
                throw "Please enter a valid email.";

            else
                event.target.style.borderBottom = '2px solid lime';

        } catch (messg) {
            error.innerText = messg;
        }

    }
</script>
@endsection

</html>
