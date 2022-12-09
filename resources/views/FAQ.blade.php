@extends('layouts.master-getstarted')

@section('title')
    @lang('translation.FAQs')
@endsection

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

@section('content')
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card overflow-hidden">

                        <div style="background-image: linear-gradient(#93186c, #93186c);">
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
                                    <li class="breadcrumb-item"><a type="button"
                                            onclick="window.history.back()">Previous</a></li>
                                    <li class="breadcrumb-item text-decoration-underline" style="font-weight: 500"><a
                                            href="javascript: void(0);">FAQ</a></li>
                                </ol>

                            </div>
                        </div>

                        <form action="#" method="post" id="faq">

                            <div class="row justify-content-center">
                                <div class="col-sm-6 mt-3" style="margin-left: 10%; margin-bottom: 2%;">
                                    <select class="myselect" style="width: 90%;" title="Please select an option..."
                                        id="select-faq" name="faqList" data-show-subtext="false" data-live-search="true"
                                        onchange="showHide(this)">

                                        <option data-hidden="true">Select an option</option>

                                        @foreach ($Questions as $item)
                                            <option value="{{ $item->FAQ_ID }}">{{ $item->Question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>

                            <div class="dropdown-options"
                                style="padding-top: 5%;padding-left: 5%;padding-right: 5%;padding-bottom: 5%;">

                                @foreach ($Questions as $item)
                                    <div class="show-hide" style="display: none; text-align: justify;"
                                        id="{{ $item->FAQ_ID }}">
                                        {{ $item->Answer }}
                                    </div>
                                @endforeach

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
