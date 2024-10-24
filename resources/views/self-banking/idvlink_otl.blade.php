<?php

use Illuminate\Support\Facades\Session;
?>
@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.sb_requestotl')
@endsection

@section('css')
<style>
#alertSuccess,
#alertError{
        display: none;
}
</style>
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
                <div class="col-md-12 mt-4">
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
                            <div id="form-errors" ></div>

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif





                                    <div class="row justify-content-center mt-3">
                                        <div class="col-sm-6">
                                            <div style="display: flex; align-items: center;">
                                                <p class="font-size-16">Please select an option that is suitable for you to complete the facial recognition process.</p>
                                                 </div>

                                        </div>

                                                    {{-- <p style="color: #000000;">{{ $exception }}</p> --}}
                                                    <form method="post" action="{{ route('requestOTL') }}" id="">
                                                        @csrf
                                                        <div class="d-flex justify-content-center align-items-center" >
                                                            <div class="col-md-6 border border-primary rounded p-3 mx-auto">
                                                                <div class="mb-3">

                                                                    <!-- Browser option without input field -->
                                                                    <div class="row border-bottom mb-2">
                                                                        <div class="col-md-6 d-flex align-items-center align-items-center justify-content-end py-2 border-end">
                                                                            <label class="form-check-label me-2" for="browserOption">Browser</label>
                                                                            <input style="position: relative;display:flex; top:-3px;" class="form-check-input"  type="radio" id="browserOption" name="option" value="Browser" @if(old("option")=="Browser" || old("option") == null ) checked @endif>

                                                                        </div>
                                                                        <div class="col-md-6"></div> <!-- No input for Browser -->
                                                                    </div>

                                                                    <!-- Email option with input field -->
                                                                   {{-- <div class="row border-bottom mb-2">
                                                                        <div class="col-md-6 d-flex align-items-center align-items-center justify-content-end py-2 border-end">
                                                                            <label class="form-check-label" for="emailOption">Email</label>
                                                                            <input class="form-check-input me-2" type="radio" id="emailOption" name="option" value="Email" @if(old("option")=="Email" ) checked @endif>

                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input autocomplete="off" type="email" class="form-control input-sm" id="emailInput" name="emailinput" placeholder="Enter Email Address" value='{{old("emailinput", $emailVal)}}' @if(old("option")!="Email" ) style="display:none;" @endif>
                                                                        </div>
                                                                    </div>--}}

                                                                    <!-- SMS option with input field -->
                                                                    <div class="row border-bottom mb-2">
                                                                        <div class="col-md-6 d-flex align-items-center align-items-center justify-content-end py-2 border-end">

                                                                            <label class="form-check-label me-2" for="smsOption">SMS</label>
                                                                            <input style="position: relative;display:flex; top:-3px;" class="form-check-input" type="radio" id="smsOption" name="option" value="SMS" @if(old("option")=="SMS" ) checked @endif>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input autocomplete="off" type="text" class="form-control input-sm" id="smsInput" name="phoneinput" placeholder="Enter Cellphone Number" value='{{old("phoneinput", $phoneNumber)}}' @if(old("option")!="SMS" ) style="display:none;" @endif>
                                                                        </div>
                                                                    </div>

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

                                                        <!-- JavaScript to Toggle Visibility -->
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                //const emailOption = document.getElementById('emailOption');
                                                                const smsOption = document.getElementById('smsOption');
                                                                //const emailInput = document.getElementById('emailInput');
                                                                const smsInput = document.getElementById('smsInput');

                                                                // Show/Hide input based on selected option
                                                                function toggleInputFields() {
                                                                    /*if (emailOption.checked) {
                                                                        emailInput.style.display = 'block';
                                                                        smsInput.style.display = 'none';
                                                                    } */
                                                                    if (smsOption.checked) {
                                                                        smsInput.style.display = 'block';
                                                                        emailInput.style.display = 'none';
                                                                    } else {
                                                                        emailInput.style.display = 'none';
                                                                        smsInput.style.display = 'none';
                                                                    }
                                                                }

                                                                // Initialize the input visibility
                                                                toggleInputFields();

                                                                // Add event listeners to radio buttons
                                                               // emailOption.addEventListener('change', toggleInputFields);
                                                                smsOption.addEventListener('change', toggleInputFields);
                                                            });
                                                        </script>


                                                <div class="text-center d-flex justify-content-center align-items-center mt-2">
                                                    {{--<button id="sendLinkButton" type="submit" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Send Link</button>--}}


                                                    <button style="display:none;" type="button" class="btn btn-primary" id="btn-hidden-selfie"
                                                    data-bs-toggle="modal" data-bs-target="#composemodal-selfie">
                                                    Send Link
                                                </button>
                                                </div>








                                        <div class="text-center d-flex justify-content-center align-items-center mt-2">
                                            {{-- <a style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white" href="{{ url('banking') }}">Proceed</a>--}}
                                            </div>
                                    </div>




                                      {{-- store Recaptcha token --}}
                                      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                      <div class="mt-3">



                                          <button type="reset" id="clearall" onclick="window.location='{{ url("digital-verification") }}'" style="background-color: #93186c; border-color: #93186c"
                                              class="btn w-md text-white">Back</button>
                                              <button type="submit" name="submit" id="submit-facial"
                                              class="btn w-md text-white"
                                              style="float: right;background-color: #91C60F; border-color: #91C60F;">Next

                                          </button>
                                      </div>

                            </div>
                        </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    {{-- Selfie Popup Modal --}}
    <div class="modal fade" id="composemodal-selfie" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('sbgetselfieresult') }}" method="post" enctype="multipart/form-data"
                    id="getselfieResult">
                    @csrf
                    <div class="modal-body">
                        <br><br>
                        <div class="text-center mb-4">
                            <div id="facial-loading-dynamic">
                                <img src="{{ URL::asset('/assets/images/selfie.gif') }}" width="120px" />
                            </div>

                            <br><br>


                            <div class="row justify-content-center">
                                <br>

                                @if(Session::get('option')!='Browser')
                                <div class="col-xl-10" id="selfie-link-title">
                                    <h4 style="color: #000000">Identity verification link sent via SMS.
                                    </h4>
                                    <p style="color: #000000">
                                        Please select "Allow" option.
                                                           </p>
                                </div>
                                @endif
                                <div id="green-check" style="display: none;" class="text-center">
                                    <img src="{{ URL::asset('/assets/images/greencheck.png') }}" style="width:45px;">

                                </div>
                                <div id="alertSuccess" class="alert" role="alert">
                                    <br>
                                    <h4 id="seflie-text" style=""></h4>
                                </div>

                                <div id="alertError" class="alert alert-danger" role="alert">
                                    <br>
                                    <p id="seflie-text-error" style="color: rgb(182, 37, 37); font-size: 15px;"></p>
                                </div>

                                @if(Session::get('option')=='Browser')
                                <div id="facial-loading-dynamic">
                                <iframe src="demo_iframe.htm" id="iframe_url" name="iframe_a" height="300px" width="100%" title="Iframe Example"></iframe>
                                </div>
                                @endif


                                <hr id="line" style="display:none;color: #93186c ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #93186c; background-color: #93186c; opacity: 100%;">
                            </div>
                            <br>
                           <p id="thankyou" class="text-muted font-size-14 mb-4" style="display:none;color:#000000;margin-bottom: 3%;">Thank you, your ID has been verified, please click to continue
                            </p>
                        </div>

                        <div class="text-center mb-3">
                            {{-- <div id="save-and-cancel-declaration-btn" style="display: none"> --}}
                            <button type="submit" id="submitBtn" class="btn-primary text-center w-md "
                                style="width: 10%; ;margin-bottom: 3%;display:none">
                                Submit
                            </button>


                            <div class="row">
                                        <div class="col-12" style="text-align:center;">
                                        <button id="continue-btn" type="button" style="display:none;background-color: #91C60F; border-color: #91C60F;" class="btn btn-primary" onclick="window.location='{{ route("banking") }}'"
                                         >Continue</button>
                                        </div>
                                        <div class="col-12" style="text-align:center;">
                                            <p id="instruction" style="">
                                                Please follow the instructions on the "Link" recieved.
                                                                   </p>
                                                                   <h4 id="remaining">Time remaining : <span id="time">05:00</span></h4>
                                        <button style="display:none;" type="button" id="selfie-cancel" class="btn btn-primary mt-4"
                                data-bs-dismiss="modal">
                                OK
                            </button>
                            <button style="display:none;" onclick="redirecttocs()" type="button" id="selfie-cancel-url" class="btn btn-primary mt-4"
                            data-bs-dismiss="modal">
                            OK
                        </button>

                            </div>
                                    </div>



                            <button type="button" class="btn text-center w-md text-white" id="btn-Okay"
                                style="width: 10%;margin-bottom: 3%;display:none;"
                                data-bs-dismiss="modal">
                                OK
                            </button>

                            {{-- </div> --}}
                        </div>

                    </div>
                </form>
                <br><br><br>
            </div>
            {{-- </form> --}}
        </div>
    </div>






    <!-- end account-pages -->
    @endsection

    @section('script')


    <script type="text/javascript">

    </script>

