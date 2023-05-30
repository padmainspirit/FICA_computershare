@extends('layouts.master-display')

@section('title')
    @lang('translation.Edit_Details')
@endsection

@section('css')



@endsection

@section('content')

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card overflow-hidden">

                        <div style="background-image: linear-gradient(#0e425b, #056895);">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-white p-3">
                                        <h5 class="text-white">Edit a users details.</h5>
                                        <p>Use the fields below to edit the current user's login details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <form class="form-horizontal" method="POST" action="{{ route('edit-customer') }}">

                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">First Name:</label>
                                                    <input class="form-control" type="text" id="FirstName" name="FirstName" placeholder="First Name"
                                                    style="padding-left: 1.75rem;" value="{{ $FirstName }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">ID Number:</label>
                                                    <input class="form-control" type="text" id="IDNumber" name="IDNumber" placeholder="ID Number"
                                                    style="padding-left: 1.75rem;" value="{{ $IDNumber }}">

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Last Name:</label>
                                                    <input class="form-control" type="text" id="LastName" name="LastName" placeholder="Last Name"
                                                    style="padding-left: 1.75rem;" value="{{ $LastName }}">

                                                </div>
                                                
                                                <div class="mb-3">

                                                    <label class="form-label">Email Address:</label>
                                                    <input class="form-control" type="text" id="Email" name="Email" placeholder="Email Address"
                                                    style="padding-left: 1.75rem;" value="{{ $Email }}">

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Password:</label>
                                                    <input class="form-control" type="text" id="Password" name="Password" placeholder="Password"
                                                    style="padding-left: 1.75rem;" value="{{ $Password }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Is Restricted:</label>

                                                    <select class="form-select" name="IsRestricted" id="IsRestricted"
                                                    style="padding-left: 1.75rem;" required>
                                                    
                                                        <option selected disabled>Select</option>

                                                        <option value=1
                                                            {{ isset($IsRestricted) && $IsRestricted == 1 ? 'selected' : '' }}>
                                                            YES
                                                        </option>

                                                        <option value=0
                                                            {{ isset($IsRestricted) && $IsRestricted == 0 ? 'selected' : '' }}>
                                                            NO
                                                        </option>

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Phone Number:</label>
                                                    <input class="form-control" type="text" id="PhoneNumber" name="PhoneNumber" placeholder="Phone Number"
                                                    style="padding-left: 1.75rem;" value="{{ $PhoneNumber }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Most recent OTP:</label>
                                                    <input class="form-control" type="text" id="" name="" placeholder="OTP Code"
                                                    style="padding-left: 1.75rem;" value="{{ $OTP }}">

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row justify-content-center mt-3 mb-0">

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="submit" id="submit"
                                                        style="background-color: #93186c; border-color: #93186c"
                                                        class="btn btn-primary w-lg waves-effect waves-light">Save</button>
                                                </div>
                                            </div>
        
                                            {{-- <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="button" id="clearall" name="clearall"
                                                        style="background-color: #93186c; border-color: #93186c"
                                                        class="btn btn-danger w-lg waves-effect waves-light">Clear</button>
                                                </div>
                                            </div> --}}
        
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                </div>
            </div>
        </div>
    </div>    

@endsection

@section('script')

    {{-- <script>
        function clearAll() {
            document.getElementById("FirstName").value = '';
            document.getElementById("LastName").value = '';
            document.getElementById("IDNumber").value = '';
            document.getElementById("Email").value = '';
        }

        var btn = document.getElementById("clearall");   

        btn.addEventListener("click", clearAll);
    </script> --}}

@endsection