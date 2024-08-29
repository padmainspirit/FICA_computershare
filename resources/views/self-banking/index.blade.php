@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.sb_index')
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
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card overflow-hidden">

                        <div style="background-image: linear-gradient(#93186c, #93186c);" class="text-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h3 class="text-white">Welcome to self service banking detail update</h3>

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
                            <div class="heading-fica-id mb-1">
                                <div class="">
                                    <h4 class=""
                                        style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Before We Get Started
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="container">
                                    <ul class="font-size-14">
                                        <li>You will need to have your bank account details on hand and a device with camera.</li>
                                        <li>No third-party banking details can be accepted - the account must be in your own name.</li>
                                        <li>This application is for individuals who have a South African ID Number.</li>
                                        <li>Non resident individuals and all non-individuals should contact us on <span style="color:#93186c;">086&nbsp;110&nbsp;0933</span> for further assistance or <span style="color:#93186c;">+27&nbsp;11&nbsp;373&nbsp;0017</span> then we can schedule a walk through.</li>

                                    </ul>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-12">


                                    <div class="container mt-4">
                                        <div class="row justify-content-between align-items-center">
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">
                                            <img id="" src="{{ URL::asset('/assets/images/octicon--info-16.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Welcome</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center ">
                                            <img id="" src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Personal Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="" src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Digital ID Verification</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="" src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Banking Details</h5>
                                          </div>
                                          <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                            <img id="" src="{{ URL::asset('/assets/images/mdi--tick-circle-outline.png') }}" style="width:45px;" />
                                            <h5 class="mt-2 text-center">Finish</h5>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>

                                <form method="post" action="{{ route('agree-selfbanking-tnc') }}" id="sb-tnc-form">
                                @csrf
                                    <div class="row mt-5 mb-3">
                                        <div class="col-12">
                                            <div class="container" style="position: relative;display:flex;left: 15px;">
                                            <input class="form-check-input big-checkbox" type="hidden" value="{{ $sbid }}" name="sbid" style="width: 20px; height:20px;">
                                            <label class="form-check-label font-size-14" for="tnc-checkbox" style="padding-top:5px; font-size: 12px; color: rgb(0, 0, 0);">
                                                <input class="form-check-input big-checkbox" type="checkbox" id="sb-tnc-checkbox" name="sb-tnc" style="margin-right:5px;width: 20px; height:20px; position: relative; top: -4px;">
                                                By ticking this box, you authorize Computershare to verify your banking details against any third party database.
                                                <a style="color: #91C60F;" data-bs-toggle="modal" data-bs-target="#composemodal-tc" href="">See More</a>
                                            </label>


                                        </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12" style="text-align: center;">
                                        <button style="background-color:#91C60F;border:solid 1px #91C60F;" type="submit" class="btn btn-primary">Get Started</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    {{-- T&C Popup Modal --}}
    <div class="modal fade" id="composemodal-tc" tabindex="-1" role="dialog"
        aria-labelledby="composemodalTitle" aria-hidden="true" class="close">
        <div class="modal-dialog modal-dialog-centered"  role="document">
            <div class="modal-content" style="overflow-y: scroll;">

                    <div class="modal-body">
                        <br><br>
                        <div class="text-center mb-4">
                           <h5>Terms & Conditions</h5>
                            <hr>

                       </div>
                        <p style="color: #000000;text-align: justify; padding: 0 20px;">
                                    By ticking this box, you authorize Computershare to verify your banking details against any third party database. You acknowledge that Computershare might be unable to verify the authenticity of electronic instructions and therefore you hereby indemnify Computershare against any loss or damage incurred as a result of acting upon such instructions. you further acknowledge that it is your responsibility as the account holder to inform Computershare immediately and not later than a period of 1 month of any change made to the registered email address.
 <br> For more detailed terms and conditions, please visit our website, https://www.computershare.com/za/privacy

                                                           </p>

                        <div class="text-center mb-1 mt-4">

                            <div class="row">

                                        <div class="col-12" style="text-align:center;">
                                        <button style="background-color: #91C60F; border:solid 1px #91C60F;" type="button" id="selfie-cancel" class="btn btn-primary"
                                data-bs-dismiss="modal">
                                OK
                            </button>
                            </div>
                                    </div>


                        </div>

                    </div>


            </div>
            {{-- </form> --}}
        </div>
    </div>
    <!-- end account-pages -->
    @endsection

