@extends('layouts.master-display')

@section('title')
    @lang('translation.Customers')
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
                                        <h5 class="text-white">Create a new customer.</h5>
                                        <p>To on-board a new customer onto the system, please fill in all the fields.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    @if (Session::get('success'))
                                        <div class="alert alert-success" role="alert">
                                        A new company has been created
                                        </div>
                                    @endif

                                    <form class="form-horizontal" method="POST" action="{{ route('admin-customer') }}">

                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Trading Name:</label>
                                                    <input class="form-control" type="text" id="TradingName" name="TradingName" placeholder="Enter a trading name" required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Registration Name:</label>
                                                    <input class="form-control" type="text" id="RegistrationName" name="RegistrationName" placeholder="Enter a registration name" required>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Registration Number:</label>
                                                    <input class="form-control" type="text" id="RegistrationNumber" name="RegistrationNumber" placeholder="Enter a registration number" required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">VAT Number:</label>
                                                    <input class="form-control" type="text" id="VATNumber" name="VATNumber" placeholder="Enter a VAT number" required>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Branch Location:</label>
                                                    <input class="form-control" type="text" id="BranchLocation" name="BranchLocation" placeholder="Enter a branch location" required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Physical Address:</label>
                                                    <input class="form-control" type="text" id="PhysicalAddress" name="PhysicalAddress" placeholder="Enter a physical address" required>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Type of Business:</label>
                                                    <input class="form-control" type="text" id="TypeOfBusiness" name="TypeOfBusiness" placeholder="Enter a type of business" required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Telephone Number:</label>
                                                    <input class="form-control" type="text" id="TelephoneNumber" name="TelephoneNumber" placeholder="Enter a telephone number" required>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row justify-content-center mt-3 mb-0">

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="submit" id="submit"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                        class="btn btn-primary w-lg waves-effect waves-light">Create</button>
                                                </div>
                                            </div>
        
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="button" id="clearall" name="clearall"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                        class="btn btn-danger w-lg waves-effect waves-light">Clear</button>
                                                </div>
                                            </div>
        
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

    <script>
        function clearAll() {
            document.getElementById("TradingName").value = '';
            document.getElementById("RegistrationName").value = '';
            document.getElementById("RegistrationNumber").value = '';
            document.getElementById("VATNumber").value = '';
            document.getElementById("BranchLocation").value = '';
            document.getElementById("PhysicalAddress").value = '';
            document.getElementById("TypeOfBusiness").value = '';
            document.getElementById("TelephoneNumber").value = '';
        }

        var btn = document.getElementById("clearall");

        btn.addEventListener("click", clearAll);
    </script>

@endsection
