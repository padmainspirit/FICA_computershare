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
                                    <form class="form-horizontal" method="POST" action="{{ route('admin-customer') }}">

                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Trading Name:</label>
                                                    <input class="form-control" type="text" id="TradingName" name="TradingName" placeholder="Enter a trading name" required>
                                                    <span id="error-tradingname" class="text-danger" role="alert">
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Registration Name:</label>
                                                    <input class="form-control" type="text" id="RegistrationName" name="RegistrationName" placeholder="Enter a registration name" required>
                                                    <span id="error-regname" class="text-danger" role="alert">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Registration Number:</label>
                                                    <input class="form-control" type="text" id="RegistrationNumber" name="RegistrationNumber" placeholder="Enter a registration number" required>
                                                    <span id="error-regnum" class="text-danger" role="alert">
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">VAT Number:</label>
                                                    <input class="form-control" type="text" id="VATNumber" name="VATNumber" placeholder="Enter a VAT number" required>
                                                    <span id="error-vatnum" class="text-danger" role="alert">
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
                                                    <span id="error-phyadd" class="text-danger" role="alert">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Type of Business:</label>
                                                    <input class="form-control" type="text" id="TypeOfBusiness" name="TypeOfBusiness" placeholder="Enter a type of business" required>
                                                    <span id="error-tob" class="text-danger" role="alert">
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Telephone Number:</label>
                                                    <input class="form-control" type="text" id="TelephoneNumber" name="TelephoneNumber" placeholder="Enter a telephone number" required>
                                                    <span id="error-telnum" class="text-danger" role="alert">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Client Logo:</label>
                                                    <input class="form-control" type="file" id="Client_logo" name="Client_logo" placeholder="Upload a logo" >
                                                    <span id="error-logo" class="text-danger" role="alert">
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">Client Icon:</label>
                                                    <input class="form-control" type="file" id="Client_icon" name="Client_icon" placeholder="Upload an icon">
                                                    <span id="error-icon" class="text-danger" role="alert">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label class="form-label">Client Font Code:</label>
                                                    <input class="form-control" type="text" id="fontcode" name="fontcode" placeholder="Enter a font # code">

                                                    <br> <br>


                                                </div>

                                                <div class="mb-3">

                                                    <input type="checkbox"  name="apicheck[]" value="AVS" checked>
                                                    <label class="form-label">AVS</label>

                                                    &nbsp; &nbsp;
                                                    
                                                    <input type="checkbox" name="apicheck[]" value="KYC" checked>
                                                    <label class="form-label">Facial</label>

                                                    &nbsp; &nbsp;

                                                    
                                                    <input type="checkbox"  name="apicheck[]" value="Compliance" checked>
                                                    <label class="form-label">Compliance</label>

                                                    &nbsp; &nbsp;
                                                   
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

{{-- <script type="text/javascript">

        $('#fileUpload-bank-model').on('submit', function(e) {
            e.preventDefault();
            $('#error-initials').hide();
            $('#error-surname').hide();
            $('#error-acc-number').hide();
            $('#error-bank-name-dd').hide();
            $('#error-BankTypeid').hide();
            $('#error-branch').hide();
            var form_data = new FormData(this);
            $.ajax({
                url: '{{ route('proofofbank') }}'
                , method: 'POST'
                , data: form_data
                , processData: false
                , contentType: false
                , beforeSend: function() {
                    // document.querySelector("#loader-address-model").style.visibility =
                    //     "visible";
                }
                , complete: function() {
                    // document.querySelector("#loader-address-model").style.display = "none";
                }
                , success: function(response) {
                    if (response.data.status) {
                        console.log(response.data);
                        console.log('PASSED');
                        // $('#bankMessage').text(response.msg);
                        $("#btn-hidden-bank-modal").click();
                    } else {
                        $('#errorMessage').text(response.data.message);
                        // $('#error-message-bank').text(response.data.message);
                        $("#btn-hidden-bank-failed").click();

                        // $('#address-failed-model').text(response.data.message);
                        console.log(response.data);
                        console.log('FAILED');
                    }

                    //location.reload();

                }
                , error: function(response) {
                    console.log('ERROR');
                    var errorResBank = response.responseJSON.errors;
                    console.log(errorResBank);
                    for (var key in errorResBank) {
                        var value = errorResBank[key][0];
                        $('#error-' + key).html(value);
                        $('#error-' + key).show();
                    }
                    // $("#btn-hidden-failed").click();
                }

            });

            $("#btnYes-cancel").click(function() {
                location.reload();

            });

            $("#btn-bank-refresh2").click(function() {
                location.reload();
            });
        });

    });

</script> --}}

@endsection
