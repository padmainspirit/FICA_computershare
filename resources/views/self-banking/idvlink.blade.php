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




                                                <p class="font-size-16">Please Confirm your Cellphone to recieve a selfie link to your device.</p>


                                        <div class="form-group row">

                                            <div class="col-lg-12">
                                                <div class="row justify-content-center align-items-center">

                                                    {{-- <p style="color: #000000;">{{ $exception }}</p> --}}
                                                    <form method="post" action="{{ route('sbEmailorPhone') }}" id="sb-tnc-form">
                                                        @csrf
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
                                                    {{--<button id="sendLinkButton" type="submit" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Send Link</button>--}}

                                                    <button type="submit" name="submit" id="submit-facial"
                                                    class="btn btn-primary"
                                                    style="font-size: 16px;width: 150px; padding:.28rem; height:fit-content;">Selfie
                                                    Link
                                                </button>
                                                    <button style="display:none;" type="button" class="btn btn-primary" id="btn-hidden-selfie"
                                                    data-bs-toggle="modal" data-bs-target="#composemodal-selfie">
                                                    Send Link
                                                </button>
                                                </div>

                                            </div>



                                        </form>
                                        <div class="text-center d-flex justify-content-center align-items-center mt-2">
                                            {{-- <a style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white" href="{{ url('/banking') }}">Proceed</a>--}}
                                            </div>
                                    </div>




                                      {{-- store Recaptcha token --}}
                                      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                      <div class="mt-3">



                                          <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c"
                                              class="btn w-md text-white">Back</button>


                                      </div>

                            </div>

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
                <form action="{{ route('getselfieresult') }}" method="post" enctype="multipart/form-data"
                    id="getselfieResult">
                    @csrf
                    <div class="modal-body">
                        <br><br>
                        <div class="text-center mb-4">
                            <div id="facial-loading-dynamic">
                                <img src="{{ URL::asset('/assets/images/selfie2.gif') }}" width="120px" />
                            </div>
                            <div id="facial-loading-static" style="display: none">
                                <img src="{{ URL::asset('/assets/images/selfie2.png') }}" width="120px" />
                            </div>
                            <br><br>
                            <div class="row justify-content-center">
                                <br>
                                <div class="col-xl-10" id="selfie-link-title">
                                    <h4 style="color: #000000">Selfie Link SMS has been sent.
                                    </h4>
                                    <h5 style="color: #000000">
                                        Please ensure that your browser cookies are enabled.
                                    </h5>
                                </div>
                                <div id="alertSuccess" class="alert alert-success" role="alert">
                                    <br>
                                    <p id="seflie-text" style="color: rgb(0, 116, 0); font-size: 15px;"></p>
                                </div>

                                <div id="alertError" class="alert alert-danger" role="alert">
                                    <br>
                                    <p id="seflie-text-error" style="color: rgb(182, 37, 37); font-size: 15px;"></p>
                                </div>
                            </div>
                            <br>
                            {{-- <p class="text-muted font-size-14 mb-4" style="color:{{$Font}};">1. Please click the link sent
                                in
                                your phone to take a
                                selfie.
                            </p> --}}
                            <p class="text-muted font-size-14 mb-4" style="color:#000000;margin-bottom: 3%;">Please
                                click the
                                button below to continue.
                            </p>
                        </div>
                        <div class="text-center mb-3">
                            {{-- <div id="save-and-cancel-declaration-btn" style="display: none"> --}}
                            <button type="submit" id="submitBtn" class="btn-primary text-center w-md "
                                style="width: 10%; ;margin-bottom: 3%;">
                                Continue
                            </button>

                            <button type="button" id="selfie-continue" class="btn-primary text-center w-md text-white"
                                style="width: 10%; margin-bottom: 3%;"
                                disabled data-bs-dismiss="modal">
                                Continue
                            </button>

                            <button type="button" id="selfie-cancel" class="btn-primary text-center w-md text-white"
                                style="width: 10%;margin-bottom: 3%;"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

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
    <script>

        document.getElementById('submit-facial').addEventListener('click', function() {
  document.getElementById('btn-hidden-selfie').click();
});
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
                url: '{{ route('sbEmailorPhone') }}',
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // document.querySelector("#loader-selfie").style.visibility =
                    //     "visible";
                    $('#loading-send-sms').show();
                    $('#click-icon-facial').hide();
                    $('#click-icon-static-facial').show();
                    $('#submit-facial').hide();
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
                        if (text !== 'Consumer') {
                            $("#submitBtn").click();

                            var text2 = $('#seflie-text').html();
                            if (text2 == 'Consumer') {
                                clearInterval(x);
                            }
                            if (i > 50) {
                               // $('#selfie-link-title').hide();
                                //$('#facial-loading-dynamic').hide();
                               // $('#facial-loading-static').show();
                                $('#seflie-text-error').text(
                                    'Selfie has not been taken successfully. Please click the selfie link button again to resend the link!'
                                );
                                $("#selfie-continue").hide();
                                $("#selfie-cancel").hide();
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

                        if (text === 'Consumer') {
                            clearInterval(x);
                            console.log('Selfie has been taken successfully!');
                            $('#selfie-link-title').hide();
                            $('#facial-loading-dynamic').hide();
                            $('#facial-loading-static').show();
                            $('#seflie-text').text(
                                'Selfie has been taken successfully!');
                            //$("#selfie-continue").hide();
                            $("#seflie-text").show();
                            // $("#submitBtn").show();
                            $("#selfie-continue").prop("disabled", false);
                            $("#alertSuccess").show();
                            $("#selfie-cancel").prop("disabled", true);
                            $('#seflie-text').text(
                                'Selfie has been taken successfully!');
                            // $("#submitBtn").prop("disabled", false);
                            clearInterval(x);
                        }
                    }, 10000);
                    // alert(response.msg);
                    //location.reload();
                }
                , error: function(response) {
                    console.log(reponse);
                    // $("#btn-hidden-failed").click();
                }
            });
        });
        $("#selfie-continue").click(function() {
            location.reload();

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
                url: '{{ route('getselfieresult') }}',
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
                    $('#seflie-text').text(output_data.data);
                    // console.log('textResult: ' + textResult);
                    // }

                }
                , error: function() {
                    // $("#btn-hidden-failed").click();
                }
            });
        });
    });

</script>



    @endsection
