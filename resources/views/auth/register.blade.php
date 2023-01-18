@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Register')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <style>
        .hidden {
            display: none;
        }

        .icon {
            width: 24px;
            height: 24px;
            position: absolute;
            top: 32px;
            right: 5px;
            pointer-events: none;
            z-index: 2;

            &.icon-success {
                fill: green;
            }

            &.icon-error {
                fill: red;
            }
        }

        .label {
            font-weight: normal;
            display: block;
            color: #333;
            //margin-bottom: .25rem;
            color: #2d3748;

        }

        .input {
            appearance: none;
            display: block;
            width: 100%;
            height: 75%;
            color: #2d3748;
            border: 1px solid #cbd5e0;
            line-height: 0.25;
            line-spacing: 0.25px;
            background-color: white;
            padding: .45rem .55rem;
            border-radius: 0.25rem;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);

            &::placeholder {
                color: #a0aec0;
            }

            &.input-error {
                border: 1px solid red;

                &:focus {
                    border: 1px solid red;
                }
            }

            &:focus {
                outline: none;
                border: 1px solid #a0aec0;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                background-clip: padding-box;
            }
        }

        .mb-3 {
            margin-bottom: 1rem;
            position: relative;

        }

        .error-message {
            font-size: .85rem;
            color: red;
        }

        .button {
            background-color: #93186c;
            padding: 1rem 2rem;
            border: none;
            border-radius: .25rem;
            color: white;
            font-weight: bold;
            display: block;
            width: 100%;
            text-align: center;
            cursor: pointer;

            &:hover {
                filter: brightness(110%);
            }
        }

        a {
            color: white;
        }

        .form-container {
            width: 100%;
            margin: 10px auto;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
        }

        .flex {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: space-evenly;
            -ms-flex-pack: space-evenly;
            justify-content: space-evenly;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .flex-item {
            width: 40%;
            height: 100%;
        }

        label {
            display: block;
            font-size: 13px;
        }

        .field-container {
            padding: 5px 10px;
            margin: 10px 0 10px;
        }

        .required {
            color: red;
            font-size: 1.1em;
        }

        .field-container>input,
        .passkey-box>input {
            width: 100%;
            display: inline-block;
            padding: 7px 15px;
            font-size: 18px;
            margin: 5px 0 3px;
            border-radius: 3px;
            outline: none;
            border: none;
            border-bottom: 2px solid black;
        }

        .passkey-box {
            position: relative;
        }

        .passkey-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            font-size: 1.2em;
        }

        .field-container>input:focus,
        .passkey-box>input:focus {
            border-bottom: 2px solid dodgerBlue;
        }

        .error-messg,
        .error-mess,
        .error-m3,
        .error-m4 {
            display: block;
            color: red;
            font-weight: 300;
        }

        .center {
            text-align: center;
        }

        input[type='submit'] {
            padding: 10px 30px;
            font-size: 1.2em;
            background: dodgerBlue;
            border: 1px solid white;
            outline: none;
            color: white;
            border-radius: 3px;
        }

        @media screen and (max-width: 576px) {
            .wrapper {
                width: 100%;
                padding: 100px 10px 30px;
                border-radius: 0;
            }

            h1 {
                margin-top: 50px;
            }

            .flex {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
            }

            .flex-item {
                width: 100%;
            }
        }

        @media screen and (min-width: 576px) {
            .wrapper {
                width: 80%;
                padding: 100px 10px 30px;
                border-radius: 0;
            }

            .flex {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
            }

            .flex-item {
                width: 100%;
            }
        }

        @media screen and (min-width: 662px) {
            .wrapper {
                width: 70%;
                padding: 100px 10px 30px;
                border-radius: 0;
            }

            .flex-item {
                width: 90%;
                height: 100%;
            }
        }

        @media screen and (min-width: 768px) {
            .wrapper {
                width: 80%;
                padding: 30px 10px;
                border-radius: 0;
            }

            .flex {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -ms-flex-direction: row;
                flex-direction: row;
            }

            .flex-item {
                width: 40%;
                height: 100%;
            }
        }

        @media screen and (min-width: 992px) {
            .wrapper {
                max-width: 876px;
                padding: 30px 10px;
                border-radius: 0;
            }
        }

        .fa-check {
            color: #02b502;
        }
    </style>
@endsection

