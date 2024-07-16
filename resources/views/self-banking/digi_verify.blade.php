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

                        <div style="background-image: linear-gradient(#93186c, #93186c);">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-4">
                                        <h5 class="text-white">Self Service Banking</h5>
                                        <p>Digital Verification Step</p>
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


                                <form method="post" action="{{ route('agree-selfbanking-tnc') }}" id="sb-tnc-form">
                                @csrf
                                    <div class="row">
                                        Digital Verification
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