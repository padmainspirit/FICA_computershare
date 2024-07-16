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
                                        <h5 class="text-white">Welcome to self service banking</h5>
                                        <p>Please agree to the terms and conditions to continue the flow</p>
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
                                        <div class="col-12">
                                            <input class="form-check-input big-checkbox" type="hidden" value="{{ $sbid }}" name="sbid" style="width: 20px; height:20px;">

                                            <input class="form-check-input big-checkbox" type="checkbox" id="sb-tnc-checkbox" name="sb-tnc" style="width: 20px; height:20px;">
                                            <label class="form-check-label" for="tnc-checkbox" style="padding-left:15px;padding-right:15px;padding-top:5px; font-size: 12px; color: rgb(0, 0, 0);">
                                                Agree to the terms and conditions of Self Service banking
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