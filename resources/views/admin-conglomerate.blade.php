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
                                        <h5 class="text-white">Edit a conglomerate details.</h5>
                                        <p>Use the fields below to edit the current company/business details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    @if (Session::get('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{-- {{ Session::get('success') }} --}}
                                            Conglomerate details have been changed.
                                        </div>
                                    @endif

                                    <form class="form-horizontal" method="POST" action="{{ route('edit-details') }}", enctype="multipart/form-data">

                                        @csrf
                                        <div class="row">
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
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Trading Name:</label>
                                                    <input class="form-control" type="hidden" id="CustomerId"
                                                        name="CustomerId" value="{{ $CustomerId }}">

                                                    <input class="form-control" type="text" id="TradingName"
                                                        name="TradingName" placeholder="Trading Name"
                                                        style="padding-left: 1.75rem;" value="{{ $TradingName }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Registered Name:</label>
                                                    <input class="form-control" type="text" id="RegistrationName"
                                                        name="RegistrationName" placeholder="Registered Name"
                                                        style="padding-left: 1.75rem;" value="{{ $RegistrationName }}">

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Registration Number:</label>
                                                    <input class="form-control" type="text" id="RegistrationNumber"
                                                        name="RegistrationNumber" placeholder="Registration Number"
                                                        style="padding-left: 1.75rem;" value="{{ $RegistrationNumber }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">VAT Number:</label>
                                                    <input class="form-control" type="text" id="VATNumber" name="VATNumber" placeholder="Enter a VAT number" value="{{ $VATnumber }}" required>

                                                </div>
                                                
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Branch Location:</label>
                                                    <input class="form-control" type="text" id="BranchLocation"
                                                        name="BranchLocation" placeholder="Branch Location"
                                                        style="padding-left: 1.75rem;" value="{{ $BranchLocation }}">
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Physical Address:</label>
                                                    <input class="form-control" type="text" id="PhysicalAddress"
                                                        name="PhysicalAddress" placeholder="Physical Address"
                                                        style="padding-left: 1.75rem;" value="{{ $PhysicalAddress }}">

                                                </div>
                                                
                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-3">

                                                    <label class="form-label">Business Type:</label>
                                                    <input class="form-control" type="text" id="TypeOfBusiness"
                                                        name="TypeOfBusiness" placeholder="Business Type"
                                                        style="padding-left: 1.75rem;" value="{{ $TypeOfBusiness }}">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Telephone Number:</label>
                                                    <input class="form-control" type="text" id="TelephoneNumber"
                                                        name="TelephoneNumber" placeholder="Telephone Number"
                                                        style="padding-left: 1.75rem;" value="{{ $TelephoneNumber }}">

                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                
                                                    <label class="form-label">Client Logo:</label>
                                                    <input class="form-control" type="file" id="Client_logo" name="Client_logo" placeholder="Upload a logo" >
                                                    @if ($Logo != null)
                                                    <img src="{{ asset('assets/logo') . '/' . $CustomerId . '/' . $Logo }}" alt="img" class="image" height="50px" width="50px">
                                                    @endif
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Client Icon:</label>
                                                    <input class="form-control" type="file" id="Client_icon" name="Client_icon" placeholder="Upload an icon">
                                                    @if ($Icon != null)
                                                    <img src="{{ asset('assets/logo') . '/' . $CustomerId . '/' . $Icon }}" alt="img" class="image" height="50px" width="50px">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                
                                                    <label class="form-label">Client Font Code:</label>
                                                    <input class="form-control" type="text" id="fontcode" name="fontcode" placeholder="Enter a font # code" value="{{ $fontcode }}">

                                                    <br> <br>


                                                </div>

                                                <!-- <div class="mb-3">

                                                    <input type="checkbox"  name="apicheck[]" value="AVS">
                                                    <label class="form-label">AVS</label>

                                                    &nbsp; &nbsp;
                                                    
                                                    <input type="checkbox" name="apicheck[]" value="KYC">
                                                    <label class="form-label">KYC</label>

                                                    &nbsp; &nbsp;

                                                    
                                                    <input type="checkbox"  name="apicheck[]" value="Compliance">
                                                    <label class="form-label">Compliance</label>

                                                    &nbsp; &nbsp;
                                                   
                                                </div> -->

                                                <div class="mb-3">
                                                    <?php foreach ($tabs as $key => $value) { 
                                                        $checked = in_array($value->Id, $customerTabs) ? "checked" : "" ;
                                                    ?>
                                                        <input type="checkbox"  name="tab[]" value="{{$value->Id}}" {{$checked}}>
                                                        <label class="form-label">{{ $value->Name }}</label>
                                                        &nbsp; &nbsp; 
                                                    <?php }?>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row justify-content-center mt-3 mb-0">

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="submit" id="submit"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                        class="btn btn-primary w-lg waves-effect waves-light">Save</button>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="button" id="clearall" name="clearall"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e"
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
