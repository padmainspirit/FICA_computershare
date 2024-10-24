<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Diligence Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css'" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" /> -->
    <style>

        body {
        font-family: 'Open Sans', sans-serif;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    table tbody tr {
    height: 20px;
    padding: 10px 0; /* Increase vertical padding for more space */
}
    .report-header {
        text-align: center;
        margin-bottom: 20px;
    }
    #table1 tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light grey for even rows */
            border: none;
}
#table2 tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light grey for even rows */
            border: none;
}

#table3 tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light grey for even rows */
            border: none;
}
#table4 tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light grey for even rows */
            border: none;
}
#table5 tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light grey for even rows */
            border: none;
}

    .section {
        margin-bottom: 20px;
    }
    .section-title {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 10px;
    }
    .section-content {
        margin-left: 20px;
    }
    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 0.8em;
        color: gray;
    }

    .heading-fica-id {
        height: 50px;
        background-color: #93206c;
    }
    .row {
        display: flex;
        justify-content: center;
        margin-bottom: 20px; /* Adjust the bottom margin as needed */
    }
    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        left: -20px;
        flex-wrap: wrap; /* This will allow images to wrap to the next line if necessary */
    }
    .image-container img {
        margin: 10px; /* Adjust the margin between images as needed */
        width: 80px;
        height: 80px;
    }
    #footer { position: fixed; right: 15px;  bottom: 10px; text-align: center;}
        #footer .page:after { content: counter(page, decimal); }
        @page { margin: 20px 30px 40px 50px; }

        .image-div {
    display: flex;
    align-items: center;  /* Vertical alignment */
    justify-content: space-between;  /* Distribute space between images */
    position: relative;
    padding: 0 20px;  /* Add padding to keep the images away from screen edges */
}

        .image-div .logo {
        width:  320px;
        height:  95px;
        object-fit: cover;
    }

    .image-div .logo2{
        width:  350px;
        height:  120px;
        object-fit: cover;
        position: absolute;
        right: 20px;
        transform: translateY(-50%);
    }





    .content {
        page-break-after: always;
    }


    .container2 {
        position: relative;
        display: flex;
        left:-200px;
        justify-content: flex-end;
        margin-top:25px;
        align-items: center;
        height: 600px; /* Full height */
        padding-right: 20px; /* Optional padding for spacing */
    }
    .footer2 {
        position: fixed;
        bottom: 0;
        height: 45px;
        width: 100%;
        text-align: center;
        margin-bottom: 8px;
        padding-top: 5px;

    }
    .footer2 p{
        font-size:19px;
        margin: 0;
    }


</style>

</head>
<body>

    <div class="footer2">
        <p>Inspirit Data Analytics Services(Pty) Ltd, an authorized agent of XDS.</p>
        <p>Copyright 2024 Inspirit Data Analytics Services(Pty) Ltd (Reg No: 2017653373)</p>
        <p>Powered by Xpert Decision Systems(XDS).</p>
        <p>XDS is registered with the National Credit Regulator - Reg# NCR-CB5</p>
    </div>
    <div id="footer">

        <h3 style="font-weight:unset;" class="page">Page </h3>
    </div>
    <div class="">
