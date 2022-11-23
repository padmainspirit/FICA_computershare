<!doctype html>
@extends('layouts.master-without-nav')
<html lang="en">

@section('css')
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
            background-color: #1a4f6e;
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

        /*# sourceMappingURL=style.css.map */
    </style>
@endsection

{{-- Recaptcha --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{!! RecaptchaV3::initJs() !!}
<script src="https://www.google.com/recaptcha/api.js?render=6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s"></script>

@section('body')

    <body style="background-color: rgb(235, 235, 235)">

    @section('content')
    
        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset($Logo) }}"  style="max-width: 200px; max-height: 200px;" alt="" class="img-fluid">
        </div>

        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card overflow-hidden">
                            <div style="background-image: linear-gradient(#93186c, #93186c);">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Reset Password</h5>
                                            <p class="text-white">Enter your Email and new Login credentials.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">

                                <div class="p-2">
                                    {{-- <div class="alert alert-success text-center mb-4" role="alert">
                                        Enter your Email and new Login credentials
                                    </div> --}}

                                    {{-- @if ($message == 'No registered user found.')
                                        <div class="alert alert-danger text-center mb-4" role="alert">
                                            {{ Session::get('message') }}
                                            No registered user was found.
                                        </div>
                                    @elseif ($message == 'Password has been successfully changed.')
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{ Session::get('message') }}
                                            Password has been successfully changed.
                                        </div>
                                    @elseif ($message == 'Please contact Administrator')
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{ Session::get('message') }}
                                            Please contact Administrator
                                        </div>
                                    @endif --}}

                                    @if (Session::get('fail'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('fail') }}
                                        </div>
                                    @endif
                                    
                                    @if (Session::get('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('reset.password.post') }}" method="post" id="reset-form">
                                        @csrf

                                        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

                                        {{-- <div class="mb-3">
                                            <label for="Email" style="width:100%" class="form-label">Email</label>
                                            <input type="Email" name="Email" id="Email"
                                                placeholder="Enter a valid Email" class="form-control" />
                                            <span class="error-message"></span>
                                        </div> --}}

                                        <div class="mb-3">
                                            <label for="email">Email: <span class="required">*</span></label>
                                            <input type="email" name="Email"  value="{{$ForgetEmail}}" id="Email"
                                                placeholder="Your email" class="form-control" required="required" readonly/>
                                            <span class="error-message"></span>
                                        </div>

                                        {{-- <div class="mb-3">

                                            <label for="Password" class="form-label">Password</label>
                                            <input type="Password" class="form-control" name="Password" id="Password"
                                                placeholder="Enter Password" required>
                                            <div class="invalid-feedback">
                                                Please Enter a Password
                                            </div>

                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" id="Password_confirmation"
                                                name="Password_confirmation" name="Password_confirmation"
                                                placeholder="Enter Confirm password" autofocus required>
                                            </input> --}}

                                        {{-- <span id="checkif" class="mt-2" style="font-size: 14px; color: #cb4154;">Password doesn't match</span> --}}

                                </div>

                                {{-- <div class="mb-3">

                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Re-Enter Password" required>
                                    <div class="invalid-feedback">
                                        Please Enter The Password Again
                                    </div>
    
                                </div> --}}

                                <!--password field-->
                                <div class="mb-3" style="margin-left: 2%;">
                                    <label for="passkey">Password: <span class="required">*</span></label>
                                    <div class="mb-3">
                                        <input type="password" style="width:100%" name="Password" id="Password"
                                            class="form-control" placeholder="Password" required="required" />
                                        <span class="passkey-icon" data-display-passkey="off"><i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <span class="error-messg"></span>
                                </div>


                                <!--Criteria match check-->

                                <div id="popover-password">
                                    <p><span id="result"></span></p>
                                    <div class="progress">
                                        <div id="password-strength" class="progress-bar" role="progressbar"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                        </div>
                                    </div>
                                    <br>
                                    <p style="color:#1a4f6e;">Your password must contain:</p>
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
                                    <label for="confirm-passkey">Confirm password: <span class="required">*</span></label>
                                    <div class="mb-3">
                                        <input type="password" style="width:100%" name="confirm-passkey"
                                            class="form-control" id="confirm-passkey" placeholder="Re-enter password"
                                            required="required" />
                                        <span class="passkey-icon" data-display-passkey="off"><i
                                                class="fas fa-eye"></i></span>
                                    </div>
                                    <span class="error-messg"></span>
                                </div>

                                {{-- store Recaptcha token --}}
                                <input type="hidden" name="g-recaptcha-response-reset" id="g-recaptcha-response-reset">

                                <div class="mt-3 text-center">

                                    <button type="button" class="btn w-md text-white" id="reset-btn"
                                        style="background-color: #1a4f6e; border-color: #1a4f6e;">Confirm</button>

                                </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p>Remember It ? <a href="{{ route('login', ['customer' => $customerName]) }}"
                                            class="fw-medium text-primary">Sign In here</a>
                                    </p>
                                    <p>© {{$customerName}}
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
        </div>
    @endsection
</body>
@endsection

@section('script')
<script>
    document.getElementById("reset-btn").addEventListener('click', () => {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s', {
                action: 'register'
            }).then(function(token) {
                console.log(token)
                document.getElementById("g-recaptcha-response-reset").value = token;
                // $('g-recaptcha-response').val(token);
                document.getElementById("reset-form").submit();
            });
        });
    }).click();
</script>

<script>
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

{{-- Password strength check and progress bar --}}

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

</html>
