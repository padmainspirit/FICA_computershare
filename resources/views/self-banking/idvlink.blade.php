@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.Login')
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

    <div class="row d-flex justify-content-center mb-2 mt-4">
        <img src="{{ URL::asset('assets\images\logo\computershare.png') }}" style="max-width: 200px; max-height: 200px;" alt="" class="img-fluid">
    </div>

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                <div class="text-center mt-3 d-flex justify-content-between align-items-center">
    <div class="step text-center">

    </div>
    <div class="step text-center">

    </div>
    <div class="step text-center">
    <img src="{{ URL::asset('/assets/images/location-pin.png') }}" style="height:45px;width:45px;">

    </div>
    <div class="step text-center">

    </div>
    <div class="step text-center">

    </div>
</div>
                <div class="progress mb-4 mt-3" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;background-color: #91C60F;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="text-center mb-4 mt-2 d-flex justify-content-between align-items-center">
                                    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/octicon--info-16.png') }}" style="height:45px;width:45px;">
        <h5>Welcome</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px;">
        <h5>Personal Details</h5>
    </div>

    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px;">
        <h5>Digital ID Verification</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px;">
        <h5>Banking Details</h5>
    </div>
    <div class="step text-center">
        <img src="{{ URL::asset('/assets/images/mdi--tick-circle-outline.png') }}" style="width:45px;">
        <h5>Finish</h5>
    </div>
</div>
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





                                    <div class="row">
                                        <div class="heading-fica-id mb-1">
                                            <div class="">
                                                <h4 class="font-size-18"
                                                    style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                                    Digital ID Verification
                                                </h4>
                                            </div>
                                        </div>













                                                    {{-- <p style="color: #000000;">{{ $exception }}</p> --}}
                                                    <form method="post" action="{{ route('sbEmailorPhone') }}" id="sb-tnc-form">
                                                        @csrf
                                                        <div class="form-group row justify-content-center align-items-center text-center">
                                                        <div class="col-sm-3">
                                                            <div style="display: flex; align-items: center;">
                                                                <input style="background-color:green;border: 1px solid green;" class="form-check-input" checked type="radio" id="smsOption" name="option" value="SMS">
                                                                <label class="form-check-label" style="font-size:16px;margin-left:3px;" for="smsOption">SMS</label>
                                                               </div>


                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div style="display: flex; align-items: center;">
                                                                <input autocomplete="off" type="text" class="form-control input-sm" style="border-radius: 15px;" id="smsInput" name="phone" placeholder="Enter Cellphone Number" value="{{$phoneNumber}}">
                                                                 </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row justify-content-center align-items-center text-center mt-2">

                                                        <div class="col-sm-6">
                                                            <div style="display: flex; align-items: center;">
                                                                <p class="font-size-16">Confirm your cellphone number to recieve a selfie link to your device.</p>
                                                                 </div>

                                                        </div>
                                                    </div>


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
                                <img src="{{ URL::asset('/assets/images/selfie2.gif') }}" width="120px" />
                            </div>

                            <br><br>
                            <div class="row justify-content-center">
                                <br>
                                <div class="col-xl-10" id="selfie-link-title">
                                    <h4 style="color: #000000">Selfie Link SMS has been sent.
                                    </h4>
                                    <p style="color: #000000">
                                        Please ensure that your browser cookies are enabled.
                                                           </p>
                                </div>
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
                                <hr id="line" style="display:none;color: #93186c ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #93186c; background-color: #93186c; opacity: 100%;">
                            </div>
                            <br>
                           <p id="thankyou" class="text-muted font-size-14 mb-4" style="display:none;color:#000000;margin-bottom: 3%;">Thank You, Your ID has been verified, please click on Continue
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
                                        <button type="button" id="selfie-cancel" class="btn btn-primary"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>
                            </div>
                                    </div>



                            <button type="button" class="btn text-center w-md text-white" id="btn-Okay"
                                style="width: 10%;margin-bottom: 3%;"
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
                                    'Selfie has not been taken successfully. Please click the selfie link button again to resend the link!'
                                );
                                $("#selfie-continue").hide();
                               // $("#selfie-cancel").hide();
                                $("#alertError").show();
                                $("#seflie-text-error").show();
                               // $("#btn-Okay").show();
                                console.log(
                                    'Selfie has not been taken Successfully. Please click the selfie link button again to resend the link!'
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

                        if (text === 'Consumer') {
                            clearInterval(x);
                            console.log('Selfie has been taken successfully!');
                            $('#selfie-link-title').hide();
                            $('#line').show();
                            $('#green-check').show();
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

        });

    });

</script>

{{-- Selfie Results --}}
<script type="text/javascript">
    $(document).ready(function() {
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
                    // if (output_data.data === 'Consumer') {
                    //$('#seflie-text').text(output_data.data);
                    if(output_data.process_status == 'Failed')
                    {
                        $('#seflie-text').text('Failed');
                    }else{
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



    @endsection