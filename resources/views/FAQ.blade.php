@extends('layouts.master-getstarted')

@section('css')

    <style>
        .heading-fica-id {
            height: 10%;
            background-image: linear-gradient(#0e425b, #056895);
            color: #fff
        }

        #p {
            color: #000;
        }

        h1 {
            color: #056895
        }

        @media .myselect (max-width: 350px) {
            body {
                width: 350px;
            }
        }
    </style>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection

@section('title')
    @lang('translation.FAQs')
@endsection

@section('body')

    <body style="background-color: rgb(240, 240, 240)">
    @endsection

    @section('content')

        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card overflow-hidden">

                            <div style="background-image: linear-gradient(#0e425b, #056895);">
                                <div class="row" style="margin-top: 1%;margin-left: 5%;">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Frequently Asked Questions (FAQ)</h5>
                                            <p>Looking for more information? Just search using the dropdown
                                                below...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-3">
            
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a type="button" onclick="window.history.back()">Fica</a></li>
                                        <li class="breadcrumb-item text-decoration-underline" style="font-weight: 500"><a
                                                href="javascript: void(0);">FAQ</a></li>
                                    </ol>
            
                                </div>
                            </div>

                            <form action="#" method="post" id="faq">

                                <div class="row justify-content-center">
                                    <div class="col-sm-6 mt-3" style="margin-left: 10%; margin-bottom: 2%;">
                                        <select class="myselect" style="width: 90%;"
                                            title="Please select an option..." id="select-faq" name="faqList"
                                            data-show-subtext="false" data-live-search="true"
                                            onchange="showHide(this)">

                                            <option data-hidden="true">Select an option</option>
                                            <option value="1">{{ $question1 }}</option>
                                            <option value="2">{{ $question2 }}</option>
                                            <option value="3">{{ $question3 }}</option>
                                            <option value="4">{{ $question4 }}</option>
                                            <option value="5">{{ $question5 }}</option>
                                            <option value="6">{{ $question6 }}</option>
                                            <option value="7">{{ $question7 }}</option>
                                            <option value="8">{{ $question8 }}</option>
                                            <option value="9">{{ $question9 }}</option>
                                            <option value="10">{{ $question10 }}</option>
                                            <option value="11">{{ $question11 }}</option>
                                            <option value="12">{{ $question12 }}</option>
                                            <option value="13">{{ $question13 }}</option>
                                            <option value="14">{{ $question14 }}</option>
                                            <option value="15">{{ $question15 }}</option>
                                            <option value="16">{{ $question16 }}</option>
                                            <option value="17">{{ $question17 }}</option>
                                            <option value="18">{{ $question18 }}</option>
                                            <option value="19">{{ $question19 }}</option>
                                        </select>
                                    </div>
                                </div>

                                <br>

                                <div class="dropdown-options"
                                    style="padding-top: 5%;padding-left: 5%;padding-right: 5%;padding-bottom: 5%;">
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="1">
                                        {{ $answer1 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="2">
                                        {{ $answer2 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="3">
                                        {{ $answer3 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="4">
                                        {{ $answer4 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="5">
                                        {{ $answer5 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="6">
                                        {{ $answer6 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="7">
                                        {{ $answer7 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="8">
                                        {{ $answer8 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="9">
                                        {{ $answer9 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="10">
                                        {{ $answer10 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="11">
                                        {{ $answer11 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="12">
                                        {{ $answer12 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="13">
                                        {{ $answer13 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="14">
                                        {{ $answer14 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="15">
                                        {{ $answer15 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="16">
                                        {{ $answer16 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="17">
                                        {{ $answer17 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="18">
                                        {{ $answer18 }}
                                    </div>
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="19">
                                        {{ $answer19 }}
                                    </div>

                                </div>

                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
    @endsection

    @section('script')
    
    <script>
        function showHide(elem) {
            if (elem.selectedIndex !== 0) {
                //hide the divs
                for (var i = 0; i < divsO.length; i++) {
                    divsO[i].style.display = 'none';
                }
                //unhide the selected div
                document.getElementById(elem.value).style.display = 'block';
            }
        }

        window.onload = function() {
            //get the divs to show/hide
            divsO = document.getElementById("faq").getElementsByClassName('show-hide');
        };
    </script>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>

    @endsection