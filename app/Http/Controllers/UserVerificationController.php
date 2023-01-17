<?php

namespace App\Http\Controllers;

use App\Models\AVS;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Str;

use App\Models\CustomerUser;
use DOMDocument;
use App\Models\Consumer;
use App\Models\ConsumerIdentity;
use App\Models\FICA;
use App\Models\DOVS;
use App\Models\KYC;
use App\Models\Address;
use App\Models\LookupDatas;
use App\Models\APILogs;
use App\Models\Customer;
use App\Models\Compliance;
use App\Models\ConsumerComplianceSanction;
use App\Models\ConsumerComplianceEntityAdditional;
use App\Models\BankAccountType;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class UserVerificationController extends Controller
{
    protected $xdsusername;
    protected $xdspassword;

    //API ID
    protected $KYC; //KYC
    protected $AVS; //AVS
    protected $DOVS; //DOVS
    protected $COMPLIANCE; //COMPLIANCE

    // $kycLookup = LookupDatas::where('ID', '=', $this->KYC)->first();
    // $avsLookup = LookupDatas::where('ID', '=', $this->AVS)->first();
    // $dovsLookup = LookupDatas::where('ID', '=', $this->DOVS)->first();
    // $complyLookup = LookupDatas::where('ID', '=', $this->COMPLIANCE)->first();

    public function __construct()
    {
        $this->xdsusername = config("app.API_USERNAME");
        $this->xdspassword = config("app.API_PASSWORD");

        $this->KYC = config("app.API_ID_KYC");
        $this->AVS = config("app.API_ID_AVS");
        $this->DOVS = config("app.API_ID_DOVS");
        $this->COMPLIANCE = config("app.API_ID_COMPLIANCE");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function facialRecognitionWithXDS(Request $request)
    {
        try {
            //$user = Auth::user();
            $loggedInUserId = Auth::user()->Id;
            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            // $client = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();


            if ($client->isAdmin == 1 || $client->isAdmin == 0) {
                $soapUrlLive = config("app.API_SOAP_URL_LIVE_FACIAL");
                // $soapUrlDemo = 'https://www.uat.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl';
                $soapUrlDemo = config("app.API_SOAP_URL_DEMO_FACIAL");

                $soapUrlLive = $soapUrlDemo; //here we are changing the url to the demo/dev/testing environment
                $username = $this->xdsusername; // Demo username
                //$username = 'czs_ws'; // Live username
                $password = $this->xdspassword;
                //app('debugbar')->info($client);
                $returnValue = $this->soapLoginAPICall($soapUrlLive, $username, $password);

                $enquiryId = null;
                $enquiryResultId = null;



                $tempData = explode('>', $returnValue);
                //   dd($tempData[5]);

                if (isset($tempData[5])) {
                    $tempData2 = explode('<', $tempData[5]);
                    $ticketNo = $tempData2[0];


                    $returnValue = $this->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
                    $valid = $tempData2[0];

                    if ($valid  == "true") { //if ticket is valid 

                        //here we want to use the consumer match DOVS methods
                        //$returnMatchDOVS = $this->connectConsumerMatchDOVS($soapUrlLive, $username, $password, $ticketNo, 194, '7711025013082', $passport_no = null, '0727926612');
                        $returnMatchDOVS = $this->connectConsumerMatchDOVS($soapUrlLive, $username, $password, $ticketNo, 194, $client->IDNumber, $passport_no = null, $client->PhoneNumber);
                        //$returnMatchDOVS = $this->connectConsumerMatchDOVS($soapUrlLive, $username, $password, $ticketNo, 194, '9212055358081', $passport_no = null, '0844675067');
                        // app('debugbar')->info($$returnMatchDOVS);
                        $tempData = explode('>', $returnMatchDOVS);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);

                        for ($i = 0; $i < count($tempData5); $i++) {
                            if ($tempData5[$i] == 'EnquiryID') {
                                $enquiryId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                            }
                            if ($tempData5[$i] == 'EnquiryResultID') {
                                $enquiryResultId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                            }
                        }


                        $returnDOVRequest = $this->connectDOVRequest($soapUrlLive, $username, $password, $ticketNo, $enquiryId, $enquiryResultId, 194);
                        $tempData = explode('>', $returnDOVRequest);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);
                        //return $tempData5;


                        app('debugbar')->info('tempData5');
                        app('debugbar')->info($tempData5);

                        $returnData = ([
                            'returnDOVRequest' => $tempData5,
                            'enquiryId' => $enquiryId,
                            'ticketNo' => $ticketNo,
                        ]);
                        app('debugbar')->info($returnData);
                        //dd($tempData5);

                        $request->session()->put('enquiryId', $enquiryId);
                        return  $returnData;
                    }
                    //end of if statement ticket still valid
                } //end of if statement

            } else {
                return 'failed';
            }
            return view('fica-process');
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    public function getSelfieResultFromxXDS(Request $request)
    {
        try {
            $loggedInUserId = Auth::user()->Id;
            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            $customers = Customer::where('Id', '=',  $client->CustomerId)->first();
            // $client = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
            // $customers = Customer::where('Id', '=',  $client->CustomerId)->first();
            $dovsLookup = LookupDatas::where('ID', '=', $this->DOVS)->first();


            app('debugbar')->info($customers);

            $returnFacialRecognitionData = null;

            $ConsumerIDPhotoMatch = '';
            $ConsumerIDPhoto = '';
            $ConsumerCapturedPhoto = '';
            $EnquiryDate = '';
            $SubscriberName = '';
            $SubscriberUserName = '';
            $EnquiryInput = '';
            $DeceasedStatus = '';
            $MatchResponseCode = '';
            $LivenessDetectionResult = '';
            $AgeEstimationOfLiveness = '';
            $ResidentialPostalCode = '';
            $Latitude = '';
            $Longitude = '';


            if ($client->isAdmin == 1 || $client->isAdmin == 0) {

                $soapUrlLive = config("app.API_SOAP_URL_LIVE_XDS_SELFIE_RESULT");
                $soapUrlDemo = config("app.API_SOAP_URL_DEMO_XDS_SELFIE_RESULT");
                $soapUrlLive = $soapUrlDemo; //here we are changing the url to the demo/dev/testing environment
                $username = $this->xdsusername; // Demo username

                $password = $this->xdspassword;
                $returnValue = $this->soapLoginAPICall($soapUrlLive, $username, $password);
                //$enquiryId = $request->enquiryId;
                //$enquiryId = 57080687/57096945
                $enquiryId =  $request->session()->get('enquiryId');

                app('debugbar')->info($enquiryId);


                $tempData = explode('>', $returnValue);

                //app('debugbar')->info($tempData);
                //dd($tempData[5]);
                if (isset($tempData[5])) {
                    $tempData2 = explode('<', $tempData[5]);
                    $ticketNo = $tempData2[0];

                    $returnValue = $this->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
                    $valid = $tempData2[0];


                    if ($valid  == "true") {
                        //here we want to use the consumer match DOVS methods
                        $returnConnectGetDOVResult = $this->connectGetDOVResult($soapUrlLive, $username, $password, $ticketNo, $enquiryId);
                        // app('debugbar')->info($returnConnectGetDOVResult);
                        $tempData = explode('>', $returnConnectGetDOVResult);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);
                        app('debugbar')->info($tempData5);

                        // app('debugbar')->info($tempData5);
                        //$returnValue = $returnConnectGetDOVResult;
                        //return $tempData5;
                        //dd($tempData5);
                        $messageResult = ([
                            'message' => '',
                            'result' => '',
                        ]);

                        if ($tempData5[0] == "NoResult") {
                            $returnFacialRecognitionData = "NoResult";
                            $messageResult = ([
                                'result' => 'NoResult',
                                'message' => 'Selfie has not been taken successfully. Please click the selfie link button again to resend the link!',

                            ]);
                            app('debugbar')->info('Please take a selfie then click continue button');
                        }
                        if ($tempData5[0] == 'Consumer') {

                            for ($i = 0; $i < count($tempData5); $i++) {
                                if ($tempData5[$i] == 'ConsumerIDPhotoMatch') {
                                    $ConsumerIDPhotoMatch  = strtok($tempData5[$i + 1], '/');
                                }
                                if ($tempData5[$i] == 'ConsumerIDPhoto') {
                                    $ConsumerIDPhoto = $tempData5[$i + 1];
                                    $ConsumerIDPhoto = str_replace('/ConsumerIDPhoto', '', $ConsumerIDPhoto);
                                }
                                if ($tempData5[$i] == 'ConsumerCapturedPhoto') {
                                    $ConsumerCapturedPhoto  = $tempData5[$i + 1];
                                    $ConsumerCapturedPhoto = str_replace('/ConsumerCapturedPhoto', '', $ConsumerCapturedPhoto);
                                }
                                if ($tempData5[$i] == 'EnquiryDate') {
                                    $EnquiryDate  = $tempData5[$i + 1];
                                    $EnquiryDate = str_replace('/EnquiryDate', '', $EnquiryDate);
                                }
                                if ($tempData5[$i] == 'DeceasedStatus') {
                                    $DeceasedStatus  = $tempData5[$i + 1];
                                    $DeceasedStatus = str_replace('/DeceasedStatus', '', $DeceasedStatus);
                                }

                                if ($tempData5[$i] == 'SubscriberName') {
                                    $SubscriberName  = $tempData5[$i + 1];
                                    $SubscriberName = str_replace('/SubscriberName', '', $SubscriberName);
                                }
                                if ($tempData5[$i] == 'SubscriberUserName') {
                                    $SubscriberUserName  = $tempData5[$i + 1];
                                    $SubscriberUserName = str_replace('/SubscriberUserName', '', $SubscriberUserName);
                                }
                                if ($tempData5[$i] == 'EnquiryInput') {
                                    $EnquiryInput  = $tempData5[$i + 1];
                                    $EnquiryInput = str_replace('/EnquiryInput', '', $EnquiryInput);
                                }
                                if ($tempData5[$i] == 'MatchResponseCode') {
                                    $MatchResponseCode  = $tempData5[$i + 1];
                                    $MatchResponseCode = str_replace('/MatchResponseCode', '', $MatchResponseCode);
                                }
                                if ($tempData5[$i] == 'LivenessDetectionResult') {
                                    $LivenessDetectionResult  = $tempData5[$i + 1];
                                    $LivenessDetectionResult = str_replace('/LivenessDetectionResult', '', $LivenessDetectionResult);
                                }
                                if ($tempData5[$i] == 'AgeEstimationOfLiveness') {
                                    $AgeEstimationOfLiveness  = $tempData5[$i + 1];
                                    $AgeEstimationOfLiveness = str_replace('/AgeEstimationOfLiveness', '', $AgeEstimationOfLiveness);
                                }
                                if ($tempData5[$i] == 'ResidentialPostalCode') {
                                    $ResidentialPostalCode  = $tempData5[$i + 1];
                                    $ResidentialPostalCode = str_replace('/ResidentialPostalCode', '', $ResidentialPostalCode);
                                }
                                if ($tempData5[$i] == 'Latitude') {
                                    $Latitude  = $tempData5[$i + 1];
                                    $Latitude = str_replace('/Latitude', '', $Latitude);
                                }
                                if ($tempData5[$i] == 'Longitude') {
                                    $Longitude  = $tempData5[$i + 1];
                                    $Longitude = str_replace('/Longitude', '', $Longitude);
                                }

                                $messageResult = ([
                                    'result' => 'Consumer',
                                    'message' => 'Selfie has been taken successfully!',

                                ]);
                            }

                            $returnData = ([
                                'ConsumerIDPhotoMatch' => $ConsumerIDPhotoMatch,
                                'ConsumerIDPhoto' => $ConsumerIDPhoto,
                                'ConsumerCapturedPhoto' => $ConsumerCapturedPhoto,
                                'EnquiryDate' => $EnquiryDate,
                                'EnquiryInput' => $EnquiryInput,
                                'DeceasedStatus' => $DeceasedStatus,
                                'SubscriberName' => $SubscriberName,
                                'SubscriberUserName' => $SubscriberUserName,
                                'MatchResponseCode' => $MatchResponseCode,
                                'LivenessDetectionResult' => $LivenessDetectionResult,
                                'AgeEstimationOfLiveness' => $AgeEstimationOfLiveness,
                                'ResidentialPostalCode' => $ResidentialPostalCode,
                                'Latitude' => $Latitude,
                                'Longitude' => $Longitude
                            ]);


                            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
                            $loggedInUserId = Auth::user()->Id;
                            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
                            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
                            // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
                            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();

                            $ficaProgress = $fica->FICAProgress + 1;

                            app('debugbar')->info($customers);

                            $Enquirydate = strtotime($EnquiryDate);
                            $EnquiryDateformartDate = date("Y-m-d H:i:s", $Enquirydate);
                            app('debugbar')->info($tempData5);
                            session()->put('data', $tempData5);

                            DOVS::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'CreatedOnDate' =>  date("Y-m-d H:i:s"),
                                    'LastUpdatedDate' =>  date("Y-m-d H:i:s"),
                                    'DOVS_Status' =>  1,
                                    'ConsumerIDPhotoMatch' => $ConsumerIDPhotoMatch,
                                    'ConsumerIDPhoto' => $ConsumerIDPhoto,
                                    'ConsumerCapturedPhoto' => $ConsumerCapturedPhoto,
                                    'EnquiryDate' => $EnquiryDateformartDate,
                                    'EnquiryInput' => $EnquiryInput,
                                    'DeceasedStatus' => $DeceasedStatus,
                                    'SubscriberName' => $SubscriberName,
                                    'SubscriberUserName' => $SubscriberUserName,
                                    'MatchResponseCode' => $MatchResponseCode,
                                    'LivenessDetectionResult' => $LivenessDetectionResult,
                                    'AgeEstimationOfLiveness' => $AgeEstimationOfLiveness,
                                    'PostalCode' => $ResidentialPostalCode,
                                    'Latitude' => $Latitude,
                                    'Longitude' => $Longitude
                                )
                            );


                            FICA::where('Consumerid', $consumer->Consumerid)->update(
                                array(
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'FICAProgress' =>  $ficaProgress,
                                    'DOVS_Status' => date("Y-m-d H:i:s")
                                )
                            );

                            //API LOGS
                            APILogs::create([
                                'API_Log_Id' => Str::upper(Str::uuid()),
                                'FICAId' => $fica->FICA_id,
                                'ConsumerID' => $fica->Consumerid,
                                'CustomerID' =>  $customers->Id,
                                'Createddate' => date("Y-m-d H:i:s"),
                                'API_ID' => $dovsLookup->Value,
                            ]);

                            // $request->session()->put('FICAProgress', $fica->FICAProgress);
                            $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>  $tempData5[0], 'messageResult' => $messageResult];
                            return $output_data;
                        }
                    }
                }
            } else {
                return 'failed';
            }
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    public function verifyClientKYC(Request $request)
    {
        try {
            // app('debugbar')->info('Hi');
            //return $request->all();
            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $loggedInUserId = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
            // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            $idasData = ConsumerIdentity::where('FICA_id', '=',  $fica->FICA_id)->first();
            $address = Address::where('ConsumerID', '=', $consumer->Consumerid)->first();
            $kycLookup = LookupDatas::where('ID', '=', $this->KYC)->first();

            // $customerUser = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
            $loggedInUserId = Auth::user()->Id;
            $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            $customers = Customer::where('Id', '=',  $customerUser->CustomerId)->first();
            $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
            $customerID = $customers->Id;

            $consumerIdentity = $idasData;
            app('debugbar')->info('FICA ID: ' . $fica->FICA_id);

            if ($consumer->isAdmin == 1 || $consumer->isAdmin == 0) {

                $soapUrlLive = config("app.API_SOAP_URL_LIVE_VERIFY_KYC");
                $soapUrlDemo = config("app.API_SOAP_URL_DEMO_VERIFY_KYC");
                $soapUrlLive = $soapUrlDemo; //here we are changing the url to the demo/dev/testing environment
                $username = $this->xdsusername; // Demo username
                //$username = 'czs_ws'; // Live username
                $password = $this->xdspassword;
                $returnValue = $this->soapLoginAPICall($soapUrlLive, $username, $password);

                app('debugbar')->info($returnValue);
                $enquiryId = null;
                $enquiryResultId = null;
                $SECONDNAME = $idasData->SECONDNAME;
                $SURNAME =  $idasData->SURNAME;
                $IdentityDocumentID = $idasData->Identity_Document_ID;

                $physicalAddr1 =   $homeAddress->OriginalAddress1;
                $physicalAddr2 =  $homeAddress->OriginalAddress2;
                $clientZipCode = $homeAddress->OriginalPostalCode;


                $testResponse = ([
                    'FirstName' => $idasData->SECONDNAME,
                    'LastName' =>  $idasData->SURNAME,
                    'IdentityDocumentID' => $idasData->Identity_Document_ID,
                    'physicalAddr1' =>   $homeAddress->OriginalAddress1,
                    'physicalAddr2' =>  $homeAddress->OriginalAddress2,
                    'clientZipCode' => $homeAddress->OriginalPostalCode
                ]);
                app('debugbar')->info($testResponse);

                //Test Data
                // $physicalAddr1 = '147 EDGEMOUNT ESTATE';
                // $physicalAddr2 = 'MOUNT EDGECOMBE';
                // $clientZipCode =  '4219';

                // $physicalAddr1 = '157 BELVEDERE ROAD';
                // $physicalAddr2 = '4 BELVEDERE MEWS';
                // $clientZipCode =  '4051';


                // $SECONDNAME = 'ALICE';
                // $SURNAME =  'HOPLEY';
                // $IdentityDocumentID = '5309260126081';
                // $physicalAddr1 = '53 TRURO RD';
                // $physicalAddr2 = 'Alberton';
                // $clientZipCode =  '1449';



                $tempData = explode('>', $returnValue);
                //dd($tempData[5]);
                if (isset($tempData[5])) {
                    $tempData2 = explode('<', $tempData[5]);
                    $ticketNo = $tempData2[0];

                    $returnValue = $this->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
                    $valid = $tempData2[0];


                    if ($valid  == "true") { //if ticket is valid
                        //here we want to get the customer information and sources
                        $returnCustomerDetailsAndSources = $this->sanctionAdverseConnectConsumerMatch($soapUrlLive, $username, $password, $ticketNo,  $SECONDNAME,   $SURNAME,  $IdentityDocumentID, null, 152);
                        //dd($returnSanctionValue);

                        app('debugbar')->info($returnCustomerDetailsAndSources);

                        $tempData = explode('>', $returnCustomerDetailsAndSources);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);
                        $returnCustomerDetailsAndSourcesData = null;
                        if (count($tempData5) > 10) { //return $tempData5;
                            for ($i = 0; $i < count($tempData5); $i++) {
                                if ($tempData5[$i] == 'EnquiryID') {
                                    $enquiryId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                                }
                                if ($tempData5[$i] == 'EnquiryResultID') {
                                    $enquiryResultId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                                }
                            }

                            $resultConnectGetConsumerKYCOnline = $this->ConnectGetConsumerKYCOnline($soapUrlLive, $username, $password, $ticketNo, $enquiryId, $enquiryResultId, $IdentityDocumentID, null, $physicalAddr1, $physicalAddr2, $clientZipCode, 152); //return $resultExposure;

                            $tempData = explode('>', $resultConnectGetConsumerKYCOnline);
                            $tempData2 = explode('<', $tempData[5]);

                            $tempData3 = str_replace('&lt;', '', $tempData2);
                            $tempData4 = str_replace('&gt', '', $tempData3);
                            $returnCustomerDetailsAndSourcesData = explode(';', $tempData4[0]);
                            $returnCustomerDetailsAndSourcesData = $returnCustomerDetailsAndSourcesData;
                        } else {
                            $returnCustomerDetailsAndSourcesData = $tempData5;
                        }


                        $FirstName = "";
                        $SecondName = "";
                        $Surname = "";
                        $IDNo = "";
                        $BirthDate = "";
                        $Gender = "";
                        $TitleDesc = "";
                        $MaritalStatusDesc = "";
                        $Age = "";
                        $ID = "";
                        $IDStatusInd = 0;
                        $KYCStatusInd = 0;
                        $IDStatusDesc = "";
                        $KYCStatusDesc = "";
                        $PrivacyStatus = "";
                        $ResidentialAddress = "";
                        $HomeTelephoneNo = "";
                        $WorkTelephoneNo = "";
                        $CellularNo = "";
                        $EmailAddress = "";
                        $EmployerDetail = "";
                        $ReferenceNo = "";
                        $Nationality = "";
                        $Sources = "";
                        $TotalSourcesUsed = "";
                        $EnquiryInput = "";
                        $SubscriberName = "";
                        $SubscriberUserName = "";

                        $ExternalReference = "";

                        $resultDataKYC = $returnCustomerDetailsAndSourcesData;

                        $IDdata = [];

                        //here we assign data from kyc API to variables
                        for ($i = 0; $i < count($resultDataKYC); $i++) {

                            if (strpos($resultDataKYC[$i], '/ID') !== false) {
                                array_push($IDdata, $resultDataKYC[$i]);
                            }

                            if (preg_match('(/FirstName)', $resultDataKYC[$i]) === 1) {
                                $FirstName = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/SecondName)', $resultDataKYC[$i]) === 1) {
                                $SecondName = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/Surname)', $resultDataKYC[$i]) === 1) {
                                $Surname = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/IDNo)', $resultDataKYC[$i]) === 1) {
                                $IDNo = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/BirthDate)', $resultDataKYC[$i]) === 1) {
                                $DOB = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                                $DOB = strtotime($DOB);
                                $BirthDate = date("Y-m-d H:i:s", $DOB);
                            }
                            if (preg_match('(/Gender)', $resultDataKYC[$i]) === 1) {
                                $Gender = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/TitleDesc)', $resultDataKYC[$i]) === 1) {
                                $TitleDesc = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/MaritalStatusDesc)', $resultDataKYC[$i]) === 1) {
                                $MaritalStatusDesc = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/Age)', $resultDataKYC[$i]) === 1) {
                                $Age = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }


                            // if (preg_match('(/ID)', $resultDataKYC[$i]) === 1) {
                            //     $ID = $resultDataKYC[$i];
                            // }
                            if (preg_match('(/IDStatusDesc)', $resultDataKYC[$i]) === 1) {
                                $IDStatusDesc = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/KYCStatusDesc)', $resultDataKYC[$i]) === 1) {
                                $KYCStatusDesc = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/IDStatusInd)', $resultDataKYC[$i]) === 1) {
                                $IDStatusInd = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/KYCStatusInd)', $resultDataKYC[$i]) === 1) {
                                $KYCStatusInd = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }

                            if (preg_match('(/PrivacyStatus)', $resultDataKYC[$i]) === 1) {
                                $PrivacyStatus = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/ResidentialAddress)', $resultDataKYC[$i]) === 1) {
                                $ResidentialAddress = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/HomeTelephoneNo)', $resultDataKYC[$i]) === 1) {
                                $HomeTelephoneNo = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/WorkTelephoneNo)', $resultDataKYC[$i]) === 1) {
                                $WorkTelephoneNo = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/CellularNo)', $resultDataKYC[$i]) === 1) {
                                $CellularNo = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/EmailAddress)', $resultDataKYC[$i]) === 1) {
                                $EmailAddress = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/EmployerDetail)', $resultDataKYC[$i]) === 1) {
                                $EmployerDetail = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/ReferenceNo)', $resultDataKYC[$i]) === 1) {
                                $ReferenceNo = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/Nationality)', $resultDataKYC[$i]) === 1) {
                                $Nationality = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/Sources)', $resultDataKYC[$i]) === 1) {
                                $Sources = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/TotalSourcesUsed)', $resultDataKYC[$i]) === 1) {
                                $TotalSourcesUsed = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/EnquiryInput)', $resultDataKYC[$i]) === 1) {
                                $EnquiryInput = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/SubscriberName)', $resultDataKYC[$i]) === 1) {
                                $SubscriberName = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                            if (preg_match('(/SubscriberUserName)', $resultDataKYC[$i]) === 1) {
                                $SubscriberUserName = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }

                            if (preg_match('(/ExternalReference)', $resultDataKYC[$i]) === 1) {
                                $ExternalReference = substr($resultDataKYC[$i], 0, strpos($resultDataKYC[$i], "/"));
                            }
                        }

                        app('debugbar')->info($IDdata);

                        $returnDatakyc = ([
                            'FirstName' => $FirstName,
                            'SecondName' => $SecondName,
                            'Surname' => $Surname,
                            'IDNo' => $IDNo,
                            'BirthDate' => $BirthDate,
                            'Gender' => $Gender,
                            'TitleDesc' => $TitleDesc,
                            'MaritalStatusDesc' => $MaritalStatusDesc,
                            'Age' => $Age,
                            'IDStatus' => substr($IDdata[1], 0, -3),
                            'IDStatusDesc' => $IDStatusDesc,
                            'IDStatusInd' => $IDStatusInd,
                            'KYCStatusInd' => (int)$KYCStatusInd,
                            'KYC_Status' => (int)$KYCStatusInd > 0 ? 1 : 0,
                            'KYCStatusDesc' => $KYCStatusDesc,
                            'ResidentialAddress' => $ResidentialAddress,
                            'PrivacyStatus' => $PrivacyStatus,
                            'HomeTelephoneNo' => $HomeTelephoneNo,
                            'HomeTelephoneNo' => $WorkTelephoneNo,
                            'HomeTelephoneNo' => $CellularNo,
                            'EmailAddress' => $EmailAddress,
                            'EmployerDetail' => $EmployerDetail,
                            'ReferenceNo' => $ReferenceNo,
                            'ExternalReference' => $ExternalReference,
                            'Nationality' => $Nationality,
                            'Sources' => $Sources,
                            'TotalSourcesUsed' => $TotalSourcesUsed,
                            'EnquiryInput' => $EnquiryInput,
                            'SubscriberName' => $SubscriberName,
                            'SubscriberUserName' => $SubscriberUserName,

                        ]);

                        //Save data to TBL_Consumer_KYC table
                        KYC::where('FICA_id', $fica->FICA_id)->update(
                            array(
                                'FirstName' => $FirstName,
                                'SecondName' => $SecondName,
                                'Surname' => $Surname,
                                'IDNo' => $IDNo,
                                'BirthDate' => $BirthDate,
                                'Gender' => $Gender,
                                'TitleDesc' => $TitleDesc,
                                'MaritalStatusDesc' => $MaritalStatusDesc,
                                'Age' => $Age,
                                'IDStatus' => substr($IDdata[1], 0, -3),
                                'IDStatusDesc' => $IDStatusDesc,
                                'IDStatusInd' => $IDStatusInd,
                                'KYCStatusInd' => (int)$KYCStatusInd,
                                'KYC_Status' => (int)$KYCStatusInd > 0 ? 1 : 0,
                                'KYCStatusDesc' => $KYCStatusDesc,
                                'ResidentialAddress' => $ResidentialAddress,
                                'PrivacyStatus' => $PrivacyStatus,
                                'HomeTelephoneNo' => $HomeTelephoneNo,
                                'HomeTelephoneNo' => $WorkTelephoneNo,
                                'HomeTelephoneNo' => $CellularNo,
                                'EmailAddress' => $EmailAddress,
                                'EmployerDetail' => $EmployerDetail,
                                'ReferenceNo' => $ReferenceNo,
                                'ExternalReference' => $ExternalReference,
                                'Nationality' => $Nationality,
                                'Sources' => $Sources,
                                'TotalSourcesUsed' => $TotalSourcesUsed,
                                'EnquiryInput' => $EnquiryInput,
                                'SubscriberName' => $SubscriberName,
                                'SubscriberUserName' => $SubscriberUserName,

                            )
                        );

                        //API LOGS
                        APILogs::create([
                            'API_Log_Id' => Str::upper(Str::uuid()),
                            'FICAId' => $fica->FICA_id,
                            'ConsumerID' => $fica->Consumerid,
                            'CustomerID' =>  $customerID,
                            'Createddate' => date("Y-m-d H:i:s"),
                            'API_ID' => $kycLookup->Value,
                        ]);

                        app('debugbar')->info($returnDatakyc);
                        app('debugbar')->info($returnCustomerDetailsAndSourcesData);
                        return back()->withSuccess('successfully');
                        // return view('fica-process', ['fica' => $fica, 'consumer' => $consumer, 'consumerIdentity' => $consumerIdentity, 'address' => $address]);
                    }
                }
            }
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
        /**************************** here we want to returnCustomerDetailsAndSources furthur code ends here ******************************/
    }

    public function verifyClientBankAccount(Request $request)
    {
        try {
            $loggedInUserId = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();

            // $client = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            //$fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            $avsLookup = LookupDatas::where('ID', '=', $this->AVS)->first();
            $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
            $bankInfo = BankAccountType::where('BankTypeid', '=',  $avs->BankTypeid)->first();


            $customerUser =  CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            $customers = Customer::where('Id', '=',  $customerUser->CustomerId)->first();
            $customerID = $customers->Id;

            // app('debugbar')->info('client');
            app('debugbar')->info($client);

            if ($client->isAdmin == 1 || $client->isAdmin == 0) {
                $soapUrlLive = config("app.API_SOAP_URL_LIVE_VERIFY_BANK");
                $soapUrlDemo = config("app.API_SOAP_URL_DEMO_VERIFY_BANK");

                $soapUrlLive = $soapUrlLive; //here we are changing the url to the demo/dev/testing environment
                $username = 'Inspirit_Live';
                $password = 'cal100';


                $returnValue = $this->soapLoginAPICall($soapUrlLive, $username, $password);
                $enquiryId = null;
                $enquiryResultId = null;


                $tempData = explode('>', $returnValue);
                if (isset($tempData[5])) {
                    $tempData2 = explode('<', $tempData[5]);
                    $ticketNo = $tempData2[0];

                    app('debugbar')->info('ticketNo');
                    app('debugbar')->info($ticketNo);
                    $returnValue = $this->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
                    $valid = $tempData2[0];


                    $bankdetails = $request->session()->get('bankResult');

                    if ($valid  == "true") { //if ticket is valid
                        $verifyType = 'Individual';
                        $entity = 'None';
                        //Get Bank Details on a session
                        // $surname =   $bankdetails['surname'];
                        // $id_type = 'SID';
                        // $initials = $bankdetails['initials'];
                        // $accNo =  $bankdetails['accNumber'];
                        // $branchCode =  $bankdetails['branch'];
                        // $accType = $bankdetails['BankType'];
                        // $bankName = $bankdetails['bankName'];;
                        // $id_no = $consumer->IDNUMBER;
                        // $contactNo = '0727926612'; //change phone number on the database to this number
                        // $contactNo = $client->PhoneNumber;

                        //Test Data
                        // $surname = 'Naidoo';
                        // $id_type = 'SID';
                        // $initials = 'HM';
                        // $accNo =  '62275884932';
                        // $branchCode =  '250655';
                        // $accType = 'CURRENTCHEQUEACCOUNT';
                        // $bankName = 'FNB';
                        // $id_no = '7711025013082';
                        // $contactNo = '0727926612';

                        $accountHolder = explode(" ", $avs->Account_name);

                        $surname =  $accountHolder[1];
                        $id_type = 'SID';
                        $initials =  $accountHolder[0];
                        $accNo =   $avs->Account_no;
                        $branchCode =  $avs->Branch_code;
                        $accType = $bankInfo->Account_description;
                        $bankName =  $avs->Bank_name;
                        $id_no =  $client->IDNumber;
                        $contactNo =  $client->PhoneNumber;

                        $testResponse = ([
                            'surname' =>  $accountHolder[1],
                            'id_type' => 'SID',
                            'initials' =>  $accountHolder[0],
                            'accNo' =>   $avs->Account_no,
                            'branchCode' =>  $avs->Branch_code,
                            'accType' => $bankInfo->Account_description,
                            'bankName' =>  $avs->Bank_name,
                            'id_no' =>  $client->IDNumber,
                            'contactNo' =>  $client->PhoneNumber
                        ]);


                        // dd($testResponse);


                        app('debugbar')->info($testResponse);
                        //here we want to verify the bank account details
                        $returnValue = $this->soapBankVerificationAPICall($soapUrlLive, $username, $password, $ticketNo, $verifyType, $entity, $initials, $surname, $id_no, $id_type, null, null, null, null, null, $accNo, $branchCode, $accType, $bankName, $contactNo, null, null);

                        // app('debugbar')->info($returnValue);
                        $tempData = explode('>', $returnValue);
                        $tempData2 = explode('<', $tempData[5]);

                        $referenceNo = (int)preg_replace('/[^0-9]/', '', $tempData2[0]); //here we want to get only numbers and filter the rest of the characters



                        sleep(7); //here we are waiting for 5 sec before the next call

                        //$referenceNo = '70492474';

                        $returnValue = $this->ConnectGetAccountVerificationResult($soapUrlLive, $username, $password, $ticketNo, $referenceNo);
                        $tempData = explode('>', $returnValue);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);
                        //return $tempData5;


                        app('debugbar')->info($tempData5);

                        $ERRORCONDITIONNUMBER = NULL;
                        $ACCOUNTFOUND = NULL;
                        $IDNUMBERMATCH = NULL;
                        $INITIALSMATCH = NULL;
                        $SURNAMEMATCH = NULL;
                        $ACCOUNT_OPEN = NULL;
                        $ACCOUNTDORMANT = NULL;
                        $ACCOUNTOPENFORATLEASTTHREEMONTHS = NULL;
                        $ACCOUNTACCEPTSDEBITS = NULL;
                        $ACCOUNTACCEPTSCREDITS = NULL;
                        $EMAILMATCH = NULL;
                        $PHONEMATCH = NULL;
                        $TAXREFERENCEMATCH = NULL;
                        $EnquiryDate = NULL;
                        $EnquiryType = NULL;
                        $SubscriberName = NULL;
                        $SubscriberUserName = NULL;
                        $EnquiryInput = NULL;
                        $EnquiryStatus = NULL;
                        $XDsRefNo = NULL;
                        $ExternalRef = NULL;
                        // $BankTypeid = 3;


                        for ($i = 0; $i < count($tempData5); $i++) {
                            if ($tempData5[$i] == 'ERRORCONDITIONNUMBER') {
                                $ERRORCONDITIONNUMBER  = $tempData5[$i + 1];
                                $ERRORCONDITIONNUMBER = str_replace('/ERRORCONDITIONNUMBER', '', $ERRORCONDITIONNUMBER);
                            }
                            if ($tempData5[$i] == 'ACCOUNTFOUND') {
                                $ACCOUNTFOUND  = $tempData5[$i + 1];
                                $ACCOUNTFOUND = str_replace('/ACCOUNTFOUND', '', $ACCOUNTFOUND);
                            }
                            if ($tempData5[$i] == 'IDNUMBERMATCH') {
                                $IDNUMBERMATCH  = $tempData5[$i + 1];
                                $IDNUMBERMATCH = str_replace('/IDNUMBERMATCH', '', $IDNUMBERMATCH);
                            }
                            if ($tempData5[$i] == 'INITIALSMATCH') {
                                $INITIALSMATCH  = $tempData5[$i + 1];
                                $INITIALSMATCH = str_replace('/INITIALSMATCH', '', $INITIALSMATCH);
                            }
                            if ($tempData5[$i] == 'SURNAMEMATCH') {
                                $SURNAMEMATCH  = $tempData5[$i + 1];
                                $SURNAMEMATCH = str_replace('/SURNAMEMATCH', '', $SURNAMEMATCH);
                            }
                            if ($tempData5[$i] == 'ACCOUNT-OPEN') {
                                $ACCOUNT_OPEN  = $tempData5[$i + 1];
                                $ACCOUNT_OPEN = str_replace('/ACCOUNT-OPEN', '', $ACCOUNT_OPEN);
                            }
                            if ($tempData5[$i] == 'ACCOUNTDORMANT') {
                                $ACCOUNTDORMANT  = $tempData5[$i + 1];
                                $ACCOUNTDORMANT = str_replace('/ACCOUNTDORMANT', '', $ACCOUNTDORMANT);
                            }
                            if ($tempData5[$i] == 'ACCOUNTOPENFORATLEASTTHREEMONTHS') {
                                $ACCOUNTOPENFORATLEASTTHREEMONTHS  = $tempData5[$i + 1];
                                $ACCOUNTOPENFORATLEASTTHREEMONTHS = str_replace('/ACCOUNTOPENFORATLEASTTHREEMONTHS', '', $ACCOUNTOPENFORATLEASTTHREEMONTHS);
                            }
                            if ($tempData5[$i] == 'ACCOUNTACCEPTSDEBITS') {
                                $ACCOUNTACCEPTSDEBITS  = $tempData5[$i + 1];
                                $ACCOUNTACCEPTSDEBITS = str_replace('/ACCOUNTACCEPTSDEBITS', '', $ACCOUNTACCEPTSDEBITS);
                            }
                            if ($tempData5[$i] == 'ACCOUNTACCEPTSCREDITS') {
                                $ACCOUNTACCEPTSCREDITS  = $tempData5[$i + 1];
                                $ACCOUNTACCEPTSCREDITS = str_replace('/ACCOUNTACCEPTSCREDITS', '', $ACCOUNTACCEPTSCREDITS);
                            }
                            if ($tempData5[$i] == 'PHONEMATCH') {
                                $PHONEMATCH  = $tempData5[$i + 1];
                                $PHONEMATCH = str_replace('/PHONEMATCH', '', $PHONEMATCH);
                            }

                            if ($tempData5[$i] == 'EMAILMATCH') {
                                $EMAILMATCH  = $tempData5[$i + 1];
                                $EMAILMATCH = str_replace('/EMAILMATCH', '', $EMAILMATCH);
                            }

                            if ($tempData5[$i] == 'PHONEMATCH') {
                                $PHONEMATCH  = $tempData5[$i + 1];
                                $PHONEMATCH = str_replace('/PHONEMATCH', '', $PHONEMATCH);
                            }
                            if ($tempData5[$i] == 'TAXREFERENCEMATCH') {
                                $TAXREFERENCEMATCH  = $tempData5[$i + 1];
                                $TAXREFERENCEMATCH = str_replace('/TAXREFERENCEMATCH', '', $TAXREFERENCEMATCH);
                            }
                            if ($tempData5[$i] == 'EnquiryDate') {
                                $EnquiryDate  = $tempData5[$i + 1];
                                $EnquiryDate = str_replace('/EnquiryDate', '', $EnquiryDate);
                            }

                            if ($tempData5[$i] == 'EnquiryType') {
                                $EnquiryType  = $tempData5[$i + 1];
                                $EnquiryType = str_replace('/EnquiryType', '', $EnquiryType);
                            }
                            if ($tempData5[$i] == 'SubscriberName') {
                                $SubscriberName  = $tempData5[$i + 1];
                                $SubscriberName = str_replace('/SubscriberName', '', $SubscriberName);
                            }
                            if ($tempData5[$i] == 'SubscriberUserName') {
                                $SubscriberUserName  = $tempData5[$i + 1];
                                $SubscriberUserName = str_replace('/SubscriberUserName', '', $SubscriberUserName);
                            }
                            if ($tempData5[$i] == 'EnquiryInput') {
                                $EnquiryInput  = $tempData5[$i + 1];
                                $EnquiryInput = str_replace('/EnquiryInput', '', $EnquiryInput);
                            }
                            if ($tempData5[$i] == 'EnquiryStatus') {
                                $EnquiryStatus  = $tempData5[$i + 1];
                                $EnquiryStatus = str_replace('/EnquiryStatus', '', $EnquiryStatus);
                            }
                            if ($tempData5[$i] == 'XDsRefNo') {
                                $XDsRefNo  = $tempData5[$i + 1];
                                $XDsRefNo = str_replace('/XDsRefNo', '', $XDsRefNo);
                            }
                        }
                        // app('debugbar')->info($ACCOUNTNUMBER);

                        $returnData = ([
                            'CreatedOnDate' => date("Y-m-d H:i:s"),
                            'LastUpdatedDate' => date("Y-m-d H:i:s"),
                            'ERRORCONDITIONNUMBER' => $ERRORCONDITIONNUMBER,
                            'ACCOUNTFOUND' => $ACCOUNTFOUND,
                            'IDNUMBERMATCH' => $IDNUMBERMATCH,
                            'INITIALSMATCH' => $INITIALSMATCH,
                            'SURNAMEMATCH' => $SURNAMEMATCH,
                            'ACCOUNT_OPEN' => $ACCOUNT_OPEN,
                            'ACCOUNTDORMANT' => $ACCOUNTDORMANT,
                            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $ACCOUNTOPENFORATLEASTTHREEMONTHS,
                            'ACCOUNTACCEPTSDEBITS' => $ACCOUNTACCEPTSDEBITS,
                            'ACCOUNTACCEPTSCREDITS' => $ACCOUNTACCEPTSCREDITS,
                            'PHONEMATCH' => $PHONEMATCH,
                            'EMAILMATCH' => $EMAILMATCH,
                            'TAXREFERENCEMATCH' => $TAXREFERENCEMATCH,
                            'EnquiryDate' => $EnquiryDate,
                            'EnquiryType' => $EnquiryType,
                            'SubscriberName' => $SubscriberName,
                            'SubscriberUserName' => $SubscriberUserName,
                            'EnquiryInput' => $EnquiryInput,
                            'EnquiryStatus' => $EnquiryStatus,
                            'XDsRefNo' => $XDsRefNo,
                            'ExternalRef' => $ExternalRef,
                        ]);


                        if ($tempData5[1] == 'ResultFile') {
                            app('debugbar')->info($returnData);
                            app('debugbar')->info('tempData5');
                            app('debugbar')->info($tempData5);
                            //bank verification successful
                            AVS::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'AVS_Status' => 1,
                                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ERRORCONDITIONNUMBER' => $ERRORCONDITIONNUMBER,
                                    'ACCOUNTFOUND' => $ACCOUNTFOUND,
                                    'IDNUMBERMATCH' => $IDNUMBERMATCH,
                                    'INITIALSMATCH' => $INITIALSMATCH,
                                    'SURNAMEMATCH' => $SURNAMEMATCH,
                                    'ACCOUNT_OPEN' => $ACCOUNT_OPEN,
                                    'ACCOUNTDORMANT' => $ACCOUNTDORMANT,
                                    'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $ACCOUNTOPENFORATLEASTTHREEMONTHS,
                                    'ACCOUNTACCEPTSDEBITS' => $ACCOUNTACCEPTSDEBITS,
                                    'ACCOUNTACCEPTSCREDITS' => $ACCOUNTACCEPTSCREDITS,
                                    'PHONEMATCH' => $PHONEMATCH,
                                    'EMAILMATCH' => $EMAILMATCH,
                                    'TAXREFERENCEMATCH' => $TAXREFERENCEMATCH,
                                    'EnquiryDate' => date('Y-m-d H:i:s', strtotime($EnquiryDate)),
                                    'EnquiryType' => $EnquiryType,
                                    'SubscriberName' => $SubscriberName,
                                    'SubscriberUserName' => $SubscriberUserName,
                                    'EnquiryInput' => $EnquiryInput,
                                    'EnquiryStatus' => $EnquiryStatus,
                                    'XDsRefNo' => $XDsRefNo,
                                    'ExternalRef' => $ExternalRef,
                                    'ErrorMessage' => NULL
                                )
                            );
                            //API LOGS
                            APILogs::create([
                                'API_Log_Id' => Str::upper(Str::uuid()),
                                'FICAId' => $fica->FICA_id,
                                'ConsumerID' => $fica->Consumerid,
                                'CustomerID' =>  $customerID,
                                'Createddate' => date("Y-m-d H:i:s"),
                                'API_ID' => $avsLookup->Value,
                            ]);
                        } else {
                            //invalid bank information 
                            $errorMessage = str_replace('/Error', '', $tempData5[2]);
                            AVS::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'AVS_Status' => 0,
                                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ERRORCONDITIONNUMBER' => NULL,
                                    'ACCOUNTFOUND' => NULL,
                                    'IDNUMBERMATCH' => NULL,
                                    'INITIALSMATCH' => NULL,
                                    'SURNAMEMATCH' => NULL,
                                    'ACCOUNT_OPEN' => NULL,
                                    'ACCOUNTDORMANT' => NULL,
                                    'ACCOUNTOPENFORATLEASTTHREEMONTHS' => NULL,
                                    'ACCOUNTACCEPTSDEBITS' => NULL,
                                    'ACCOUNTACCEPTSCREDITS' => NULL,
                                    'PHONEMATCH' => NULL,
                                    'EMAILMATCH' => NULL,
                                    'TAXREFERENCEMATCH' => NULL,
                                    'EnquiryDate' => NULL,
                                    'EnquiryType' => NULL,
                                    'SubscriberName' => NULL,
                                    'SubscriberUserName' => NULL,
                                    'EnquiryInput' => NULL,
                                    'EnquiryStatus' => NULL,
                                    'XDsRefNo' => NULL,
                                    'ExternalRef' => NULL,
                                    'ErrorMessage' => 'AVS Failed, Please contact administrator'
                                )
                            );
                            app('debugbar')->info($tempData5);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    public function verifyClientCompliance(Request $request)
    {
        $soapUrlLive = config("app.API_SOAP_URL_LIVE_VERIFY_COMPLIANCE");
        $soapUrlDemo = config("app.API_SOAP_URL_DEMO_VERIFY_COMPLIANCE");
        // $soapUrlLive = $soapUrlLive; //here we are changing the url to the demo/dev/testing environment

        // $username = $this->xdsusername;
        // $password = $this->xdspassword;
        $username = 'Inspirit_Live';
        $password = 'cal100';

        try {
            $loggedInUserId = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            // $client = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $compliance = Compliance::where('FICA_id', '=', $fica->FICA_id)->first();
            $consumerComplianceSanction = ConsumerComplianceSanction::where('Compliance_id', '=', $compliance->Compliance_id)->get();
            $consumerComplianceEntityAdditional = ConsumerComplianceEntityAdditional::where('Compliance_id', '=', $compliance->Compliance_id)->get();
            $complianceLookup = LookupDatas::where('ID', '=', $this->COMPLIANCE)->first();

            $customers = Customer::where('Id', '=',  $client->CustomerId)->first();
            $customerID = $customers->Id;

            // $consumerComplianceEntityAdditional
            // app('debugbar')->info($consumerComplianceSanction[2]);
            // app('debugbar')->info($consumerComplianceEntityAdditional);


            if ($client->isAdmin == 1 || $client->isAdmin == 0) {
                $returnValue = $this->soapLoginAPICall($soapUrlLive, $username, $password);
                $enquiryId = null;
                $enquiryResultId = null;


                $tempData = explode('>', $returnValue);
                //dd($tempData[5]);
                if (isset($tempData[5])) {
                    $tempData2 = explode('<', $tempData[5]);
                    $ticketNo = $tempData2[0];

                    // app('debugbar')->info($ticketNo);

                    $returnValue = $this->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
                    $valid = $tempData2[0];


                    if ($valid  == "true") {
                        $id_no = $consumer->IDNUMBER;
                        $firstname = $consumer->FirstName;
                        $surname = $consumer->Surname;

                        //Test users
                        // $id_no = '4204125599088';
                        // $firstname = 'Jacob';
                        // $surname = 'Zuma';


                        // $id_no = '9202045260083';
                        // $firstname = 'RYAN';
                        // $surname = 'GROBLER';

                        // $id_no = '0000000000000';
                        // $firstname = 'Name';
                        // $surname = 'Surname';
                        //here we want to get the customer information and sources
                        $returnCustomerDetailsAndSources = $this->sanctionAdverseConnectConsumerMatch($soapUrlLive, $username, $password, $ticketNo, $firstname, $surname, $id_no, null, 176);
                        // app('debugbar')->info($returnCustomerDetailsAndSources);

                        $tempData = explode('>', $returnCustomerDetailsAndSources);
                        $tempData2 = explode('<', $tempData[5]);

                        $tempData3 = str_replace('&lt;', '', $tempData2);
                        $tempData4 = str_replace('&gt', '', $tempData3);
                        $tempData5 = explode(';', $tempData4[0]);
                        $sanctionAndAdverseData = null;
                        if (count($tempData5) > 10) { //return $tempData5;
                            for ($i = 0; $i < count($tempData5); $i++) {
                                if ($tempData5[$i] == 'EnquiryID') {
                                    $enquiryId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                                }
                                if ($tempData5[$i] == 'EnquiryResultID') {
                                    $enquiryResultId  = (int)preg_replace('/[^0-9]/', '', $tempData5[$i + 1]); //here we want to get only numbers and filter the rest of the characters
                                }
                            }

                            $resultExposure = $this->sanctionAdverseConnectGetConsumerExposureResult($soapUrlLive, $username, $password, $ticketNo, $enquiryId, $enquiryResultId, 176); //return $resultExposure;

                            // app('debugbar')->info($resultExposure);
                            $tempData = explode('>', $resultExposure);
                            $tempData2 = explode('<', $tempData[5]);

                            $tempData3 = str_replace('&lt;', '', $tempData2);
                            $tempData4 = str_replace('&gt', '', $tempData3);
                            $sanctionAndAdverseData = explode(';', $tempData4[0]);
                            $sanctionAndAdverseData = $sanctionAndAdverseData;
                        } else {
                            $sanctionAndAdverseData = $tempData5;
                        }

                        app('debugbar')->info($sanctionAndAdverseData[0]);

                        $EnquiryDate = '';
                        $EnquiryType = '';
                        $SubscriberName = '';
                        $SubscriberUserName = '';
                        $EnquiryInput = '';

                        $HANames = '';
                        $HASurname = '';
                        $HADeceasedStatus = '';
                        $HADeceasedDate = '';
                        $CauseOfDeath = '';
                        $HADateOfBirth = '';
                        $HAIDBookIssuedDate = '';
                        $HAErrorDescription = '';
                        $IDNOMatchStatus = '';
                        $HAIDNO = '';

                        $ID = '';
                        $EntityType = '';
                        $EntityName = '';
                        $EntityUniqueID = '';
                        $ResultDate = '';
                        $DateListed = '';
                        $Gender = '';
                        $BestNameScore = '';
                        $ReasonListed = '';
                        $ListReferenceNumber = '';
                        $Comments = '';


                        $SupplierData = '';
                        $SupplierDataArray = [];
                        $ID1 = '';
                        $EntityType = '';
                        $EntityUniqueID2 = '';
                        $ReasonListed = '';
                        $DateListed = '';
                        $ListReferenceNumber = '';
                        $EntityName = '';
                        $ResultDate = '';
                        $Gender1 = '';
                        $BestNameScore1 = '';
                        $Comments = '';
                        $Occupation = '';

                        $CommentArray = [];
                        // $SourcesOfRecordInformation = [];
                        // $DOBArray = [];
                        $consumerComplianceEntityadditional = [];

                        if ($sanctionAndAdverseData[0] == 'HomeAffairs') {

                            for ($i = 0; $i < count($sanctionAndAdverseData); $i++) {
                                if ($sanctionAndAdverseData[$i] == 'EnquiryDate') {
                                    $EnquiryDate  = $sanctionAndAdverseData[$i + 1];
                                    $EnquiryDate = str_replace('/EnquiryDate', '', $EnquiryDate);
                                }
                                if ($sanctionAndAdverseData[$i] == 'EnquiryType') {
                                    $EnquiryType  = $sanctionAndAdverseData[$i + 1];
                                    $EnquiryType = str_replace('/EnquiryType', '', $EnquiryType);
                                }

                                if ($sanctionAndAdverseData[$i] == 'SubscriberName') {
                                    $SubscriberName  = $sanctionAndAdverseData[$i + 1];
                                    $SubscriberName = str_replace('/SubscriberName', '', $SubscriberName);
                                }
                                if ($sanctionAndAdverseData[$i] == 'SubscriberUserName') {
                                    $SubscriberUserName  = $sanctionAndAdverseData[$i + 1];
                                    $SubscriberUserName = str_replace('/SubscriberUserName', '', $SubscriberUserName);
                                }
                                if ($sanctionAndAdverseData[$i] == 'EnquiryInput') {
                                    $EnquiryInput  = $sanctionAndAdverseData[$i + 1];
                                    $EnquiryInput = str_replace('/EnquiryInput', '', $EnquiryInput);
                                }

                                if ($sanctionAndAdverseData[$i] == 'HANames') {
                                    $HANames  = $sanctionAndAdverseData[$i + 1];
                                    $HANames = str_replace('/HANames', '', $HANames);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HASurname') {
                                    $HASurname  = $sanctionAndAdverseData[$i + 1];
                                    $HASurname = str_replace('/HASurname', '', $HASurname);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HADateOfBirth') {
                                    $HADateOfBirth  = $sanctionAndAdverseData[$i + 1];
                                    $HADateOfBirth = str_replace('/HADateOfBirth', '', $HADateOfBirth);
                                }

                                if ($sanctionAndAdverseData[$i] == 'HADeceasedStatus') {
                                    $HADeceasedStatus  = $sanctionAndAdverseData[$i + 1];
                                    $HADeceasedStatus = str_replace('/HADeceasedStatus', '', $HADeceasedStatus);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HADeceasedDate') {
                                    $HADeceasedDate  = $sanctionAndAdverseData[$i + 1];
                                    $HADeceasedDate = str_replace('/HADeceasedDate', '', $HADeceasedDate);
                                }
                                if ($sanctionAndAdverseData[$i] == 'CauseOfDeath') {
                                    $CauseOfDeath  = $sanctionAndAdverseData[$i + 1];
                                    $CauseOfDeath = str_replace('/CauseOfDeath', '', $CauseOfDeath);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HAIDBookIssuedDate') {
                                    $HAIDBookIssuedDate  = $sanctionAndAdverseData[$i + 1];
                                    $HAIDBookIssuedDate = str_replace('/HAIDBookIssuedDate', '', $HAIDBookIssuedDate);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HAErrorDescription') {
                                    $HAErrorDescription  = $sanctionAndAdverseData[$i + 1];
                                    $HAErrorDescription = str_replace('/HAErrorDescription', '', $HAErrorDescription);
                                }
                                if ($sanctionAndAdverseData[$i] == 'IDNOMatchStatus') {
                                    $IDNOMatchStatus  = $sanctionAndAdverseData[$i + 1];
                                    $IDNOMatchStatus = str_replace('/IDNOMatchStatus', '', $IDNOMatchStatus);
                                }
                                if ($sanctionAndAdverseData[$i] == 'HAIDNO') {
                                    $HAIDNO  = $sanctionAndAdverseData[$i + 1];
                                    $HAIDNO = str_replace('/HAIDNO', '', $HAIDNO);
                                }


                                if ($sanctionAndAdverseData[$i] == 'Occupation/Type') {
                                    $Occupation  = $sanctionAndAdverseData[$i + 2];
                                    $Occupation = str_replace('/Value', '', $Occupation);
                                    array_push($consumerComplianceEntityadditional, 'Occupation:' . $Occupation);
                                }

                                //search for SupplierData and store the index
                                if ($sanctionAndAdverseData[$i] == 'SupplierData') {
                                    array_push($SupplierDataArray, $i);
                                }

                                if ($sanctionAndAdverseData[$i] == 'Sources of Record Information/Value') {
                                    array_push($consumerComplianceEntityadditional, 'Other:' . $sanctionAndAdverseData[$i + 2]);
                                }

                                if ($sanctionAndAdverseData[$i] == 'DOB/Type') {
                                    $dOB =  str_replace('/Value', '', $sanctionAndAdverseData[$i + 2]);
                                    array_push($consumerComplianceEntityadditional, 'DOB:' . $dOB);
                                }
                            }

                            //get the AdditionalInfo 
                            for ($i = 0; $i < count($SupplierDataArray); $i++) {
                                $IDIndex = $this->searchIndex('ID', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $ID1  = str_replace('/ID', '', $sanctionAndAdverseData[$IDIndex]);

                                $EntityTypeIndex = $this->searchIndex('EntityType', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $EntityType  = str_replace('/EntityType', '', $sanctionAndAdverseData[$EntityTypeIndex]);

                                $EntityNameIndex = $this->searchIndex('EntityName', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $EntityName  = str_replace('/EntityName', '', $sanctionAndAdverseData[$EntityNameIndex]);

                                $ResultDateIndex = $this->searchIndex('ResultDate', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $ResultDate  = str_replace('/ResultDate', '', $sanctionAndAdverseData[$ResultDateIndex]);

                                $EntityUniqueIDIndex = $this->searchIndex('EntityUniqueID', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $EntityUniqueID2  = str_replace('/EntityUniqueID', '', $sanctionAndAdverseData[$EntityUniqueIDIndex]);

                                $ReasonListedIndex = $this->searchIndex('ReasonListed', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $ReasonListed  = str_replace('/ReasonListed', '', $sanctionAndAdverseData[$ReasonListedIndex]);

                                $DateListedIndex = $this->searchIndex('DateListed', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $DateListed  = str_replace('/DateListed', '', $sanctionAndAdverseData[$DateListedIndex]);

                                $GenderIndex = $this->searchIndex('Gender', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $Gender1  = str_replace('/Gender', '', $sanctionAndAdverseData[$GenderIndex]);

                                $BestNameScoreIndex = $this->searchIndex('BestNameScore', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $BestNameScore1  = str_replace('/BestNameScore', '', $sanctionAndAdverseData[$BestNameScoreIndex]);

                                $ListReferenceNumberIndex = $this->searchIndex('ListReferenceNumber', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $ListReferenceNumber  = str_replace('/ListReferenceNumber', '', $sanctionAndAdverseData[$ListReferenceNumberIndex]);


                                $startCommentsIndex = $this->searchIndex('Comments', $sanctionAndAdverseData, $SupplierDataArray[$i]) + 1;
                                $endCommentsIndex = $this->searchIndex('AdditionalInfo', $sanctionAndAdverseData, $SupplierDataArray[$i]);

                                for ($index = $startCommentsIndex; $index < $endCommentsIndex; $index++) {
                                    $Comments  .= $sanctionAndAdverseData[$index];
                                    $Comments  = str_replace('/Comments', '',  $Comments);
                                }

                                //Data Object
                                $iDentityVerificationResponse = ([
                                    'EnquiryDate' => $EnquiryDate,
                                    'EnquiryInput' => $EnquiryInput,
                                    'HAIDNO' => $HAIDNO,
                                    'IDNOMatchStatus' => $IDNOMatchStatus,
                                    'HANames' => $HANames,
                                    'HASurname' => $HASurname,
                                    'HADateOfBirth' => $HADateOfBirth,
                                    'HADeceasedStatus' => $HADeceasedStatus,
                                    'HADeceasedDate' => $HADeceasedDate,
                                    'CauseOfDeath' => $CauseOfDeath,
                                    'HAIDBookIssuedDate' => $HAIDBookIssuedDate,
                                    'HAErrorDescription' => $HAErrorDescription,
                                ]);

                                $datelisted = strtotime($DateListed);
                                $resultdate = strtotime($ResultDate);
                                $sanctionScreenResponse[$i] = ([
                                    'ID' => $ID1,
                                    'Date_Listed' => date('d/M/Y H:i:s', $datelisted),
                                    'Entity_type' => $EntityType,
                                    'Gender' => $Gender1,
                                    'Entityname' => $EntityName,
                                    'BestNameScore' => $BestNameScore1,
                                    'EntityUniqueID' => $EntityUniqueID2,
                                    'ReasonListed' => $ReasonListed,
                                    'ResultDate' => date('d/M/Y H:i:s', $resultdate),
                                    'ListReferenceNumber' => $ListReferenceNumber,
                                    'Comments' => $Comments
                                ]);
                                app('debugbar')->info($sanctionScreenResponse[$i]);

                                //create Consumer Compliance Sanction 
                                $consumerComplianceSanction = ConsumerComplianceSanction::create([
                                    'Sanction_id' => Str::upper(Str::uuid()),
                                    'Compliance_id' => $compliance->Compliance_id,
                                    'ID' => $ID1,
                                    'Date_Listed' => date('d/M/Y H:i:s', $datelisted),
                                    'Entity_type' => $EntityType,
                                    'Gender' => $Gender1,
                                    'Entityname' => $EntityName,
                                    'BestNameScore' => $BestNameScore1,
                                    'EntityUniqueID' => $EntityUniqueID2,
                                    'ReasonListed' => $ReasonListed,
                                    'ResultDate' => date('d/M/Y H:i:s', $resultdate),
                                    'ListReferenceNumber' => $ListReferenceNumber,
                                    'Comments' => $Comments
                                ]);

                                array_push($CommentArray, $sanctionScreenResponse[$i]);
                                //Reset Comments
                                $Comments = '';
                            }


                            //Updating Compliance
                            $enquirydate = strtotime($EnquiryDate);
                            app('debugbar')->info(date('d/M/Y H:i:s', $enquirydate));
                            Compliance::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'Compliance_Status' => 1,
                                    'EnquiryDate' =>  date('d/M/Y H:i:s', $enquirydate),
                                    'EnquiryInput' => $EnquiryInput,
                                    'HA_IDNO' => $HAIDNO,
                                    'HA_IDNOMatchStatus' => $IDNOMatchStatus,
                                    'HA_Names' => $HANames,
                                    'HA_Surname' => $HASurname,
                                    'HA_DateOfBirth' => $HADateOfBirth,
                                    'HA_DeceasedStatus' => $HADeceasedStatus,
                                    'HA_IDBookIssuedDate' => $HAIDBookIssuedDate,
                                    'HA_ErrorDescription' => $HAErrorDescription,
                                    'ErrorMessage' => NULL
                                )
                            );


                            FICA::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'Compliance_Status' => date("Y-m-d H:i:s"),
                                )
                            );

                            //API LOGS
                            APILogs::create([
                                'API_Log_Id' => Str::upper(Str::uuid()),
                                'FICAId' => $fica->FICA_id,
                                'ConsumerID' => $fica->Consumerid,
                                'CustomerID' =>  $customerID,
                                'Createddate' => date("Y-m-d H:i:s"),
                                'API_ID' => $complianceLookup->Value,
                            ]);


                            //Consumer Compliance Entity Additional
                            for ($i = 0; $i <   count($consumerComplianceEntityadditional); $i++) {
                                //Occupation
                                if (preg_match('(Occupation:)', $consumerComplianceEntityadditional[$i]) === 1) {
                                    $complianceEntityadditional = ConsumerComplianceEntityAdditional::create([
                                        'Entity_Additional_id' => Str::upper(Str::uuid()),
                                        'Compliance_id' => $compliance->Compliance_id,
                                        'Additional_type' => 'Occupation',
                                        'Additional_value' => substr($consumerComplianceEntityadditional[$i], 11),
                                        'Additional_comment' => null
                                    ]);
                                }
                                //DOB
                                if (preg_match('(DOB:)', $consumerComplianceEntityadditional[$i]) === 1) {
                                    $complianceEntityadditional = ConsumerComplianceEntityAdditional::create([
                                        'Entity_Additional_id' => Str::upper(Str::uuid()),
                                        'Compliance_id' => $compliance->Compliance_id,
                                        'Additional_type' => 'DOB',
                                        'Additional_value' => substr($consumerComplianceEntityadditional[$i], 4),
                                        'Additional_comment' => null
                                    ]);
                                }
                                //Other
                                if (preg_match('(Other:)', $consumerComplianceEntityadditional[$i]) === 1) {
                                    $complianceEntityadditional = ConsumerComplianceEntityAdditional::create([
                                        'Entity_Additional_id' => Str::upper(Str::uuid()),
                                        'Compliance_id' => $compliance->Compliance_id,
                                        'Additional_type' => 'Other',
                                        'Additional_value' => 'Source of Record Information',
                                        'Additional_comment' => substr($consumerComplianceEntityadditional[$i], 5)
                                    ]);
                                }
                                // app('debugbar')->info($complianceEntityadditional);
                            }
                            app('debugbar')->info($sanctionAndAdverseData);
                            // }
                            // app('debugbar')->info($AdditionalInfo);
                            // app('debugbar')->info($sanctionAndAdverseData);




                            //this email should only be send when all verification as been completed

                            /************  send verification notification email to client start here *************************/
                            /*$subject = 'Document Verification Notification from ' . $systemInformation->first_name . ' ' . $systemInformation->last_name;
                    $name = 'Dear ' . $client->first_name . '<br/>';
                    $userEmailData = '<p>We are glad to inform you that your document as been review and verified, <br/>kindly proceed to your account Dashboard to view your progress status. </p>';
                    $userEmailData .= '<p>
                                    <span><a href="https://' . $systemInformation->domain_link . '/login">Click Here to Login to your Account</a></span>

                                    </p>';
                    $userEmailData .= '<p>Alternatively, you may contact us directly for more information.</p>';

                    $userEmailData .= '<span>Kind Regards</span><br/>';
                    $userEmailData .= '<span>The ' . $systemInformation->first_name . ' ' . $systemInformation->last_name . '</span><br/>';
                    $userEmailData .= '<span><a href="mailto:' . $systemInformation->email . '">' . $systemInformation->email . '</a></span><br/>';
                    $userEmailData .= '<span>0877 333 453</span>';

                    $data = ['name' => $name, 'subject' => $subject, 'messages' => $userEmailData, 'systemLogo' => $systemLogo];
                    $userMail = $client->email; //dd($userMail);

                    Mail::to($userMail)
                        //->cc('tmunsamy@in2assets.com')
                        //->bcc('anela.maza@iconis.co.za')
                        ->queue(new ClientRegistrationNotification($data, $name, $userMail, $subject));

                    $this->logActivities->addToLog('Client with email: ' . $client->email . ' Document as been verified and a notification email sent');*/
                            //return redirect('users')->with('success', trans('usersmanagement.createSuccess')); 
                            //return back()->with('success', 'New Client Account as been successfully created!');
                            /**************send verification notification email to client ends here *********************/

                            return $sanctionAndAdverseData;
                        } else {
                            app('debugbar')->info($sanctionAndAdverseData);
                            Compliance::where('FICA_id', $fica->FICA_id)->update(
                                array(
                                    'Compliance_Status' => 0,

                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'EnquiryDate' =>   date("Y-m-d H:i:s"),
                                    'EnquiryInput' => NULL,
                                    'HA_IDNO' => NULL,
                                    'HA_IDNOMatchStatus' => NULL,
                                    'HA_Names' => NULL,
                                    'HA_Surname' => NULL,
                                    'HA_DateOfBirth' => NULL,
                                    'HA_DeceasedStatus' => NULL,
                                    'HA_IDBookIssuedDate' => NULL,
                                    'HA_ErrorDescription' => NULL,
                                    'ErrorMessage' => 'Compliance Failed, please contact afministrator',

                                )
                            );
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    public function searchIndex($searchName, $sanctionAndAdverseDataArray, $startIndex)
    {
        $needle_to_search = $searchName;
        $array_to_search =  $sanctionAndAdverseDataArray;
        $index_to_start_search_from = $startIndex;
        $result = array_search($needle_to_search, array_slice($array_to_search, $index_to_start_search_from, null, true));

        return $result;
    }

    public function soapLoginAPICall($url, $user, $pass)
    {
        //Data, connection, auth
        //$dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = $url; //"https://connecting.website.com/soap.asmx?op=DoSomething"; // asmx URL of WSDL
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                   <Login xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <strUser>' . $soapUser . '</strUser>
                                      <strPwd>' . $soapPassword . '</strPwd>
                                    </Login>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/Login",
        ); //SOAPAction: your op URL

        $curl = curl_init();
        //app('debugbar')->info($curl);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);



        curl_close($curl);

        if ($err) {
            //app('debugbar')->info($response);
            return "cURL Error #:" . $err;
        } else {

            return $response;

            // a new dom object 
            $dom = new DOMDocument();

            // load the html into the object 
            $dom->load($response);

            $array = json_decode($dom->textContent, TRUE);
            app('debugbar')->info($response);


            return $array;
        }

        // xml post structure

        $xml_post_string = '<xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                   <Login xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <strUser>Username</strUser>
                                      <strPwd>Password</strPwd>
                                    </Login>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            "SOAPAction: http://connection.mywebsite.com/MySERVER/GetCarType",
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        curl_close($ch);
        $response;

        // a new dom object 
        $dom = new DOMDocument('1.0', 'utf-8');

        // load the html into the object 
        $dom->loadXml($response);

        $array = json_decode($dom->textContent, TRUE);



        return print_r($array);
    }

    public function soapValidateTicketNo($url, $user, $pass, $ticketNo)
    {
        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                   <IsTicketValid xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <XDSConnectTicket>' . $ticketNo . '</XDSConnectTicket>
                                    </IsTicketValid>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/IsTicketValid",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1

            // CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            // CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function connectConsumerMatchDOVS($url, $user, $pass, $ticketNo, $productID, $id_no, $passport_no = null, $cell_no)
    {
        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $productId = $productID; //194

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectConsumerMatchDOVS xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <ProductId>' . $productId . '</ProductId>
                                      <IdNumber>' . $id_no . '</IdNumber>
                                      <CellNumber>' . $cell_no . '</CellNumber>
                                      <YourReference></YourReference>
                                      <VoucherCode></VoucherCode>
                                    </ConnectConsumerMatchDOVS>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectConsumerMatchDOVS",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function connectDOVRequest($url, $user, $pass, $ticketNo, $enquiryId, $enquiryResultId, $productID)
    {
        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $productId = $productID;
        $enquiryId = $enquiryId;
        $enquiryResultId = $enquiryResultId;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectDOVRequest xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <EnquiryID>' . $enquiryId . '</EnquiryID>
                                      <EnquiryResultID>' . $enquiryResultId . '</EnquiryResultID>
                                      <ProductID>' . $productId . '</ProductID>
                                      <RedirectURL>Redirect URL</RedirectURL>
                                    </ConnectDOVRequest>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectDOVRequest",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function connectGetDOVResult($url, $user, $pass, $ticketNo, $enquiryId)
    {
        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $enquiryId = $enquiryId;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectGetDOVResult xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <EnquiryID>' . $enquiryId . '</EnquiryID>
                                    </ConnectGetDOVResult>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectGetDOVResult",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // app('debugbar')->info($response);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function sanctionAdverseConnectConsumerMatch($url, $user, $pass, $ticketNo, $firstname, $lastname, $id_no, $passport_no = null, $productID)
    {

        $ticketNo = $ticketNo;
        $soapUrl = $url;
        $soapUser =  $user;
        $soapPassword = $pass;
        $enquiryReason = 'Developing a Credit Scoring System';
        $productId = $productID; //176;//149
        $id_no = $id_no;
        $firstname = $firstname;
        $lastname = $lastname;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectConsumerMatch xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <EnquiryReason>' . $enquiryReason . '</EnquiryReason>
                                      <ProductId>' . $productId . '</ProductId>
                                      <IdNumber>' . $id_no . '</IdNumber>
                                      <PassportNo></PassportNo>
                                      <FirstName>' . $firstname . '</FirstName>
                                      <Surname>' . $lastname . '</Surname>
                                      <BirthDate></BirthDate>
                                      <YourReference></YourReference>
                                      <VoucherCode></VoucherCode>
                                    </ConnectConsumerMatch>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectConsumerMatch",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);

        // app('debugbar')->info($response);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function ConnectGetConsumerKYCOnline($url, $user, $pass, $ticketNo, $enquiryId, $enquiryResultId, $id_no, $passport_no = null, $physicalAddr1, $physicalAddr2, $clientZipCode, $productID)
    {

        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $id_no = $id_no;
        $passport_no = $passport_no;
        $pAddr1 = $physicalAddr1;
        $pAddr2 = $physicalAddr2;
        // $pAddr3 = 'Durban';
        $zipCode = $clientZipCode;
        $productId = $productID; //176; or 149
        $enquiryId = $enquiryId;
        $enquiryResultId = $enquiryResultId;

        // $physicalAddr1 = '147 EDGEMOUNT ESTATE';
        // $physicalAddr2 = 'MOUNT EDGECOMBE';
        // $clientZipCode =  '4219';


        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectGetConsumerKYCOnline xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <ProductId>' . $productId . '</ProductId>
                                      <EnquiryID>' . $enquiryId . '</EnquiryID>
                                      <EnquiryResultID>' . $enquiryResultId . '</EnquiryResultID>
                                      <IdNumber>' . $id_no . '</IdNumber>
                                      <PassportNo></PassportNo>
                                      <AddressLine1>' . $pAddr1 . '</AddressLine1>
                                      <AddressLine2>' . $pAddr2 . '</AddressLine2>
                                      <AddressLine3></AddressLine3>
                                      <AddressLine4></AddressLine4>
                                      <PostalCode>' . $zipCode . '</PostalCode>
                                      <YourReference></YourReference>
                                      <VoucherCode></VoucherCode>
                                    </ConnectGetConsumerKYCOnline>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectGetConsumerKYCOnline",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function soapBankVerificationAPICall($url, $user, $pass, $ticketNo, $verifyType, $entity, $initials, $surname, $id_no, $id_type = 'SID', $companyName = null, $reg1 = null, $reg2 = null, $reg3 = null, $trustNo = null, $accNo, $branchCode, $accType, $bankName, $contactNo = null, $email = null, $referenceNo = null)
    {
        $ticketNo = $ticketNo;
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $verificationType = $verifyType;
        $entity = $entity;
        $clientNameInitials = $initials;
        $surname = $surname;
        $id_no = $id_no;
        $id_type = $id_type; //SID or SBR or SPP or FPP or OTHER
        $companyName = $companyName;
        $reg1 = $reg1;
        $reg2 = $reg2;
        $reg3 = $reg3;
        $trustNo = $trustNo;
        $accNo = $accNo;
        $branchCode = $branchCode;
        $accType = $accType;
        $bankName = $bankName;
        $contactNo = $contactNo;
        $email = $email;
        // $voucherCode = 'EBB79E69-41A7-44F6-B07E-6F2642F05E8F';
        $referenceNo = $referenceNo;


        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <ConnectAccountVerificationRealTimeWithContacts 
                xmlns="http://www.web.xds.co.za/XDSConnectWS">
                    <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                    <VerificationType>' . $verificationType . '</VerificationType>
                    <Entity>' . $entity . '</Entity>
                    <Initials>' . $clientNameInitials . '</Initials>
                    <SurName>' . $surname . '</SurName>
                    <IDNo>' . $id_no . '</IDNo>
                    <IDType>' . $id_type . '</IDType>
                    <CompanyName>' . $companyName . '</CompanyName>
                    <Reg1>' . $reg1 . '</Reg1>
                    <Reg2>' . $reg2 . '</Reg2>
                    <Reg3>' . $reg3 . '</Reg3>
                    <TrustNo>' . $trustNo . '</TrustNo>
                    <AccNo>' . $accNo . '</AccNo>
                    <BranchCode>' . $branchCode . '</BranchCode>
                    <Acctype>' . $accType . '</Acctype>
                    <BankName>' . $bankName . '</BankName>
                    <ContactNumber>' . $contactNo . '</ContactNumber>
                    <EmailAddress>' . $email . '</EmailAddress>
                    <VoucherCode></VoucherCode>
                    <YourReference>' . $referenceNo . '</YourReference>
            </ConnectAccountVerificationRealTimeWithContacts>
        </soap:Body>
        </soap:Envelope>';

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectAccountVerificationRealTimeWithContacts",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function sanctionAdverseConnectGetConsumerExposureResult($url, $user, $pass, $ticketNo, $enquiryId, $enquiryResultId, $productID)
    {

        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        $productId = $productID; //176; or 149
        $enquiryId = $enquiryId;
        $enquiryResultId = $enquiryResultId;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectGetConsumerExposureResult xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <EnquiryID>' . $enquiryId . '</EnquiryID>
                                      <EnquiryResultID>' . $enquiryResultId . '</EnquiryResultID>
                                      <ProductID>' . $productId . '</ProductID>
                                      <BonusXML></BonusXML>
                                    </ConnectGetConsumerExposureResult>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectGetConsumerExposureResult",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        // $xmldata = simplexml_load_string($response);
        // $jsondata = json_encode($xmldata);

        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }

    public function ConnectGetAccountVerificationResult($url, $user, $pass, $ticketNo, $referenceNo)
    {

        $ticketNo = $ticketNo; //"password"; // password
        $soapUrl = $url;
        $soapUser =  $user; //"username";  //  username
        $soapPassword = $pass; //"password"; // password
        //$referenceNo = $referenceNo;
        //$referenceNo = 70492469;

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                                  <soap12:Body>
                                    <ConnectGetAccountVerificationResult xmlns="http://www.web.xds.co.za/XDSConnectWS">
                                      <ConnectTicket>' . $ticketNo . '</ConnectTicket>
                                      <EnquiryLogID>' . $referenceNo . '</EnquiryLogID>
                                    </ConnectGetAccountVerificationResult>
                                  </soap12:Body>
                                </soap12:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /xdsconnect/XDSconnectWS.asmx HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://www.web.xds.co.za/XDSConnectWS/ConnectGetAccountVerificationResult",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $soapUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $soapUser . ":" . $soapPassword,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        // app('debugbar')->info($response);

        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {

            return $response;
        }
    }
}