{{-- take selfie --}}
<script type="text/javascript">
    $(document).ready(function() {
        // $('#submit-facial').on('click', function(e) {

        // });

        // $("#submit-facial").click(function() {
        //     $('#click-icon-facial').hide();
        //     $('#click-icon-static-facial').show();
        // });

        $("#composemodal-selfie").modal({
            backdrop: "static "
            , keyboard: false
        });
        $('#sb-tnc-form').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData(this);
            $.ajax({
                url: "{{ route('sbEmailorPhone') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // document.querySelector("#loader-selfie").style.visibility =
                    //     "visible";
                    $( '#form-errors' ).html('');
                    $('#loading-send-sms').show();
                    $('#click-icon-facial').hide();
                    $('#click-icon-static-facial').show();
                    //$('#submit-facial').hide();
                    $("#submit-facial").prop("disabled", true);
                    $('#selfie-upload-box').hide();
                }
                , complete: function() {
                    $('#loading-send-sms').hide();
                    $('#click-icon-facial').hide();
                    $('#click-icon-static-facial').show();
                    $('#submit-facial').show();
                    $("#submit-facial").prop("disabled", false);
                    $('#selfie-upload-box').show();
                    // document.querySelector("#loader-selfie").style.display = "none";
                }
                , success: function(response) {
                    startCountdown();
                    console.log(response);
                    $("#btn-hidden-selfie").click();
                    // $("#composemodal-selfie").modal({
                    //     backdrop: 'static',
                    //     keyboard: false,
                    //     show: true // added property here
                    // });
                    var i = 1;
                    var x = setInterval(function() {

                        var text = $('#seflie-text').html();
                        console.log(text);
                        console.log(i);
                        if (text !== 'Consumer') {
                            $("#submitBtn").click();

                            var text2 = $('#seflie-text').html();
                            if (text2 == 'Consumer') {
                                clearInterval(x);
                            }
                            if (i > 30) {
                               // $('#selfie-link-title').hide();
                                //$('#facial-loading-dynamic').hide();
                               // $('#facial-loading-static').show();
                                $('#seflie-text-error').text(
                                    'ID verification was not successful. Please click the "OK" button then click the "Next" button again to resend the link!'
                                );
                                $("#instruction").hide();
                                $("#selfie-continue").hide();
                               // $("#selfie-cancel").hide();
                                $("#alertError").show();
                                $("#seflie-text-error").show();
                                $("#selfie-cancel").show();
                               // $("#btn-Okay").show();
                                console.log(
                                    'ID verification was not successful. Please click the Next button again to resend the link!'
                                );
                                clearInterval(x);
                            }
                            i++;
                        }

                        if (text === 'Failed') {
                            clearInterval(x);
                            console.log('Photos does not match, IDV verification failed');
                            $('#thankyou').hide();
                            $('#line').show();
                            $("#time").hide();
                            $("#instruction").hide();
                            $("#remaining").hide();
                            $("#selfie-cancel-url").show();
                            $('#seflie-text-error').text(
                                    'Photos does not match, IDV verification failed'
                            );
                            $("#selfie-continue").hide();
                            $("#alertError").show();
                            $("#seflie-text-error").show();
                            /* $('#selfie-link-title').hide();
                            $('#thankyou').html('Photos does not match, IDV verification failed');
                            $('#thankyou').show();
                            $('#facial-loading-dynamic').hide();
                            $('#facial-loading-static').show();
                            $('#seflie-text').text(
                                'We received your image');
                                $("#selfie-cancel").hide();
                                $("#continue-btn").show();

                            $("#seflie-text").show();
                            // $("#submitBtn").show();
                            $("#selfie-continue").prop("disabled", false);
                            $("#alertSuccess").show();
                            $("#selfie-cancel").prop("disabled", true);
                            $('#seflie-text').text(
                                'We received your image');
                            // $("#submitBtn").prop("disabled", false);
                            clearInterval(x); */
                        }


                        if (text === 'NoPhoto') {
                            clearInterval(x);
                            console.log('No photo was found at the department of home affairs, please click continue to upload your ID Document');
                            $('#thankyou').hide();
                            $('#line').show();
                            $("#time").hide();
                            $("#selfie-cancel").hide();
                            $("#instruction").hide();
                            $("#remaining").hide();
                            $('#seflie-text-error').text(
                                    'No photo was found at the department of home affairs, please click continue to upload your ID Document'
                            );
                            $("#selfie-continue").hide();
                            $("#alertError").show();
                            $("#seflie-text-error").show();
                            $("#continue-btn").show();
                            /* $('#selfie-link-title').hide();
                            $('#thankyou').html('Photos does not match, IDV verification failed');
                            $('#thankyou').show();
                            $('#facial-loading-dynamic').hide();
                            $('#facial-loading-static').show();
                            $('#seflie-text').text(
                                'We received your image');
                                $("#selfie-cancel").hide();


                            $("#seflie-text").show();
                            // $("#submitBtn").show();
                            $("#selfie-continue").prop("disabled", false);
                            $("#alertSuccess").show();
                            $("#selfie-cancel").prop("disabled", true);
                            $('#seflie-text').text(
                                'We received your image');
                            // $("#submitBtn").prop("disabled", false);
                            clearInterval(x); */
                        }

                        if (text === 'Consumer') {
                            clearInterval(x);
                            console.log('Selfie has been taken successfully!');
                            $('#selfie-link-title').hide();
                            $('#line').show();
                            $("#time").hide();
                            $("#remaining").hide();
                            $('#green-check').show();
                            $('#thankyou').show();
                            $('#facial-loading-dynamic').hide();
                            $('#facial-loading-static').show();
                            $('#seflie-text').text(
                                'We received your image');
                                $("#instruction").hide();
                                $("#continue-btn").show();

                            $("#seflie-text").show();
                            // $("#submitBtn").show();
                            $("#selfie-continue").prop("disabled", false);
                            $("#alertSuccess").show();
                            $("#selfie-cancel").prop("disabled", true);
                            $('#seflie-text').text(
                                'We received your image');
                            // $("#submitBtn").prop("disabled", false);
                            clearInterval(x);
                        }
                    }, 10000);
                    // alert(response.msg);
                    //location.reload();
                }
                , error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON;
                    if(response.responseJSON.errors != null){
                        errorsHtml = '<div class="alert alert-danger"><ul>';

                        $.each( errors.errors, function( key, value ) {
                            errorsHtml += '<li>'+ value[0] + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></div>';

                        $( '#form-errors' ).html( errorsHtml );
                    }
                    // $("#btn-hidden-failed").click();
                }
            });
        });
        $("#selfie-continue").click(function() {
            window.location = '/sb-initiate';

        });

        $("#selfie-cancel").click(function() {
            location.reload();
           // window.location = '<?= config("app.CS_Investor_Center_SA"); ?>';

        });

    });

