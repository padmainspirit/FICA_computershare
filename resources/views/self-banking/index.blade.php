@extends('layouts.master-without-nav')

@section('title')
@lang('translation.sb_index')
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
                                        <h3 class="text-white">Welcome to Self Service Banking</h3>
                                        <p class="font-size-15">Please agree to the terms and conditions to continue the flow</p>
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
                                    <ul class="font-size-14">
                                        <li>You will need to have your bank account details on hand and a device with camera.</li>
                                        <li>No third-party banking details can be accepted - the account must be in your own name.</li>
                                        <li>This application is for individuals who have a South African ID Number.</li>
                                        <li>Non resident individuals and all non-individuals should contact us on 0861100933 for further assistance.</li>
                                        <li>If you do not bank with one of these banks, Contact us on 0861100933 or <a href="">click here</a> to obtain the manual form Update your details(computershare.com)
                                            Absa Bank, African Bank, Bank of Athens, Bidvest Bank, Capitec, Discovery Bank, First National Bank,
                                      Investec Bank, Mercantile Bank, Nedbank, Sasfin Bank, Standard Bank, Tyme Bank.</li>

                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-fica-id mb-1">
                                        <div class="">
                                            <h4 class=""
                                                style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                                What You Can Expect
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="text-center mb-1 mt-5 d-flex justify-content-center align-items-center">

                                        <img src="{{ URL::asset('/assets/images/PersonalDetails.png') }}" style="width:45px; margin-right:5px;">
                                        <h5 style="margin-right:20px;">Personal Details</h5>
                                        <img src="{{ URL::asset('/assets/images/BankingDetails.png') }}" style="width:45px; margin-right:5px;">
                                        <h5 style="margin-right:20px;">Banking Details</h5>
                                        <img src="{{ URL::asset('/assets/images/IDVerification.png') }}" style="width:45px; margin-right:5px;">
                                         <h5 style="margin-right:20px;">Digital ID Verification</h5>

                                    </div>

                                </div>
                            </div>

                                <form method="post" action="{{ route('agree-selfbanking-tnc') }}" id="sb-tnc-form">
                                @csrf
                                    <div class="row mt-5 mb-3">
                                        <div class="col-12">
                                            <input class="form-check-input big-checkbox" type="hidden" value="{{ $sbid }}" name="sbid" style="width: 20px; height:20px;">


                                            <label class="form-check-label font-size-14" for="tnc-checkbox" style="padding-left:15px;padding-right:15px;padding-top:5px; font-size: 12px; color: rgb(0, 0, 0);">
                                                <input class="form-check-input big-checkbox" type="checkbox" id="sb-tnc-checkbox" name="sb-tnc" style="margin-right:5px;width: 20px; height:20px;">By ticking this box, you authorize Computershare to verify your banking details against any third party database. You acknowledge that Computershare might be unable to verify the authenticity of electronic instructions and therefore you hereby indemnify Computershare against any loss or damage incurred as a result of acting upon such instructions. you further acknowledge that it is your responsibility as the account holder to inform Computershare immediately and not later than a period of 1 month of any change made to the registered email address
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="text-align: right;">
                                        <button type="submit" class="btn btn-primary">Continue</button>
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
    <!-- end account-pages -->
    @endsection

    @section('script')


    @endsection
