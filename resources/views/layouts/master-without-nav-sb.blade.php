<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="icon" href="{{ URL::asset('assets/images/logo.ico') }}">
    @include('layouts.head-css')
</head>


<style>
/* Default for small screens */
.responsive-logo {
    max-width: 50%;
    height: auto;
}

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) {
    .responsive-logo {
        max-width: 50%;
    }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
    .responsive-logo {
        max-width: 33%;
    }
}

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {
    .responsive-logo {
        max-width: 25%;
    }
}

   .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 20px;
}
.big-checkbox:checked {
        background-color: #91C60F;
        border: #91C60F;
    }
h3 ,h4
{
    font-weight: bold;
}
.step img {
    margin-bottom: 5px;
}

.text-center {
    width: 100%;
}
.otp-input-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1px; /* Space between the inputs */
    justify-content: center; /* Center the inputs horizontally */
}

.otp-input {
    flex: 1 1 30px; /* Flex-grow, flex-shrink, and minimum width */
    max-width: 25px; /* Maximum width for larger screens */
    height: 35px; /* Consistent height for inputs */
    text-align: center; /* Center the text inside the input */
    font-size: 12px; /* Make text larger */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
}

@media (max-width: 600px) {
    .otp-input {
        flex: 1 1 25px; /* Adjust the size for smaller screens */
        max-width: 25px;
        height: 25px;
        font-size: 12px;
    }
}

.otp-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #999999;
}

.otp-input::-moz-placeholder { /* Firefox 19+ */
    color: #999999;
}

.otp-input:-ms-input-placeholder { /* IE 10+ */
    color: #999999;
}

.otp-input::-ms-input-placeholder { /* Edge */
    color: #999999;
}

.otp-input::placeholder { /* Modern browsers */
    color: #999999;
}

@media (max-width: 576px) {
    .form-group .col-12.col-md-10 {
        font-size: 16px; /* Smaller font for mobile */
        padding: 15px; /* Reduce padding for mobile */
    }
    .form-group .alert p {
        font-size: 14px; /* Reduce font size inside the alert */
    }

}

</style>

@yield('body')




@yield('content')

@include('layouts.vendor-scripts')

@guest
@if(session()->has('sbid'))
@include('layouts.session-script')
@endif
@endguest

</body>

</html>
