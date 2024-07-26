@extends('layouts.master-without-nav')

@section('title')
@lang('translation.selfbankingservice')
@endsection

@section('css')
<style>
    .required{
        color:"#ff0000" !important;
    }

</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



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
                    <div class="card overflow-hidden" style="border-radius: 10px;">

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




                            <div class="heading-fica-id mb-1">
                                <div class="">
                                    <h4 class="font-size-18"
                                        style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Banking Details
                                    </h4>
                                </div>
                            </div>




                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="accnumber">Account Number <span style="color:red;" class="required">*</span></label>
                                            <input id="accnumber" name="accnumber" placeholder="Enter Your Bank Account Number"
                                                type="text" style="border-radius: 15px;" class="form-control"
                                                value="{{ old('accnumber') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('accnumber')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>

                                            <div class="col-sm-12">
                                                <label for="BankName">Bank Name <span style="color:red;" class="required">*</span></label>
                                                <select class="form-select" autocomplete="off"
                                                style="border-radius: 15px; "
                                                    id="BankName" name="BankName">
                                                    <option value="" disabled selected style="" >
                                                        --Select Bank--
                                                    </option>
                                                    <option value="absa">ABSA Bank</option>
                                                    <option value="capitec">Capitec Bank</option>
                                                    <option value="fnb">First National Bank (FNB)</option>
                                                    <option value="investec">Investec Bank</option>
                                                    <option value="nedbank">Nedbank</option>
                                                    <option value="standard_bank">Standard Bank</option>
                                                    <option value="tyme_bank">Tyme Bank</option>


                                                </select>

                                                <span class="error-messg"></span>
                                                @error('BankName')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror

                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="branchcode">Branch Code <span style="color:red;" class="required">*</span></label>
                                            <input id="branchcode" name="branchcode" placeholder="Branch Code"
                                                type="text" style="border-radius: 15px;" class="form-control" pattern="^([a-zA-Z]{2,} ?)+$"
                                                value="{{ old('branchcode') }}" required="required" />

                                            <span class="error-messg"></span>
                                            @error('branchcode')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror

                                            </div>


                                    </div>

                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                        <div class="mt-3">



                                            <button type="reset" id="clearall" style="background-color: #93186c; border-color: #93186c"
                                                class="btn w-md text-white">Clear</button>
                                                <button type="submit" class="btn w-md text-white" id="personaldetails"
                                                style="float: right;background-color: #93186c; border-color: #93186c;">Next</button>

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

    <script>
        $(document).ready(function(){

            // Initialize select2
            $("#BankName").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#BankName option:selected').text();
                var userid = $('#BankName').val();

                $('#result').html("id : " + userid + ", name : " + username);

            });
        });

        </script>


    <!-- jQuery -->

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>

<script>

</script>



    @endsection
