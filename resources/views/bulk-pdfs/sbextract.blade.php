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
            font-family: 'Arial', serif;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
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
            height: 80px;
            background-color: {{$font_colour}};
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


            .image-div .logo {
            width:  350px;
            height:  120px;
        }

        .image-div .logo2{
            width:  350px;
            height:  150px;
            object-fit: cover; /* Ensure the image covers the div */
            position: absolute;

            right: 20px; /* Distance from the right edge */
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
            height: 80px;
            width: 100%;
            text-align: center;
            margin-bottom: 5px;
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
    <div class="mt-3">
    </div>

    <div class="content2 mt-5">

        <div class="image-div mt-5">

            <img class="logo" src="{{$Logo}}" alt="Description of image">
            <img class="logo2" src="assets/images/PoweredBy.png" alt="Description of image">

        </div>
    </div>
    <div class="content">


    <div class="report-header mt-5">

        <div class="text-center heading-fica-id mb-2">
            <div class="text-center">
                <h1 class=""
                    style="color: #fff; padding-top:10px;padding-bottom: 5px; margin-left:4px;">
                    Due Diligence Report
                </h1>
            </div>
        </div>
        <table id="" class="table table-hover">

            <tbody>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Extracted By :
                    </td>
                    <td style="font-size:22px;">

                    </td>
                    <td  style="font-weight: bold; font-size:22px;">
                        Extracted For:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['FirstName']}} {{$data['SURNAME']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Date of Report:
                    </td>
                    <td style="font-size:22px;">
                        {{$today}}

                    </td>
                    <td  style="font-weight: bold; font-size:22px;">
                        Identity Number:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['IDNUMBER']}}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>


        <div class="heading-fica-id mb-2">
        <h2 class="font-size-24"
        style="color: #fff;display:flex; margin-top:66px; margin-left:6px;">Facial Recognition</h2>
    </div>


  <table  id="personaldetails"  class="table table-hover mt-2" style="align-items: center; text-align:center; position: relative;">
            <tbody>
                <tr>
                    <th style="border: none;" class="align-middle"><h2 style="font-weight: normal;">DHA Captured Photo</h2></th>
                      </tr>
                <tr>

                    <td style="border: none;">

                        <img align="middle" src="data:image/png;base64,{{ $ConsumerIDPhotos['IDPhoto']}}" alt="" style="height:18%; width:18%;"  class="auth-logo-light" >
                    </img>
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

                        <img src="data:image/png;base64,{{ $tick}}" style="width:70px;height:70px;margin-left: 130px;" class="img-fluid" alt="Image 1">

                        <!-- icond should be displayed here -->
                            
                        </div>
                    

                    <div class="text-center image-container4 mt-3 mb-2" style="display: flex;">


                        <h2 style="font-weight: normal; font-size:20px;"><img src="data:image/png;base64,{{ $tick}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">Verification checks completed successfully.
                          <img src="data:image/png;base64,{{ $cross}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">Verification checks did not complete successfully.
                          <img src="data:image/png;base64,{{ $question}}" style="width:30px;height:30px;margin-left: 5px;margin-right: 10px;" class="img-fluid" alt="Image 2">No response from Verification checks.</h2>
                </div>
                </div>



  

    <div class="section">

            <table id="" class="table table-hover">
            <colgroup>
                <col style="width: 30%;">
                <col style="width: 40%;">
                <col style="width: 30%;">
                </colgroup>
                <tbody>
                    <tr class="heading-fica-id">
                        <th style="color: #fff; font-size:22px;" >
                            User Input Details
                        </th>
                        <th style="color: #fff; font-size:22px;" >
                            Result
                        </th>
                        <th style="color: #fff; font-size:22px;" >
                            Verified
                        </th>
                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:22px;">
                            Full Name(s):
                        </td>
                        <td style="font-size:22px;">
                            {{$data['FirstName']}} {{$data['SURNAME']}}
                        </td>
                        <td style="font-size:22px;">
                            {{$data['fullnamesmatch']}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:22px;">
                            Email:
                        </td>
                        <td style="font-size:22px;">
                            {{$data['Email']}}
                        </td>
                        <td style="font-size:22px;">
                            {{$data['emailmatch']}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:22px;">
                            Phone (W):
                        </td>
                        <td style="font-size:22px;">
                            {{$inputworknumber}}
                        </td>
                        <td style="font-size:22px;">
                            {{$data['workmatch']}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:22px;">
                            Phone (H):
                        </td>
                        <td style="font-size:22px;">
                            {{$inputHomenumber}}
                        </td>
                        <td style="font-size:22px;">
                            {{$data['homematch']}}
                        </td>

                    </tr>
                    <tr>
                        <td  style="font-weight: bold; font-size:22px;">
                            Phone (C):
                        </td>
                        <td style="font-size:22px;">
                            {{$inputcellnumber}}
                        </td>
                        <td style="font-size:22px;">
                            {{$data['cellmatch']}}
                        </td>

                    </tr>
                </tbody>
            </table>

    </div>

    <div class="section">
        <table id="" class="table table-hover">
            <colgroup>
                <col style="width: 30%;">
                <col style="width: 40%;">
                <col style="width: 30%;">
              </colgroup>
            <tbody>
                <tr class="heading-fica-id">
                    <th style="width: 30%;color: #fff; font-size:22px;" >
                        Bank Account Verification (Realtime)
                    </th>
                    <th style="color: #fff; font-size:22px;" >
                        Result
                    </th>
                    <th style="width: 30%;color: #fff; font-size:22px;" >
                        Verified
                    </th>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        AVS Status:
                    </td>
                    <td style="font-size:22px;">
                        {{$avs}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Branch Code:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['Branch_code']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Holder:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['Account_name']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Bank Name:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['Bank_name']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Exists:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['ACCOUNT_OPEN']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Initials Match:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['INITIALS']}}
                    </td>
                    <td style="font-size:22px;">
                        {{$data['INITIALSMATCH']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Surname Match:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['SURNAME']}}
                    </td>
                    <td style="font-size:22px;">
                        {{$data['SURNAMEMATCH']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        ID Number Match:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['IDNUMBER']}}
                    </td>
                    <td style="font-size:22px;">
                        {{$data['IDNUMBERMATCH']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Email Address Match:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['Email']}}
                    </td>
                    <td style="font-size:22px;">
                        {{$data['EMAILMATCH']}}
                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Type Match:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['ACCOUNT_OPEN']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Dormant:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['ACCOUNTDORMANT']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Open Three Months:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['ACCOUNTOPENFORATLEASTTHREEMONTHS']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
                <tr>
                    <td  style="font-weight: bold; font-size:22px;">
                        Account Accepts Debits:
                    </td>
                    <td style="font-size:22px;">
                        {{$data['ACCOUNTACCEPTSDEBITS']}}
                    </td>
                    <td style="font-size:22px;">

                    </td>
                </tr>
            </tbody>
        </tbody>

    </div>

    
 

</div></body></html>

