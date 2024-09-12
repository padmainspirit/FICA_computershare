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
    height:60px;
}
/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) {
    .responsive-logo {
        max-width: 50%;
        height:60px;
    }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
    .responsive-logo {
        max-width: 33%;
        height:70px;
    }
}

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {
    .responsive-logo {
        max-width: 25%;
        height:80px;
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
    flex-wrap: nowrap;
    gap: 5px; /* Space between the inputs */
    justify-content: center; /* Center the inputs horizontally */
}
@media (max-width: 600px) {
.otp-input-container {
    display: flex;
    flex-wrap: nowrap;
    gap: 2px; /* Space between the inputs */
    justify-content: center; /* Center the inputs horizontally */
}
}
.otp-input {
    flex: 1 1 20px; /* Flex-grow, flex-shrink, and minimum width */
    max-width: 25px; /* Maximum width for larger screens */
    height: 30px; /* Consistent height for inputs */
    text-align: center; /* Center the text inside the input */
    font-size: 12px; /* Make text larger */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
}

@media (max-width: 600px) {
    .otp-input {
        flex: 1 1 15px; /* Adjust the size for smaller screens */
        max-width: 20px;
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
.popover-container {
    position: relative;
    display: inline-block;
}

#popupDiv {
    display: none;
    position: absolute;
    background-color: #f0f0f0;
    color: #3b3939;
    font-weight: bold;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    white-space: normal;
    max-width: 100%;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 5px;
    overflow-y: auto;
}

#hoverText:hover + #popupDiv,
#hoverText:focus + #popupDiv {
    display: block;
}

#popupDiv ul {
    margin: 0;
    padding: 0;
    list-style-type: disc;
    padding-left: 20px;
}

#popupDiv li {
    margin-bottom: 10px;
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