</script>

{{-- Selfie Results --}}
<script type="text/javascript">
    $(document).ready(function() {
        if("<?= Session::get('otl'); ?>" != ''){

            if(("<?= Session::get('option'); ?>" == 'Browser')){
                document.getElementById('iframe_url').src = '<?php echo Session::get('otl'); ?>';

                //window.open('<?php //echo Session::get('otl'); ?>', '_blank');
            }

                    //setTimeout(function() {

                    $("#btn-hidden-selfie").click();
                    startCountdown();
                    var i = 1;
                    var x = setInterval(function() {
                            console.log(i);
                            if(i>30){
                                clearInterval(x);
                                $('#seflie-text-error').text(
                                    'ID verification was not successful. Please click the "OK" button then click the "Next" button again to resend the link!'
                                );
                                $("#instruction").hide();
                                $("#selfie-continue").hide();
                               // $("#selfie-cancel").hide();
                                $("#alertError").show();
                                $("#seflie-text-error").show();
                                $("#selfie-cancel").show();
                               // $("#btn-Okay").show();
                                console.log(
                                    'ID verification was not successful. Please click the Next button again to resend the link!'
                                );
                            }else{

                                $.ajax({
                                    url: "{{ route('sbgetOtlDovsStatus') }}",
                                    method: 'GET',
                                    processData: false,
                                    contentType: false,

                                    beforeSend: function() {
                                        console.log('before send');

                                    }
                                    , complete: function() {
                                        console.log('completed')
                                    }
                                    , success: function(output_data) {
                                        console.log(output_data);
                                        console.log(output_data.ConsumerIDPhotoMatch);
                                        // if (output_data.data === 'Consumer') {
                                        //$('#seflie-text').text(output_data.data);ConsumerIDPhotoMatch
                                        if(output_data.ConsumerIDPhotoMatch === 'Matched')
                                        {
                                            console.log('Selfie has been taken successfully!');
                                            $('#selfie-link-title').hide();
                                            $('#line').show();
                                            $("#time").hide();
                                            $("#remaining").hide();
                                            $('#green-check').show();
                                            $('#thankyou').show();
                                            $('#facial-loading-dynamic').hide();
                                            $('#facial-loading-static').show();
                                            $('#seflie-text').text(
                                                'We received your image');
                                                $("#instruction").hide();
                                                $("#continue-btn").show();

                                            $("#seflie-text").show();
                                            $("#selfie-continue").prop("disabled", false);
                                            $("#alertSuccess").show();
                                            $("#selfie-cancel").prop("disabled", true);
                                            $('#seflie-text').text(
                                                'We received your image');
                                            clearInterval(x);
                                        }
                                        else if(output_data.ConsumerIDPhotoMatch === 'Not Matched')
                                        {
                                            clearInterval(x);
                                            console.log('Photos does not match, IDV verification failed');
                                            $('#thankyou').hide();
                                            $('#line').show();
                                            $("#time").hide();
                                            $("#instruction").hide();
                                            $("#remaining").hide();
                                            $("#selfie-cancel-url").show();
                                            $('#seflie-text-error').text(
                                                    'Photos does not match, IDV verification failed'
                                            );
                                            $("#selfie-continue").hide();
                                            $("#alertError").show();
                                            $("#seflie-text-error").show();
                                        }

                                        else if(output_data.ConsumerIDPhotoMatch != '' && output_data.ConsumerIDPhotoMatch != null){
                                            clearInterval(x);
                                            console.log( 'IDV verification failed due to '+ output_data.ConsumerIDPhotoMatch );
                                            $('#thankyou').hide();
                                            $('#line').show();
                                            $("#time").hide();
                                            $("#selfie-cancel").hide();
                                            $("#instruction").hide();
                                            $("#remaining").hide();
                                            $('#seflie-text-error').text(
                                                'IDV verification failed due to '+ output_data.ConsumerIDPhotoMatch
                                            );
                                            $("#selfie-continue").hide();
                                            $("#alertError").show();
                                            $("#seflie-text-error").show();
                                            $("#continue-btn").show();

                                        }
                                    }
                                    , error: function() {
                                    console.log('error');
                                    }


                                });
                            }
                            i++;

                    }, 10000);
               // }, 20000);
        }

        $('#getselfieResult').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData(this);
            $.ajax({
                url: "{{ route('sbgetselfieresult') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    // document.querySelector("#loader-selfie").style.visibility =
                    //     "visible";

                }
                , complete: function() {
                    // document.querySelector("#loader-selfie").style.display = "none";
                    //  $('#loading-send-sms').hide();
                }
                , success: function(output_data) {
                    console.log(output_data);
                    // if (output_data.data === 'Consumer') {
                    //$('#seflie-text').text(output_data.data);
                    if(output_data.process_status === 'Failed')
                    {
                        $('#seflie-text').text('Failed');
                    }
                    else if(output_data.process_status === 'NoPhoto')
                    {
                        $('#seflie-text').text('NoPhoto');
                    }

                    else{
                        $('#seflie-text').text(output_data.data);
                    }
                }
                , error: function() {
                    // $("#btn-hidden-failed").click();
                }
            });
        });
    });

