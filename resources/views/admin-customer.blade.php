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
                                    <form class="form-horizontal" method="POST" action="{{ route('admin-customer') }}" enctype="multipart/form-data">

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
                                                    <input class="form-control @error('TradingName') is-invalid @enderror" type="text" id="TradingName" name="TradingName" placeholder="Enter a trading name">

                                                   @error('TradingName')
                                                   <div class="mb-3" style="color: red">
                                                {{ $message }}
                                                 </div>
                                                @enderror
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Registration Name:</label>
                                                    <input class="form-control @error('RegistrationName') is-invalid @enderror" type="text" id="RegistrationName" name="RegistrationName" placeholder="Enter a registration name">
                                                    @error('RegistrationName')
                                                    <div class="mb-3" style="color: red">
                                                 {{ $message }}
                                                  </div>
                                                 @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Registration Number:</label>
                                                    <input class="form-control @error('RegistrationNumber') is-invalid @enderror" type="text" id="RegistrationNumber" name="RegistrationNumber" placeholder="Enter a registration number">
                                                    @error('RegistrationNumber')
                                                    <div class="mb-3" style="color: red">
                                                 {{ $message }}
                                                  </div>
                                                 @enderror
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">VAT Number:</label>
                                                    <input class="form-control @error('TradingName') is-invalid @enderror" type="text" id="VATNumber" name="VATNumber" placeholder="Enter a VAT number">
                                                    @error('VATNumber')
                                                    <div class="mb-3" style="color: red">
                                                 {{ $message }}
                                                  </div>
                                                 @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Branch Location:</label>
                                                    <input class="form-control" type="text" id="BranchLocation" name="BranchLocation" placeholder="Enter a branch location">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Physical Address:</label>
                                                    <input class="form-control @error('PhysicalAddress') is-invalid @enderror" type="text" id="PhysicalAddress" name="PhysicalAddress" placeholder="Enter a physical address">
                                                    @error('PhysicalAddress')
                                                   <div class="mb-3" style="color: red">
                                                {{ $message }}
                                                 </div>
                                                @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Type of Business:</label>
                                                    <input class="form-control @error('TypeOfBusiness') is-invalid @enderror" type="text" id="TypeOfBusiness" name="TypeOfBusiness" placeholder="Enter a type of business">
                                                    @error('TypeOfBusiness')
                                                    <div class="mb-3" style="color: red">
                                                 {{ $message }}
                                                  </div>
                                                 @enderror
                                                </div>

                                                <div class="mb-3">
                                                
                                                    <label class="form-label">Telephone Number:</label>
                                                    <input class="form-control @error('TelephoneNumber') is-invalid @enderror" type="text" id="TelephoneNumber" name="TelephoneNumber" placeholder="Enter a telephone number">
                                                    @error('TelephoneNumber')
                                                   <div class="mb-3" style="color: red">
                                                {{ $message }}
                                                 </div>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Client Logo:</label>
                                                    <input class="form-control @error('Client_logo') is-invalid @enderror" type="file" id="Client_logo" name="Client_logo" placeholder="Upload a logo" >
                                                    @error('Client_logo')
                                                   <div class="mb-3" style="color: red">
                                                {{ $message }}
                                                 </div>
                                                @enderror
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Client Icon:</label>
                                                    <input class="form-control @error('Client_icon') is-invalid @enderror" type="file" id="Client_icon" name="Client_icon" placeholder="Upload an icon">
                                                    @error('Client_icon')
                                                    <div class="mb-3" style="color: red">
                                                 {{ $message }}
                                                  </div>
                                                 @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Client Font Code:</label>
                                                    <input class="form-control" type="text" id="fontcode" name="fontcode" placeholder="Enter a font # code" value="{{ old('fontcode') }}">

                                                    <br> <br>


                                                </div>

                                                <!-- <div class="mb-3">

                                                    <input type="checkbox"  name="apicheck[]" value="AVS" checked>
                                                    <label class="form-label">AVS</label>

                                                    &nbsp; &nbsp;
                                                    
                                                    <input type="checkbox" name="apicheck[]" value="KYC" checked>
                                                    <label class="form-label">Facial</label>

                                                    &nbsp; &nbsp;

                                                    
                                                    <input type="checkbox"  name="apicheck[]" value="Compliance" checked>
                                                    <label class="form-label">Compliance</label>

                                                    &nbsp; &nbsp;
                                                   
                                                </div> -->

                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-3 mb-0">

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="submit" id="submit"
                                                        style="background-color: #93186c; border-color: #93186c"
                                                        class="btn btn-primary w-lg waves-effect waves-light">Create</button>
                                                </div>
                                            </div>
        
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <button type="button" id="clearall" name="clearall"
                                                        style="background-color: #93186c; border-color: #93186c"
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
            document.getElementById("Client_logo").value = '';
            document.getElementById("Client_icon").value = '';
            document.getElementById("fontcode").value = '';
            document.getElementById("avscheck").value = '';
            document.getElementById("kyccheck").value = '';
            document.getElementById("compcheck").value = '';
        }

        var btn = document.getElementById("clearall");

        btn.addEventListener("click", clearAll);
    </script>

@endsection
