@extends('layouts.master-display')


{{-- @section('title')
@lang('translation.Form_Wizard')
@endsection --}}


@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .hide,
        #testresult-btn,
        #idnumberResult {
            display: none;

        }

        .show {
            display: block;
        }

        table.mystyles {
            padding: 20px;
        }

        table.mystyles td {
            padding: 20px;
            text-align: center;
        }

        .show {
            display: block;
        }

        table.mystyles {
            padding: 20px;
        }

        table.mystyles td {
            padding: 20px;
            text-align: center;
        }

        .heading-fica-id {
            height: 10%;
            background-image: linear-gradient(#93186c, #93186c);
        }
    </style>
@endsection


@section('content')
    

    <body>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-NQSK80GP6J"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-NQSK80GP6J');

        </script>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHQR3RD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div class="main-content" style="margin-left: 0px;">
            <div class="page-content" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                <div class="row" id="card1" style="margin-left: 0px;margin-right: 0px;">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 0px;">

                                <div class="heading-fica-id mb-4">
                                    <div class="text-center">
                                        <h4 class="font-size-18"
                                            style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                            Self Service Banking Link
                                        </h4>
                                    </div>
                                </div>

                                

                                <form method="POST" action="{{ route('send-selfservicelink') }}" id="searchclient">

                                   
                                    @csrf

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="row">


                                           <div class="col-md-2">
                                                <div class="mb-3">

                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Link:</label>

                                                </div>
                                            </div>

                                            <div class="col-md-4 ">
                                                <div class="mb-3">
                                                    <div class="input-group" style="height: 27px; width: 225px;">

                                                        <div class="input-group" style="height: 27px; width: 225px;">
                                                            <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px;"
                                                                id="media" name="Media" onchange="selectedlink(this)">
                                                                <option value="" style="font-size: 12px;">
                                                                    Select
                                                                </option>

                                                                <option value="SMS"  @if(old("Media")=="SMS" ) selected @endif style="font-size: 12px;">
                                                                    SMS
                                                                </option>

                                                                <option value="Email" style="font-size: 12px;" @if(old("Media")=="Email" ) selected @endif>
                                                                    Email
                                                                </option>

                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>                                    

                                    <div class="col-lg-12">
                                        <div class="row" id="input_row" @if( old("Media")== null || old("Media")=="" ) style="display:none" @else style="display:block" @endif>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        id="email_label"  @if(old("Media")=="Email" ) style="display:block;font-size: 12px; color: rgb(0, 0, 0)" @else style="display:none" @endif>Email ID:</label>
                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                       id="phone_label" @if(old("Media")=="SMS" ) style="display:block; font-size: 12px; color: rgb(0, 0, 0)" @else style="display:none" @endif>Phone Number:</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input autocomplete="off" type="text" class="form-control input-sm"
                                                        id="Email" name="Email"
                                                        placeholder="Enter Email ID" value="" @if(old("Media")=="Email" ) style="display:block; height: 27px; width: 10px; padding-left: 24px; width: 225px; " @else style="display:none; height: 27px; width: 10px; padding-left: 24px; width: 225px; " @endif>
                                                    <input autocomplete="off" type="text" class="form-control input-sm"
                                                        id="PhoneNumber" name="PhoneNumber"
                                                        placeholder="Enter Contact Number" value="" @if(old("Media")=="SMS" ) style="display:block; height: 27px; width: 10px; padding-left: 24px; width: 225px; " @else style="display:none; height: 27px; width: 10px; padding-left: 24px; width: 225px;" @endif>
                                                </div>
                                            </div>
                                        </div>

                                    

                                    <span class="text-danger" id="error_msg" styel="display:none"></span><br/>
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <button type="submit" id="submit"
                                                    style="background-color: #93186c; border-color: #93186c"
                                                    class="btn btn-primary w-lg waves-effect waves-light">Search</button>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <button type="reset" id="clearall" name="clearall"
                                                    style="background-color: #93186c; border-color: #93186c"
                                                    class="btn btn-danger w-lg waves-effect waves-light" onclick="hidefields();">Clear</button>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                                
                                
                                
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
              

            </div>

        </div>
    </body>
@endsection

@section('script')
   
  


<script>
    

    $(document).ready(function() {
       // hidefields();

    });

    function hidefields(){
        $("#email_label").hide();
        $('#Email').hide();
        $("#phone_label").hide();        
        $('#PhoneNumber').hide();
    }

    function selectedlink(e)
    {
        hidefields();
        console.log(e);
        $('#input_row').show();
        if(e.value == 'SMS')
        { 
            $("#phone_label").show();        
            $('#PhoneNumber').show();
        }else if(e.value == 'Email'){
            $("#email_label").show();
            $('#Email').show();
        }else{
            $('#input_row').hide();
            return false;
        }
    } 

    
</script>
@endsection
