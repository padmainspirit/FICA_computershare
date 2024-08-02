<?php

use Illuminate\Support\Facades\Session;
?>
@extends('layouts.master-without-nav-sb')

@section('title')
@lang('translation.selfbankingservice')
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
                                @if (Session::has('Success'))
                                    <div class="alert alert-success">
                                    {{ Session::get('Success') }}
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


                                <form method="post" action="" id="sb-tnc-form">
                                @csrf

                                <div class="heading-fica-id mb-1">
                                    <div class="">
                                        <h4 class="font-size-18" style="color:#93186c; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                            Review details
                                        </h4>
                                    </div>
                                </div>



                                <div class="form-group row" style="border: 1px solid black;width: 70%;padding: 25px 50px;margin: 50px 125px;">
                                    <h5>Account details</h5>

                                    @foreach($selfbankinglinkdetails->selfBankingDetails->SBCompanySRN as $key => $srn)
                                    <div data-repeater-item class="row">
                                       <div class="col-sm-3">
                                            <label>SRN</label> 
                                        </div>
                                        <div class="col-sm-3">
                                            <span>{{ $srn->SRN }}</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Company</label> 
                                        </div>
                                        <div class="col-sm-3">
                                        <span>{{ $srn->companies }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                    <br/><br/>
                                    
                                    <hr>
                                    <h5>Personal details</h5>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>First name</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->FirstName }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Second name</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->SecondName }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Surname</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->Surname }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>ID number</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->IDNUMBER }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Phone number</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->PhoneNumber }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Email</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->Email }}</span>
                                        </div>
                                    </div>
                                    <br/><br/>
                                   
                                    <hr>
                                    <h5>Bank details</h5>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>AccountHolderInitial</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->AccountHolderInitial }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Bank name</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->BankName }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Account number</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->AccountNumber }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Account type</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->bankAccountType->Account_description }}</span>
                                        </div>
                                    </div>
                                    <div data-repeater-item class="row">
                                        <div class="col-sm-6">
                                            <label>Branch code</label> 
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ $selfbankinglinkdetails->selfBankingDetails->BranchCode }}</span>
                                        </div>
                                    </div>
                                </div>


                               



                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                <div class="mt-5">



                                    <button type="reset" id="clearall" onclick="window.location='{{ url("banking") }}'" style="background-color: #93186c; border-color: #93186c" class="btn w-md text-white">Back</button>
                                    <button type="submit" class="btn w-md text-white" id="personaldetails" style="float: right;background-color: #93186c; border-color: #93186c;">Confirm</button>
                                    <button type="button" style="display:none" class="btn btn-primary" id="btn-hidden-popup"
                                                    data-bs-toggle="modal" data-bs-target="#composemodal-selfie">
                                                    Popup
                                                </button>
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
                            <div class="row justify-content-center">
                                <br>
                                <div class="col-xl-10" id="selfie-link-title">
                                    <h4 style="color: #000000">Bank execution Status.
                                    </h4>
                                </div>

                                <div id="alertError" class="alert alert-danger" role="alert">
                                    <br>
                                    <p id="seflie-text-error" style="color: rgb(182, 37, 37); font-size: 15px;">Your verification has not been successful. Please contact our call center for further assistance</p>
                                </div>
                            </div>
                            <br>
                        </div>

                        <div class="text-center mb-3">
                            <button type="button" class="btn w-md text-white" onclick="window.location='{{ url("/") }}'" style="float: right;background-color: #93186c; border-color: #93186c;">Ok</button>

                        </div>

                    </div>
                </form>
                <br><br><br>
            </div>
        </div>
    </div>


    @endsection

    @section('script')

    <script>
      
        $('#BankName').on('change', function() {

            var price = $(this).children('option:selected').data('price');
            $('#branchcode').val(price);

            var value = $(this).val();
            if (value === 'other') { // Change this condition based on which option should show the div
                $('#otherBank').show();
            } else {
                $('#otherBank').hide();
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            var message = "<?= Session::has('message') ? Session::get('message'): null  ?>";
            if(message != null && message != ''){
                $("#btn-hidden-popup").click();
            }
        });
    </script>


    <!-- jQuery -->

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('fileInput');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            // Prevent default behaviors for drag events
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = 'blue';
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = '#ccc';
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.style.borderColor = '#ccc';

                // Handle the dropped files
                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    // Show the name of the first file
                    fileNameDisplay.textContent = files[0].name;
                } else {
                    fileNameDisplay.textContent = '';
                }
            }

            // Trigger file input when drop zone is clicked
            dropZone.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle file input change event
            fileInput.addEventListener('change', function() {
                const files = fileInput.files;
                handleFiles(files);
            });
        });
    </script>



    @endsection