{{-- Recaptcha --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{!! RecaptchaV3::initJs() !!}
<script src="https://www.google.com/recaptcha/api.js?render=6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s"></script>

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset($customer->Client_Logo) }}" style="max-width: 200px; max-height: 200px;" alt=""
                class="img-fluid">
        </div>

        {{-- @if ($customerName == 'ComputerShare')
            <div class="row d-flex justify-content-center mb-3 mt-5">
                <img src="{{ URL::asset('/assets/images/computershare.png') }}" style="width: 190px; height: 35px;"
                    alt="" class="img-fluid">
            </div>
        @elseif($customerName == 'Vodacom')
            <div class="row d-flex justify-content-center mb-3 mt-5">
                <img src="{{ URL::asset('/assets/images/vodacom-logo.png') }}" style="width: 190px;" alt=""
                    class="img-fluid">
            </div>
        @endif --}}

        <div class="account-pages">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-5">

                        <div class="card overflow-hidden">
                            <div style="background-image: linear-gradient(#93186c, #93186c);">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Registration</h5>
                                            <p>To Continue, Please register</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--form container-->
                            <form method="POST" class="form-horizontal"
                                action="{{ route('register', ['customer' => $customer->RegistrationName]) }}"
                                id="register-form">
                                <div class="card-body pt-0">
                                    <div class="p-2">

                                        @if (Session::get('oldfail'))
                                            <div class="alert alert-danger">
                                                {{ Session::get('oldfail') }}
                                            </div>
                                        @endif

                                        @if ($message)
                                        <div class="alert alert-danger text-center mb-4" role="alert">
                                            {{$message}}
                                            {{-- The ID number is invalid or does not match surname. Please enter a valid ID number --}}
                                        </div>
                                        @endif

                                        @csrf

                                        <div class="mb-3">

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

                                        <div class="mb-3">

                                            <label for="LastName">Last Name <span class="required">*</span></label>
                                            <input id="LastName" name="LastName" placeholder="Enter Last Name"
                                                type="text" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                value="{{ old('LastName') }}" required="required" />

                                            <span class="error-mess"></span>
                                            @error('LastName')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="mb-3">
                                            <label for="IDNumber">ID Number: <span class="required">*</span></label>
                                            <input type="tel" name="IDNumber" pattern=[0-9]{13} id="IDNumber"
                                                placeholder="ID Number" value="{{ old('IDNumber') }}" class="form-control"
                                                required="required" />
                                            <span class="error-m3"></span>
                                            @error('IDNumber')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>

                                        <!--email field-->
                                        <div class="mb-3">
                                            <label for="email">Email: <span class="required">*</span></label>
                                            <input type="email" name="Email" value="{{ old('Email') }}" id="Email"
                                                placeholder="Your email" class="form-control" required="required" />
                                            <span class="error-m4"></span>
                                            @error('Email')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="PhoneNumber">Phone Number: <span class="required">*</span></label>
                                            <input type="tel" name="PhoneNumber" value="{{ old('PhoneNumber') }}"
                                                pattern=[0-9]{10} id="PhoneNumber" class="form-control"
                                                placeholder="Phone Number" required="required" />
                                            <span class="error-messg"></span>
                                            @error('PhoneNumber')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>

                                        <!--password field-->
                                        <div class="mb-3">
                                            <label for="passkey">Password: <span class="required">*</span></label>
                                            <div class="mb-3">
                                                <input type="password" name="Password" id="Password" class="form-control"
                                                    placeholder="Password" required="required" />
                                                <span class="passkey-icon" data-display-passkey="off"><i
                                                        class="fas fa-eye"></i>
                                                </span>
                                            </div>
                                            <span class="error-messg"></span>
                                            @error('Password')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>

                                        <div id="popover-password">
                                            <p><span id="result"></span></p>
                                            <div class="progress">
                                                <div id="password-strength" class="progress-bar" role="progressbar"
                                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                    style="width:0%">
                                                </div>
                                            </div>
                                            <br>
                                            <p style="color:#93186c;">Your password must contain:</p>
                                            <ul class="list-unstyled">
                                                <li class="">
                                                    <span class="low-upper-case">
                                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                                        &nbsp;At least one Uppercase
                                                    </span>
                                                </li>
                                                <li class="">
                                                    <span class="one-number">
                                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                                        &nbsp;A number (0-9)
                                                    </span>
                                                </li>
                                                <li class="">
                                                    <span class="one-special-char">
                                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                                        &nbsp;Special Characters (!@#$%^&*)
                                                    </span>
                                                </li>
                                                <li class="">
                                                    <span class="eight-character">
                                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                                        &nbsp;At least 8 Characters
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--confirm password field-->
                                        <div class="mb-3">
                                            <label for="confirm-passkey">Confirm password: <span
                                                    class="required">*</span></label>
                                            <div class="mb-3">
                                                <input type="password" name="confirm-passkey" class="form-control"
                                                    id="confirm-passkey" placeholder="Re-enter password"
                                                    required="required" />
                                                <span class="passkey-icon" data-display-passkey="off"><i
                                                        class="fas fa-eye"></i></span>
                                            </div>
                                            <span class="error-messg"></span>
                                            @error('confirm-passkey')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                        <div class="mt-3 text-center">

                                            <button type="button" class="btn w-md text-white" id="register-btn"
                                                style="background-color: #93186c; border-color: #93186c;">Register</button>

                                            <button type="button" id="clearall" onClick="window.location.reload();"
                                                style="background-color: #93186c; border-color: #93186c"
                                                class="btn w-md text-white">Clear</button>

                                        </div>

                                    </div>
                                </div>

                                <div class="mt-2 text-center">
                                    <div>
                                        <p>Already have an account ? <a
                                                href="{{ route('login', ['customer' => $customer->RegistrationName]) }}"
                                                class="fw-medium text-primary">
                                                Login now </a> </p>
                                        <p style="font-size: 10px;">© {{ $customer->RegistrationName }}
                                            <script>
                                                document.write(new Date().getFullYear())
                                            </script>
                                            | Powered by Inspirit Data.
                                        </p>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

        {{-- <script>
            function myFunction() {
                alert("Thank you for registering. Please to your email for your login details");
            }
            </script> --}}

        <script>
            document.getElementById("register-btn").addEventListener('click', () => {
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s', {
                        action: 'register'
                    }).then(function(token) {
                        console.log(token)
                        document.getElementById("g-recaptcha-response").value = token;
                        // $('g-recaptcha-response').val(token);
                        document.getElementById("register-form").submit();
                    });
                });
            }).click();
        </script>

        <script>
            //First name validation
            document.querySelector('#FirstName').addEventListener('blur', (event) => {
                let err = document.querySelector(".error-messg");
                err.innerText = "";
                try {
                    //if field empty
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (event.target.validity.patternMismatch) {
                        //event.target.setCustomValidity("Enter A valid name");
                        throw "Please enter a valid name!";
                    } else {
                        event.target.style.borderBottom = "2px solid lime";
                        err.innerText = "";
                    }
                } catch (messg) {
                    err.innerText = messg;
                }

            });

            //Last name validation
            document.querySelector('#LastName').addEventListener('blur', (event) => {
                let err = document.querySelector(".error-mess");
                err.innerText = "";
                try {
                    //if field empty
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (event.target.validity.patternMismatch) {
                        //event.target.setCustomValidity("Enter A valid name");
                        throw "Please enter a valid name!";
                    } else {
                        event.target.style.borderBottom = "2px solid lime";
                        err.innerText = "";
                    }
                } catch (mess) {
                    err.innerText = mess;
                }

            });


            //to validate email
            document.querySelector('#Email').addEventListener('blur', (event) => {
                validateEmail(event);
            });



            //function for email and confirm email validation
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

            //validating ID number
            document.querySelector('#IDNumber').addEventListener('blur', function(event) {
                let error = event.target.nextElementSibling;
                error.innerText = "";
                try {
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (event.target.value.length != 13)
                        throw "Please enter a valid SA ID number that must be 13 digits.";

                    else
                        event.target.style.borderBottom = "2px solid lime";
                } catch (messg) {
                    error.innerText = messg;
                }
            });



            //validating contact number
            document.querySelector('#PhoneNumber').addEventListener('blur', function(event) {
                let error = event.target.nextElementSibling;
                error.innerText = "";
                try {
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (event.target.value.length != 10)
                        throw "Please enter 10 digit mobile number.";

                    else
                        event.target.style.borderBottom = "2px solid lime";
                } catch (messg) {
                    error.innerText = messg;
                }
            });


            //password show/hide functionality
            document.querySelector('.passkey-icon').addEventListener('click', displayPassword);
            document.querySelectorAll('.passkey-icon')[1].addEventListener('click', displayPassword);

            function displayPassword(event) {
                if (event.target.parentNode.getAttribute('data-display-passkey') == 'off') {
                    event.target.parentNode.setAttribute('data-display-passkey', 'on');
                    event.target.setAttribute('class', 'fas fa-eye-slash');
                    event.target.parentElement.previousSibling.previousSibling.setAttribute('type', 'text');
                    console.log(event.target.parentElement.previousSibling.previousSibling);
                } else {
                    event.target.parentNode.setAttribute('data-display-passkey', 'off');
                    event.target.setAttribute('class', 'fas fa-eye');
                    event.target.parentElement.previousSibling.previousSibling.setAttribute('type', 'password');
                }
            }


            //adding to password field
            document.querySelector("#Password").addEventListener('blur', validatePassword);

            //password validation
            function validatePassword(event) {
                let error = event.target.parentElement.nextElementSibling;
                error.innerText = "";
                try {
                    console.log((event.target.value));
                    console.log();
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (!(/[0-9]{1,}/g).test(event.target.value)) {
                        //throw "There must be at least 1 number in your password";
                        throw " ";
                    } else if (event.target.value.length < 8 || event.target.value.length > 100) {

                        //throw "Password length must be (8 or more) characters.";
                        throw " ";

                    } else if (!(/[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?]+/).test(event.target.value)) {

                        //throw "There must be at least 1 special character in your password";
                        throw " ";

                    } else if (!(/[^[A-Za-z.\s_-]+$]+/).test(event.target.value)) {

                        //throw "There must be at least 1 uppercase and 1 lowercase character in your password";
                        throw " ";

                    } else {
                        document.querySelector('[type="button"]').removeAttribute('disabled');
                        event.target.style.borderBottom = "2px solid lime";
                    }

                } catch (messg) {
                    document.querySelector('[type="button"]').setAttribute('disabled', "disabled");
                    error.innerText = messg;
                }
                console.log(error);
            }



            //confirm password validation
            document.querySelector('#confirm-passkey').addEventListener('blur', function(event) {
                try {
                    var error = document.querySelectorAll('.error-messg');
                    error.innerText = "";
                    if (event.target.validity.valueMissing)
                        throw event.target.validationMessage;

                    else if (document.querySelector('#Password').value != event.target.value) {
                        throw "Password not matched!";
                    } else {
                        document.querySelector('[type="button"]').removeAttribute('disabled');
                        event.target.style.borderBottom = "2px solid lime";
                    }
                } catch (messg) {
                    document.querySelector('[type="button"]').setAttribute('disabled', "disabled");
                    error.innerText = messg;
                }
            });

            {{-- <script>
                $(document).ready(function(){
                
                        var str = $("#Password").val();
                        alert(str);
                });
                </script> --}}
        </script>

        <script>
            let state = false;
            let password = document.getElementById("Password");
            let passwordStrength = document.getElementById("password-strength");
            let lowUpperCase = document.querySelector(".low-upper-case i");
            let number = document.querySelector(".one-number i");
            let specialChar = document.querySelector(".one-special-char i");
            let eightChar = document.querySelector(".eight-character i");

            password.addEventListener("keyup", function() {
                let pass = document.getElementById("Password").value;
                checkStrength(pass);
            });

            function toggle() {
                if (state) {
                    document.getElementById("Password").setAttribute("type", "Password");
                    state = false;
                } else {
                    document.getElementById("Password").setAttribute("type", "text")
                    state = true;
                }
            }

            function checkStrength(Password) {
                let strength = 0;

                //If password contains both lower and uppercase characters
                if (Password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                    strength += 1;
                    lowUpperCase.classList.remove('fa-circle');
                    lowUpperCase.classList.add('fa-check');
                } else {
                    lowUpperCase.classList.add('fa-circle');
                    lowUpperCase.classList.remove('fa-check');
                }
                //If it has numbers and characters
                if (Password.match(/([0-9])/)) {
                    strength += 1;
                    number.classList.remove('fa-circle');
                    number.classList.add('fa-check');
                } else {
                    number.classList.add('fa-circle');
                    number.classList.remove('fa-check');
                }
                //If it has one special character
                if (Password.match(/([!,#,%,&,@,$,^,*,?,_,~])/)) {
                    strength += 1;
                    specialChar.classList.remove('fa-circle');
                    specialChar.classList.add('fa-check');
                } else {
                    specialChar.classList.add('fa-circle');
                    specialChar.classList.remove('fa-check');
                }
                //If password is greater than 7
                if (Password.length > 7) {
                    strength += 1;
                    eightChar.classList.remove('fa-circle');
                    eightChar.classList.add('fa-check');
                } else {
                    eightChar.classList.add('fa-circle');
                    eightChar.classList.remove('fa-check');
                }

                // If value is less than 2
                if (strength < 2) {
                    passwordStrength.classList.remove('progress-bar-warning');
                    passwordStrength.classList.remove('progress-bar-success');
                    passwordStrength.classList.add('progress-bar-danger');
                    passwordStrength.style = 'width: 10%';
                } else if (strength == 3) {
                    passwordStrength.classList.remove('progress-bar-success');
                    passwordStrength.classList.remove('progress-bar-danger');
                    passwordStrength.classList.add('progress-bar-warning');
                    passwordStrength.style = 'width: 60%';
                } else if (strength == 4) {
                    passwordStrength.classList.remove('progress-bar-warning');
                    passwordStrength.classList.remove('progress-bar-danger');
                    passwordStrength.classList.add('progress-bar-success');
                    passwordStrength.style = 'width: 100%';
                }
            }
        </script>
    @endsection