</script>

<script>
    // Set the starting time for the countdown (5 minutes)
let timeLeft = 5 * 60;

function startCountdown() {
    // Update the countdown every second
    const countdown = setInterval(() => {
        // Calculate minutes and seconds
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;

        // Display the result in the element with id="timer"
        document.getElementById('time').innerHTML =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        // If the countdown reaches zero, stop the timer
        if (timeLeft <= 0) {
            clearInterval(countdown);
            document.getElementById('time').innerHTML = "Time's up!";
        }

        // Decrease time left by one second
        timeLeft--;
    }, 1000);
}




</script>
<script type="text/javascript">
    function redirecttocs() {
        window.location = '<?= config("app.CS_Investor_Center_SA"); ?>';
    }
</script>

<script>
    function restrictInput(input) {
        const prefix = "+27"; // The fixed prefix
        const currentValue = input.value;


        if (currentValue.slice(0, 3) !== prefix) {
            input.value = prefix + currentValue.slice(3);
        }

        // Only allow numeric input for the rest of the value
        const remaining = input.value.slice(3).replace(/[^0-9]/g, '');
        input.value = prefix + remaining;

        // Calculate the correct cursor position
        const cursorPosition = input.selectionStart;
        if (cursorPosition < 3) {
            input.setSelectionRange(3, 3);
        } else if (cursorPosition !== input.value.length) {
            input.setSelectionRange(cursorPosition, cursorPosition);
        }
    }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
       // const emailOption = document.getElementById('emailOption');
        const browserOption = document.getElementById('browserOption');
        const smsOption = document.getElementById('smsOption');
        //const emailInput = document.getElementById('emailInput');
        const smsInput = document.getElementById('smsInput');
       /* emailOption.addEventListener('change', function() {
            if (emailOption.checked) {
                emailInput.style.display = 'block';
                smsInput.style.display = 'none';
            }
        });*/
        smsOption.addEventListener('change', function() {
            if (smsOption.checked) {
                smsInput.style.display = 'block';
                //emailInput.style.display = 'none';
            }
        });
        browserOption.addEventListener('change', function() {
            if (browserOption.checked) {
                smsInput.style.display = 'none';
                //emailInput.style.display = 'none';
            }
        });
    });
</script>
    @endsection