<br>
<br>
    </div>

    <div class="content2 mt-3" >

        <div class="image-div mt-4 mb-2">

            <img class="logo" src="assets/images/logo/computershare.png" alt="Description of image">
            <img class="logo2" src="assets/images/PoweredBy.png" alt="Description of image">

        </div>

    </div>
    <div class="content">

            <div class="text-center heading-fica-id">
                <h2 class=""
                    style="color: #fff; padding-top:10px;padding-bottom: 5px; margin-left:4px;">
                    Self Service Banking Report
                </h2>
            </div>
        <table id="table1" class="table table-hover mt-2" style="width: 100%; border-collapse: collapse; " >

            <tbody>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Extracted By :
                    </td>
                    <td style="font-size:20px;">

                    </td>
                    <td  style="font-weight: bold; font-size:20px;">
                        Extracted For:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['FirstName']}} {{$data['SURNAME']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Date of Report:
                    </td>
                    <td style="font-size:20px;">
                        {{$today}}

                    </td>
                    <td  style="font-weight: bold; font-size:20px;">
                        Identity Number:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['IDNUMBER']}}
                    </td>
                </tr>
            </tbody>
        </table>


            <div class="text-center heading-fica-id">
                <h2 class=""
                    style="color: #fff; padding-top:10px;padding-bottom: 5px; margin-left:4px;">
                    Flow Status Summary
                </h2>
            </div>

        <table id="table1" class="table table-hover mt-2" style="width: 100%; border-collapse: collapse; " >

            <tbody>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Date Started: :
                    </td>
                    <td style="font-size:20px;">
                        {{$data['CreatedOnDate']}}
                    </td>
                </tr>
                    <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Full names :
                    </td>
                    <td style="font-size:20px;">
                        {{$ha_name}} {{$ha_secondname}} {{$ha_surname}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Identity:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['IDNUMBER']}}

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Personal Information Captured:
                    </td>
                    <td style="font-size:20px;">
                        @if ($PersonalDetails=='1')
                            Passed
                        @elseif($PersonalDetails=='0')
                        In Progress
                        @elseif($PersonalDetails=='-2')
                        Failed
                        @else
                        Needs Review
                        @endif

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Banking Details:
                    </td>
                    <td style="font-size:20px;">
                        @if ($BankingDetails=='1')
                        Passed
                    @elseif($BankingDetails=='0')
                    In Progress
                    @elseif($BankingDetails=='-2')
                    Failed
                    @else
                    Needs Review
                    @endif

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Face view:
                    </td>
                    <td style="font-size:20px;">
                        @if ($DOVS=='1')
                        Passed
                    @elseif($DOVS=='0')
                    In Progress
                    @elseif($DOVS=='-2')
                    Failed
                    @else
                    Needs Review
                    @endif
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Flow Overall Status:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['FICAStatus']}}

                    </td>

                </tr>
            </tbody>
        </table>

                <div class="heading-fica-id mb-4">
                    <h2 class="font-size-24"
                    style="color: #fff; padding-top:10px;padding-bottom: 5px; margin-left:4px;">Screening Indicators</h2>
                </div>
                <div class="mb-2">

                    <div class="image-container2 mb-2" style = "display: inline-block; ">

                        @if ($PersonalDetails == '1')
                        <img src="data:image/png;base64,{{ $tick}}" style="width:55px;height:55px;margin-left: 155px;" class="img-fluid" alt="Image 2">

                    @elseif ($PersonalDetails == '-2')
                    <img src="data:image/png;base64,{{ $cross}}" style="width:55px;height:55px;margin-left: 155px;" class="img-fluid" alt="Image 2">

                     @else
                     <img src="data:image/png;base64,{{ $question}}" style="width:55px;height:55px;margin-left: 155px;" class="img-fluid" alt="Image 2">

                     @endif
                            @if ($BankingDetails == '1')
                                <img src="data:image/png;base64,{{ $tick}}" style="width:55px;height:55px;margin-left: 238px" class="img-fluid" alt="Image 2">

                            @elseif ($BankingDetails == '-2')
                            <img src="data:image/png;base64,{{ $cross}}" style="width:55px;height:55px;margin-left: 238px" class="img-fluid" alt="Image 2">

                             @else
                             <img src="data:image/png;base64,{{ $question}}" style="width:55px;height:55px;margin-left: 238px" class="img-fluid" alt="Image 2">

                             @endif


                             @if ($DOVS == '1')

                                <img src="data:image/png;base64,{{ $tick}}" style="width:55px;height:55px;margin-left: 240px" class="img-fluid" alt="Image 2">
                                @elseif ($DOVS == '-2')
                                <img src="data:image/png;base64,{{ $cross}}" style="width:55px;height:55px;margin-left: 240px" class="img-fluid" alt="Image 2">
                                 @else
                                 <img src="data:image/png;base64,{{ $question}}" style="width:55px;height:55px;margin-left: 240px" class="img-fluid" alt="Image 2">

                                @endif

                        </div>
                    <div class="image-container" style="display:flex;position: relative; top:17px;margin-left:-88px;">
                        <img src="data:image/png;base64,{{ $VerificationStaticPhoto}}" style="display:flex;width:140px;height:140px; margin-left: 210px;"  alt="Image 1">

                             <img src="data:image/png;base64,{{ $PaymentPhoto}}" style="display:flex;width:140px;height:140px;margin-left: 148px;"  alt="Image 3">

                             <img src="data:image/png;base64,{{ $FacialPhoto}}" style="display:flex;width:140px;height:140px;margin-left: 148px;"  alt="Image 4">

                    </div>
                    <div class="image-container3 justify-content-center mt-2" style="display:flex;position: relative; ">
                        <h1 style="display: inline-block;margin-left: 88px;font-weight:normal; font-size:26px">Personal Info</h1>
                             <h1 style="display: inline-block;margin-left: 200px;font-weight:normal; font-size:26px">Bank</h1>
                             <h1 style="display: inline-block;margin-left: 200px;font-weight:normal; font-size:26px">Face View</h1>

                    </div>

                    <div class="text-center image-container4 mt-3 mb-2" style="display: flex;">


                        <h2 style="font-weight: normal; font-size:20px;"><img src="data:image/png;base64,{{ $tick}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">Verification checks completed successfully.
                          <img src="data:image/png;base64,{{ $cross}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">Verification checks did not complete successfully.
                          <img src="data:image/png;base64,{{ $question}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">No response from Verification checks.</h2>
                </div>
                </div>






    <div class="section">

            <table id="table2" class="table table-hover" style="width: 100%; border-collapse: collapse; margin-bottom: 5px; margin-top:2px;">
            <colgroup>
                <col style="width: 40%;">
                <col style="width: 30%;">
                <col style="width: 30%;">
                </colgroup>
                <tbody>
                    <tr class="heading-fica-id">
                        <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 40%;" >
                            Personal Information Captured
                        </th>
                        <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 30%;" >
                            Result
                        </th>
                        <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 30%;" >
                            Verified
                        </th>
                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            First Name:
                        </td>
                        <td style="font-size:20px;">
                            {{$data['Fname']}}

                        </td>
                        <td style="font-size:20px;">
                            {{$namematch}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            Second Name:
                        </td>
                        <td style="font-size:20px;">
                            {{$data['SecName']}}
                        </td>
                        <td style="font-size:20px;">
                            {{$secnamematch}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            Third Name:
                        </td>
                        <td style="font-size:20px;">
                            {{$data['TName']}}
                        </td>
                        <td style="font-size:20px;">
                            {{$thirdnamematch}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            Surname:
                        </td>
                        <td style="font-size:20px;">
                            {{$data['Lname']}}
                        </td>
                        <td style="font-size:20px;">
                            {{$smatch}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            Email:
                        </td>
                        <td style="font-size:20px;">
                            {{$data['Email']}}
                        </td>
                        <td style="font-size:20px;">
                            {{$emailmatch}}
                        </td>

                    </tr>


                    <tr>
                        <td  style="font-weight: bold; font-size:20px;">
                            Phone (C):
                        </td>
                        <td style="font-size:20px;">
                            {{$data['PhoneNumber']}}
                        </td>
                        <td style="font-size:20px;">
                            {{$cellmatch}}
                        </td>

                    </tr>
                </tbody>
            </table>

    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" id="table5" style="width: 100%; border-collapse: collapse; margin-bottom: 5px; margin-top:2px;">

            <thead>
                <tr>
                    <th class="col-md-5 heading-fica-id" style="color:#ffffff;font-size:20px">SRN</th>
                    <th class="col-md-6 heading-fica-id" style="color:#ffffff;font-size:20px">Companies</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($SelfBankingCompanySRN as $CompanySRN)
                <tr>
                    <td style="text-transform: uppercase;width: 50%; font-size:20px;">{{ $CompanySRN->SRN }}</td>
                    <td style="width: 50%; font-size:20px;">{{ $CompanySRN?->companies }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="4">No exceptions found.</td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
    <div class="heading-fica-id" style="page-break-before: always;">
        <h3 class="font-size-24"
        style="color: #fff;display:flex; margin-left:6px;">Facial Recognition</h3>
    </div>
    <table id="personaldetails"  class="table table-hover mt-4 mb-2" style="background-color: transparent;width: 100%;align-items: center; text-align:center; position: relative;">
        <tbody>
            <tr>
                <th style="border: none;font-size:20px; font-weight:800;" class="align-middle"><h4 style="font-weight: normal;">DHA Captured Photo</h4></th>
                <th style="border: none;font-size:20px; font-weight:800;" class="align-middle"><h4 style="font-weight: normal;"></h4></th>
                  <th style="border: none;font-size:20px; font-weight:800;" class="align-middle"><h4 style="font-weight: normal;">Consumer Captured Photo</h4></th>
                </tr>
            <tr>
                <td style="border: none;">
                    @if ($data['ConsumerIDPhoto']=="")
                    <img src="assets/images/ImageNotFound.png" alt="" class="auth-logo-light" style="height:200px; width:160px;display: block; margin: auto">
                                </img>
                @else
                    <img align="middle" src="data:image/png;base64,{{ $data['ConsumerIDPhoto']}}" alt="" style="height:200px; width:160px;"  class="auth-logo-light" >
                @endif
                </img>
            </td>
            <td style="border: none;">
                @if ($DOVS == '1')

                                <img src="data:image/png;base64,{{ $tick}}" style="width:90px;height:90px;" class="img-fluid" alt="Image 2">
                                @elseif ($DOVS == '-2')
                                <img src="data:image/png;base64,{{ $cross}}" style="width:90px;height:90px;" class="img-fluid" alt="Image 2">
                                 @else
                                 <img src="data:image/png;base64,{{ $question}}" style="width:90px;height:90px;" class="img-fluid" alt="Image 2">

                                @endif

                    </td>
                <td style="border: none;">
                    @if ($data['ConsumerCapturedPhoto']=="")
                    <img src="assets/images/ImageNotFound.png" alt="" class="auth-logo-light" style="height:200px; width:160px;display: block; margin: auto">

                </img>
                    @else
                    <img align="middle" src="data:image/png;base64,{{ $data['ConsumerCapturedPhoto']}}" alt="" style="height:200px; width:160px;"  class="auth-logo-light" >
                </img>
                @endif
                        </td>




            </tr>


        </tbody>
    </table>

    <div class="section mt-2">
        <table id="table3" class="table table-hover" style="width: 100%; border-collapse: collapse; margin-bottom: 5px; margin-top:2px;">
            <colgroup>
                <col style="width: 40%;">
                <col style="width: 30%;">
                <col style="width: 30%;">
              </colgroup>
            <tbody>
                <tr class="heading-fica-id">
                    <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 40%;" >
                        Facial Recognition Biometric: Validated at Department of Home Affairs
                    </th>
                    <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 30%;" >

                    </th>
                    <th class="heading-fica-id" style="color: #fff; font-size:20px;width: 30%;" >

                    </th>
                </tr>
                <tr>

                    <td  style="font-weight: bold; font-size:20px;">
                        Liveliness Detection:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['LivenessDetectionResult']}}

                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        ID No. Status:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['IDNUMBERMATCH']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Deceased Status:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['DeceasedStatus']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Birth Date:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['HA_DateOfBirth']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Gender:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['HA_Gender']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Title:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['TitleDesc']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Marital Status:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['MaritalStatusDesc']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Home Cellphone No:
                    </td>

                    <td style="font-size:20px;">
                        {{$data['CellularNo']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Home Telephone No:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['HomeTelephoneNo']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Work Telephone No:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['WorkTelephoneNo']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Postal Address:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['PostalAddress']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Residential Address:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ResidentialAddress']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>

            </tbody>
        </tbody>

    </div>

    <div class="section">
        <table id="table4" class="table table-hover" style="width: 100%; border-collapse: collapse; margin-bottom: 5px; margin-top:2px;">
            <colgroup>
                <col style="width: 40%;">
                <col style="width: 30%;">
                <col style="width: 30%;">
              </colgroup>
            <tbody>
                <tr class="heading-fica-id">
                    <th class="heading-fica-id" style="color: #fff; font-size:20px;width:40%;" >
                        Bank Account Verification (Realtime)
                    </th>
                    <th class="heading-fica-id" style="color: #fff; font-size:20px;width:30%;" >
                        Result
                    </th>
                    <th class="heading-fica-id" style="width: 30%;color: #fff; font-size:20px;width:30%;" >
                        Verified
                    </th>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        AVS Status:
                    </td>
                    <td style="font-size:20px;">
                        {{$avs}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Branch Code:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['Branch_code']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Holder:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['Account_name']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Bank Name:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['Bank_name']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Exists:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ACCOUNT_OPEN']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Initials Match:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['INITIALS']}}
                    </td>
                    <td style="font-size:20px;">
                        @if ($data['INITIALSMATCH']=='Yes')
                            Matched
                        @elseif ($data['INITIALSMATCH']=='No')
                        Unmatched
                        @else
                        {{$data['INITIALSMATCH']}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Surname Match:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['SURNAME']}}
                    </td>
                    <td style="font-size:20px;">

                        @if ($data['SURNAMEMATCH']=='Yes')
                        Matched
                    @elseif ($data['SURNAMEMATCH']=='No')
                    Unmatched
                    @else
                    {{$data['SURNAMEMATCH']}}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        ID Number Match:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['IDNUMBER']}}
                    </td>
                    <td style="font-size:20px;">
                        @if ($data['IDNUMBERMATCH']=='Yes')
                        Matched
                    @elseif ($data['IDNUMBERMATCH']=='No')
                    Unmatched
                    @else
                    {{$data['IDNUMBERMATCH']}}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Email Address Match:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['Email']}}
                    </td>
                    <td style="font-size:20px;">

                        @if ($data['EMAILMATCH']=='Yes')
                        Matched
                    @elseif ($data['EMAILMATCH']=='No')
                    Unmatched
                    @else
                    {{$data['EMAILMATCH']}}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Type Match:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ACCOUNT_OPEN']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Dormant:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ACCOUNTDORMANT']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Open Three Months:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ACCOUNTOPENFORATLEASTTHREEMONTHS']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:20px;">
                        Account Accepts Debits:
                    </td>
                    <td style="font-size:20px;">
                        {{$data['ACCOUNTACCEPTSDEBITS']}}
                    </td>
                    <td style="font-size:20px;">

                    </td>
                </tr>
            </tbody>
        </tbody>

    </div>




</div></body></html>
