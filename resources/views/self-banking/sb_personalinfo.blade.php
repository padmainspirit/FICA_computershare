@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.sb_personaldetails')
@endsection

@section('css')
<style>
    .required {
        color: "#ff0000" !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



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
                <div class="col-md-10 mt-4">



                    <div class="container mt-4">
                        <div class="mt-4" style="position: relative;width:85%; margin: auto;">
                            <img class="mb-2" src="{{ URL::asset('/assets/images/location-pin.png') }}"
                                style="height:45px;width:45px; position: absolute; left: 25%; transform: translateX(-50%); top: -55px;">
                            <div class="progress mx-auto mb-4 mt-4" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 25%; background-color: #91C60F" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="row justify-content-between ">
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


                    <div class="card overflow-hidden" style="border-radius: 10px;">

                        <div style="background-image: linear-gradient(#93186c, #93186c);" class="text-center">
                            <div class="row">

                                <div class="col-12">

                                    <div class="text-white p-4">
                                        <h4 class="text-white">Self service banking process</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">

                            <div class="p-2">
                                @if (Session::has('message'))
                                <div class="alert alert-danger">
                                    {{ Session::get('message') }}
                                </div>
                                @endif
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif




                                <div class="heading-fica-id mb-1 mt-2">
                                    <div id="acc" style="display: flex; align-items: center; ">
                                        <h4 class="font-size-18" style="color:#93186c; margin-right:5px; ">
                                            Account Details
                                        </h4>
                                        <p class="tango-help-acc" aria-hidden="true" title="Please fill in your shareholder reference number (SRN) this is your Computershare account of reference number.  Starting with a C, D or U followed by 10 numeric characters e.g., C0001234567. Your reference number can be found on any Computershare correspondence.
                                            If your SRN starts with a C you need to tell us in company, you are holding shares. Only one company can be selected." style="cursor:pointer;"><img src="{{ URL::asset('/assets/images/information.png') }}" style="position: relative;width:22px; margin-right:5px;top:3px;" /></p>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <form class="repeater" data-limit="5" method="post" action="{{ route('sb-personalinfo') }}" id="sb-tnc-form">
                                        @csrf
                                        <div data-repeater-list="reflist" class="duplicable">
                                            <?php $reflist = Request::old('reflist') != null ? count(Request::old('reflist')) : 1;
                                            for ($i = 0; $i < $reflist; $i++) {
                                                $value = 'reflist.' . $i . '.refnum';
                                                $company_old = 'reflist.' . $i . '.company';
                                            ?>
                                                <div data-repeater-item class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label for="subject">Shareholder reference number<span style="color:red;">*</span></label>

                                                    </div>
                                                    <div class="mb-3 col-md-5 otp-input-container">

                                                        <input type="text" maxlength="1" style="text-transform: capitalize;" placeholder="C" name="srn1" class="otp-input refnum" id="otp1" oninput="moveToNext(this, 'otp2')" value="<?= Request::old('reflist.' . $i . '.srn1'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="1" name="srn2" class="otp-input" id="otp2" oninput="moveToNext(this, 'otp3')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn2'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="2" name="srn3" class="otp-input" id="otp3" oninput="moveToNext(this, 'otp4')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn3'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="3" name="srn4" class="otp-input" id="otp4" oninput="moveToNext(this, 'otp5')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn4'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="4" name="srn5" class="otp-input" id="otp5" oninput="moveToNext(this, 'otp6')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn5'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="5" name="srn6" class="otp-input" id="otp6" oninput="moveToNext(this, 'otp7')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn6'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="6" name="srn7" class="otp-input" id="otp7" oninput="moveToNext(this, 'otp8')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn7'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="7" name="srn8" class="otp-input" id="otp8" oninput="moveToNext(this, 'otp9')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn8'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="8" name="srn9" class="otp-input" id="otp9" oninput="moveToNext(this, 'otp10')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn9'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="9" name="srn10" class="otp-input" id="otp10" oninput="moveToNext(this, 'otp11')" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn10'); ?>" required>
                                                        <input type="text" maxlength="1" placeholder="0" name="srn11" class="otp-input" id="otp11" pattern="^([0-9]{1} ?)+$" title="Please enter a number" value="<?= Request::old('reflist.' . $i . '.srn11'); ?>" required>

                                                    </div>



                                                    <div class="mb-3 col-md-4 search-box">
                                                        <div >
                                                        <select class="form-select" autocomplete="off" style="border-radius: 15px; " name="company">
                                                            <option value="" style="font-size: 12px;">
                                                                --Select company--
                                                            </option>
                                                            <?php
                                                            foreach ($companies as $company) {  ?>
                                                                <option value="{{ $company->Company_Name }}" {{ Request::old($company_old) == $company->Company_Name ? "selected" : '' }} style="font-size: 12px;">
                                                                    {{ $company->Company_Name }}
                                                                </option>

                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>


                                                    <div class="mb-3 col-md-1">
                                                        <p data-repeater-delete id="remove" style="cursor:pointer;"><img src="{{ URL::asset('/assets/images/fail-cross.png') }}" style="width:22px; margin-top:5px;" /></p>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-3 mt-3">

                                            <p data-repeater-create id="createclick" style="cursor:pointer;"><img src="{{ URL::asset('/assets/images/plus.png') }}" style="width:22px; margin-right:5px;" />ADD MORE</p>
                                        </div>


                                </div>



                                <hr style="color: #93186c ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #93186c; background-color: #93186c; opacity: 100%;">

                                <div class="heading-fica-id mb-1 mt-2">
                                    <div id="person" style="display: flex; align-items: center; ">
                                        <h4 class="font-size-18" style="color:#93186c;margin-right:5px; ">
                                            Personal Details
                                        </h4>

                                        <p class="tango-help-tip" aria-hidden="true" title="Mobile number example : 0723456789" style="cursor:pointer;"><img src="{{ URL::asset('/assets/images/information.png') }}" style="position: relative;width:22px; margin-right:5px;top:3px;" /></p>

                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-sm-6 mb-2">
                                            <div style="display: flex; align-items: center;">
                                                <span style="color:red;">*</span>
                                                <input id="IDNUMBER" name="IDNUMBER" placeholder="Enter 13 digit ID number" type="text" style="border-radius: 15px;margin-left: 5px;" class="form-control" value="{{ old('IDNUMBER') }}" required="required" />
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div style="display: flex; align-items: center;">
                                                <span style="color:red;">*</span>
                                                <input id="FirstName" name="FirstName" placeholder="Enter first name" type="text" style="border-radius: 15px;margin-left: 5px;" class="form-control" value="{{ old('FirstName') }}" required="required" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-sm-6 mb-2">
                                            <div style="display: flex; align-items: center;">
                                                <span style="color:red;">*</span>
                                                <input id="Surname" name="Surname" placeholder="Enter surname" type="text" style="border-radius: 15px;margin-left: 5px;" class="form-control" value="{{ old('Surname') }}" required="required" />
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div style="display: flex; align-items: center;">
                                                <span style="">&nbsp;</span>
                                            <input id="SecondName" name="SecondName" placeholder="Enter second name" type="text" style="border-radius: 15px;margin-left: 5px;" class="form-control" value="{{ old('SecondName') }}" />
                                        </div>

                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-sm-6 mb-2">
                                            <div style="display: flex; align-items: center;">
                                                <span style="color:red;">*</span>
                                                <input id="PhoneNumber" name="PhoneNumber" placeholder="Enter phone number" type="text" style="border-radius: 15px; margin-left: 5px;" class="form-control" pattern="^([0-9]{10} ?)+$" value="{{ old('PhoneNumber') }}" required="required" />
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div style="display: flex; align-items: center;">
                                                <span style="">&nbsp;</span>
                                            <input id="ThirdName" name="ThirdName" placeholder="Enter third name" type="text" style="border-radius: 15px; margin-left: 5px;" class="form-control" value="{{ old('ThirdName') }}" />
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-sm-6">
                                            <div style="display: flex; align-items: center;">
                                                <span style="color:red;">*</span>
                                                <input id="Email" name="Email" placeholder="Enter email" type="Email" style="border-radius: 15px; margin-left: 5px;" class="form-control" value="{{ old('Email') }}" required />
                                            </div>

                                        </div>
                                    </div>

                                    {{-- store Recaptcha token --}}
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                    <div class="mt-3">



                                        <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Clear</button>
                                        <button type="submit" class="btn w-md text-white" id="personaldetails" style="float: right;background-color: #91C60F; border-color: #91C60F;">Next</button>

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

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

        <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
        <script>
            $(function() {
                $('.tango-help-tip').popover({
                    trigger: 'click hover',
                    container: '#person',
                    placement: 'bottom'
                })
            })
            $(document).on('click', function(e) {
            if (!$(e.target).closest('.tango-help-tip').length) {
                $('.tango-help-tip').popover('hide');
            }
        });

        </script>
        <script>
            $(function() {
                $('.tango-help-acc').popover({
                    trigger: 'click hover',
                    container: '#acc',
                    placement: 'bottom'
                })
            })
            $(document).on('click', function(e) {
            if (!$(e.target).closest('.tango-help-acc').length) {
                $('.tango-help-acc').popover('hide');
            }
        });


            $(document).ready(function() {
                // Initialize select2
                $("#remove").hide();
                $(".form-select").select2();

                $("#createclick").click(function(e) {
                    $(".form-select").select2();

                });



            });

            function moveToNext(current, nextFieldId) {
                console.log(current.name);
                var name = current.name;
                let srn1regex = /^reflist\[(\d+)\]\[srn1]$/;

                let match = name.match(srn1regex); //matches number inside the squere bracket
                if (match) {
                    let index = parseInt(match[1]);
                    //$('[name="reflist['+index+'][company]"]').parent().hide();
                    var srn1 = $('[name="' + name + '"]').val();
                    console.log(srn1);
                    var cu_regex = /^[c|u|C|U]{1}$/;
                    var d_regex = /^[d|D]{1}$/;
                    if (srn1.match(cu_regex)) {
                        $('[name="reflist[' + index + '][company]"]').parent().show();
                    }
                    if (srn1.match(d_regex)) {
                      $('[name="reflist[' + index + '][company]"]').val('');
                     $('[name="reflist[' + index + '][company]"]').parent().hide();
                    }

                }

                let srnmatch = name.match(/\d(?!.*\d)/);
                if (srnmatch && $('[name="' + name + '"]').val()) {
                    var newindex = parseInt(srnmatch[0]);
                    var nextindex = Number(newindex) + Number(1);
                    var newname = name.replace(/\d(?=\D*$)/, nextindex);
                    $('[name="' + newname + '"]').focus();
                }
            }
        </script>


        @endsection
