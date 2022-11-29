<?php

namespace App\Http\Controllers;

use Aws\Textract\TextractClient;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;
use App\Models\Consumer;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\ServiceProvider;
use Illuminate\Support\Str;

use App\Http\Controllers\VerificationDataController;
use App\Models\FICA;
use App\Models\ConsumerIdentity;
use DateTime;
use App\Models\CustomerUser;
use Nette\Utils\Arrays;
use App\Models\AVS;
use App\Models\KYC;
use stdClass;
use App\Models\Address;
use App\Models\LookupDatas;
use App\Models\BankAccountType;
use App\Models\APILogs;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class awsController extends Controller
{
    protected $homeAddressIDType = '4AA3F8D1-0DF0-45C7-A772-869ECD88AB4D'; //HOME:16 
    protected $PostalAddressIDType = '41B4799E-B1CC-44D1-B067-F963B17694EA'; //POSTAL:15
    protected $WorkAddressIDType = 'C3E57D4F-3100-4973-A717-E17355321983'; //WORK:14

    protected $IDAS_ID = '3B5FCCCA-106A-4545-BC02-88D1C15D8626'; //IDAS_ID


    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
    }
    public function TextractAmazonOCR($path, Request $request)
    {
        //app('debugbar')->info('abc');

        $texts = array();
        $data = new OCRdata();

        $client = new TextractClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key'    => 'AKIA4IKI2GCK2MKU65VF', //move to .env file
                'secret' => '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' //move to .env file
            ]
        ]);

        $filename = $path;
        $file = fopen($filename, "rb");

        $contents = fread($file, filesize($filename));
        fclose($file);
        $options = [
            'Document' => [
                'Bytes' => $contents
            ],
            'FeatureTypes' => ['FORMS'],
        ];
        //Extract data from the document using aws Textract
        $result = $client->detectDocumentText($options);
        $blocks = $result['Blocks'];
        //dd($blocks);
        // dump(json_encode($result));

        foreach ($blocks as $key => $value) {
            if (isset($value['BlockType']) && $value['BlockType']) {
                $blockType = $value['BlockType'];
                if (isset($value['Text']) && $value['Text']) {

                    if ($blockType == 'LINE') {
                        $data->text = $value['Text'];
                        $data->confidence = $value['Confidence'];
                        array_push($texts,  $data->text . '-' . round($data->confidence));
                    }
                }
            }
        }

        //app('debugbar')->info($texts);
        //$this->address($texts, $request); //uncomment
        //$this->smartCardAndGreenBookID($texts, $request); //uncomment
        // $test = $this->proofOfBank($texts);
        // app('debugbar')->info($test);
        // $request->session()->put('IDNUMBER', $IdDataResult->Id);
        //$this->proofOfAddress($request);
        return $texts;
    }

    //Green book or Smart Card ID
    function smartCardAndGreenBookID($texts, Request $request)
    {
        $IDNO = array();
        $IdAndConfidence = array();
        $IssueDate = [];
        $Nationality = [];
        $IssueDateResultResponse = [];
        $tempData = [];
        $IdResult = '';

        try {
            for ($i = 0; $i <= count($texts); $i++) {
                if (isset($texts[$i])) {
                    if (preg_match('(I.D.No.|I.D.No|No.)', $texts[$i]) === 1) {
                        for ($j = $i; $j < count($texts); $j++) {
                            $numberFromDoc =  filter_var($texts[$j], FILTER_SANITIZE_NUMBER_INT);
                            $temp =  explode("-", $numberFromDoc);
                            if ((strlen($temp[0])) >= 12) {
                                app('debugbar')->info('ID Number: ' . $temp[0]);
                                $IdAndConfidence = $temp;
                            }
                            array_push($tempData, $temp);
                        }
                        array_push($IdAndConfidence, 'GREEN BOOK');
                        // $IDNO[0]  = filter_var($texts[$i], FILTER_SANITIZE_NUMBER_INT);
                        // $IdAndConfidence = explode("-", $IDNO[0]); 
                        // $request->session()->put('IDNUMBER', $IdDataResult-s>Id);
                    } else if (preg_match('(Identity Number|identity Number)', $texts[$i]) === 1) {
                        for ($j = $i; $j < count($texts); $j++) {
                            $numberFromDoc =  filter_var($texts[$j], FILTER_SANITIZE_NUMBER_INT);
                            $temp =  explode("-", $numberFromDoc);
                            if ((strlen($temp[0])) >= 12) {
                                app('debugbar')->info('ID Number: ' . $temp[0]);
                                $IdAndConfidence = $temp;
                            }
                            array_push($tempData, $temp);
                        }
                        // $IDNO[0] = $texts[$i + 1];
                        // $IdAndConfidence = explode("-", $IDNO[0]);
                        array_push($IdAndConfidence, 'SMART CARD');
                    }
                    //Find green book Issue Date
                    if (preg_match('(DATE ISSUED)', $texts[$i]) === 1) {
                        $IssueDate  =   $texts[$i + 2];
                        $IssueDateResult = substr($IssueDate, 0, -3);
                        array_push($IssueDateResultResponse, $IssueDateResult);
                    }
                    //Find smart card Issue Date
                    if (preg_match('(Date of Issue)', $texts[$i]) === 1) {
                        $IssueDate  =   $texts[$i + 2];
                        $IssueDateResult = substr($IssueDate, 0, -3);
                        array_push($IssueDateResultResponse, $IssueDateResult);
                    }
                    // if (preg_match('(RSA|HOME AFFAIRS)', $texts[$i]) === 1) {
                    //     array_push($Nationality, 'SOUTH AFRICA');
                    // }
                    if (preg_match('(SOUTH AFRICA|RSA|SUID-AFRIKA|HOME AFFAIRS)', $texts[$i]) === 1) {
                        array_push($Nationality, 'SOUTH AFRICA');
                    }
                }
            }
            array_push($IdAndConfidence, isset($IssueDateResultResponse[0]) ? $IssueDateResultResponse[0] : null);
            array_push($IdAndConfidence, $Nationality[0], isset($Nationality[0]) ? $Nationality[0] : null);
            app('debugbar')->info($tempData);
            app('debugbar')->info($IdAndConfidence);
            //ID Data formarted

            $IDResults = ([
                'IdNumber' => '',
                'ID_Status' => Null,
                'message' => '',
                'status' => false
            ]);


            $idasIdLookup = LookupDatas::where('ID', '=', $this->IDAS_ID)->first();


            $verifyData = new VerificationDataController(); //Uncomment
            // app('debugbar')->info($verifyData);
            if (isset($IdAndConfidence[0], $IdAndConfidence[1])) {
                $IdData = ['Id' => $IdAndConfidence[0], 'Score' => $IdAndConfidence[1], 'IdType' => isset($IdAndConfidence[2]) ? $IdAndConfidence[2] : null, 'DateOfIssue' => isset($IdAndConfidence[3]) ? date('Y-m-d', strtotime($IdAndConfidence[3])) : null, 'Nationality' => $IdAndConfidence[4]];
                $IdDataResult = (object) $IdData;
                app('debugbar')->info($IdDataResult);
                if (strlen($IdDataResult->Id) == 13 && $IdDataResult->Score >= 50) {
                    //1.save to database
                    $dataValidated = $verifyData->verifyClientData($IdDataResult->Id, $request);
                    $IdResult =   $dataValidated;
                    $ficaId = ConsumerIdentity::where('Identity_Document_ID', '=', $dataValidated)->first();
                    //  $fica = FICA::where('FICA_id', '=', $ficaId->FICA_id)->where('FICAStatus', '=', 'In progress')->first();
                    $loggedInUserId = Auth::user()->Id;
                    $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
                    //$consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
                    // $customerUser = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
                    $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
                    $fica = FICA::where('Consumerid', '=', $consumer->Consumerid)->first();
                    $customers = Customer::where('Id', '=',  $customerUser->CustomerId)->first();
                    $customerID = $customers->Id;
                    // $ficaProgress = isset($fica->FICAProgress) ? $fica->FICAProgress + 1 : 1;

                    // $ficaProgress = $fica->FICAProgress == null ? 0 + 1 : $fica->FICAProgress + 1;

                    // app('debugbar')->info($fica);

                    app('debugbar')->info($IdDataResult);

                    //save data on the TBL_Consumer_IDENTITY
                    ConsumerIdentity::where('Identity_Document_ID', $dataValidated)->update(
                        array(
                            'Identity_Document_TYPE' =>  $IdDataResult->IdType,
                            'ID_DateofIssue' => isset($IdDataResult->DateOfIssue) ? $IdDataResult->DateOfIssue : null,
                            'ID_CountryResidence' => $IdDataResult->Nationality
                        )
                    );

                    // app('debugbar')->info('Fica test: ' . $fica->FICA_id);
                    //save data on the FICA
                    // FICA::where('FICA_id', $fica->FICA_id)->update(
                    //     array(
                    //         'IDAS_Status' => date("Y-m-d H:i:s"),
                    //         'ID_Status' => date("Y-m-d H:i:s"),
                    //         'FICAProgress' =>  $ficaProgress
                    //     )
                    // );

                    $request->session()->put('FICAProgress', $fica->FICAProgress);

                    //API LOGS
                    APILogs::create([
                        'API_Log_Id' => Str::upper(Str::uuid()),
                        'FICAId' => $fica->FICA_id,
                        'ConsumerID' => $fica->Consumerid,
                        'CustomerID' => $customerID,
                        'Createddate' => date("Y-m-d H:i:s"),
                        'API_ID' => $idasIdLookup->Value
                    ]);


                    $IDResults = ([
                        'IdNumber' => $dataValidated,
                        'ID_Status' => $fica->ID_Status,
                        'message' => 'ID Document submited successfully',
                        'status' => true
                    ]);
                } else if (strlen($IdDataResult->Id) >= 11 || $IdDataResult->Id < 13 && $IdDataResult->Score >= 50) {
                    $dataValidated = $verifyData->verifyClientData($IdDataResult->Id, $request);
                    $IdResult =  $dataValidated;
                    $ficaId = ConsumerIdentity::where('Identity_Document_ID', '=', $dataValidated)->first();
                    $fica = FICA::where('FICA_id', '=', $ficaId->FICA_id)->first();

                    // $customerUser = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
                    $loggedInUserId = Auth::user()->Id;
                    $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
                    $customers = Customer::where('Id', '=',  $customerUser->CustomerId)->first();
                    $customerID = $customers->Id;
                    $ficaProgress = isset($fica->FICAProgress) ? $fica->FICAProgress + 1 : 1;

                    //FICA Progress
                    // $ficaProgress = $fica->FICAProgress == null ? 0 + 1 : $fica->FICAProgress + 1;

                    ConsumerIdentity::where('Identity_Document_ID', $dataValidated)->update(
                        array(
                            'Identity_Document_TYPE' =>  $IdDataResult->IdType,
                            'ID_DateofIssue' => isset($IdDataResult->DateOfIssue) ? $IdDataResult->DateOfIssue : null,
                            'ID_CountryResidence' => $IdDataResult->Nationality
                        )
                    );

                    // FICA::where('FICA_id', $ficaId->FICA_id)->update(
                    //     array(
                    //         'IDAS_Status' => date("Y-m-d H:i:s"),
                    //         'ID_Status' => date("Y-m-d H:i:s"),
                    //         'FICAProgress' =>  $ficaProgress
                    //     )
                    // );

                    $request->session()->put('FICAProgress', $fica->FICAProgress);

                    //API LOGS
                    APILogs::create([
                        'API_Log_Id' => Str::upper(Str::uuid()),
                        'FICAId' => $fica->FICA_id,
                        'ConsumerID' => $fica->Consumerid,
                        'CustomerID' => $customerID,
                        'Createddate' => date("Y-m-d H:i:s"),
                        'API_ID' => $idasIdLookup->Value
                    ]);


                    $IDResults = ([
                        'IdNumber' => $dataValidated,
                        'ID_Status' => $fica->ID_Status,
                        'message' => 'ID Document submited successfully',
                        'status' => true
                    ]);
                } else {
                    $IDResults = ([
                        'IdNumber' => '',
                        'ID_Status' => NULL,
                        'message' => 'Please upload another document',
                        'status' => false
                    ]);
                }
            } else {
                //DateOfIssue not to important
                $IDResults = ([
                    'IdNumber' => '',
                    'ID_Status' => NULL,
                    'message' => 'DateOfIssue is not setted',
                    'status' => false
                ]);
                //app('debugbar')->info('DateOfIssue is not setted');
            }
        } catch (\Exception $e) {
            app('debugbar')->info($e);
            $IDResults = ([
                'IdNumber' => '',
                'ID_Status' => '',
                'message' => 'Please upload a correct ID document',
                'status' => false
            ]);
        }
        app('debugbar')->info($IDResults);
        return $IDResults;
        // $some_data = ['pass', 'data', 'view'];
        // return view('fica-process', compact(($some_data)));

    }

    function identitySubmit(Request $request)
    {
        // dd($request);
        //$consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $fica = FICA::where('Consumerid', '=', $consumer->Consumerid)->first();
        $ficaProgress = isset($fica->FICAProgress) ? $fica->FICAProgress + 1 : 1;
        // app('debugbar')->info($request);

        FICA::where('FICA_id', $fica->FICA_id)->update(
            array(
                'IDAS_Status' => date("Y-m-d H:i:s"),
                'ID_Status' => date("Y-m-d H:i:s"),
                'FICAProgress' =>  $ficaProgress
            )
        );

        return redirect('fica');
    }

    //Proof of Address
    function address($texts, Request $request)
    {
        try {
            $loggedInUserId = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
            $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            $addressLookUpHomeValue = LookupDatas::where('ID', '=',  $this->homeAddressIDType)->first();
            $addressLookUpPostalValue = LookupDatas::where('ID', '=',   $this->PostalAddressIDType)->first();
            $addressLookUpWorkValue = LookupDatas::where('ID', '=',   $this->WorkAddressIDType)->first();
            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            //  $customerUser = CustomerUser::where('Id', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            $consumerIdentity = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
            $request->session()->put('dataTextracted', $texts);


            $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
            $postalAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 15)->first();
            $workAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 14)->first();

            $DOB =  date('Y-m-d', strtotime($consumerIdentity->DOB));
            $selectedIndustryofoccupation =  $consumer->Industryofoccupation;

            //Check if addresses exist
            $homeAddressExist =  $homeAddress != null ? true : false;
            $postalAddressExist =  $postalAddress != null ? true : false;
            $workAddressExist =  $workAddress != null ? true : false;
            $isDateValide = false;

            $addressResponse = ([
                'message' => '',
                'status' => false
            ]);



            $documentDate = array();
            for ($i = 0; $i <= count($texts); $i++) {

                if (isset($texts[$i])) {
                    if (preg_match('(2023|2022|2021|2020|2019|2017)', $texts[$i]) === 1) {
                        $removeScore =  str_replace(array(',', '-', '/'), '', substr($texts[$i], 0, -3));
                        $lowercasesMonth = strtolower($removeScore);
                        if (preg_match('(jan(uary)?|feb(ruary)?|mar(ch)?|apr(il)?|may|jun(e)?|jul(y)?|aug(ust)?|sep(tember)?|oct(ober)?|nov(ember)?|dec(ember)?)',  $lowercasesMonth) === 1) {
                            $dateArr =  date_parse($lowercasesMonth);
                            $year =  $dateArr['year'];
                            $month =  $dateArr['month'];
                            $day =  $dateArr['day'];
                            $dateFormart = $day . '/' . $month . '/' . $year;
                            // $dateFormart2 = $year . '/' . $month . '/' . $day;
                            array_push($documentDate, $dateFormart);
                        }
                        if (preg_match('(jan(uary)?|feb(ruary)?|mar(ch)?|apr(il)?|may|jun(e)?|jul(y)?|aug(ust)?|sep(tember)?|oct(ober)?|nov(ember)?|dec(ember)?)',  $lowercasesMonth) === 0) {
                            $dateChars = substr($removeScore, -10);
                            array_push($documentDate,  $dateChars);
                        }
                    }
                }
            }


            //get the latest date in the document
            //if the document doesnt have a date, default it to 1990-01-01
            if ($documentDate == null) {

                $documentDate = ["19900101"];
                $date_arr = $documentDate;
                usort($date_arr, function ($a, $b) {
                    $dateTimestamp1 = strtotime($a);
                    $dateTimestamp2 = strtotime($b);

                    $isDateValide = true;
                    $addressResponse = ([
                        'message' => 'date is valide',
                        'status' => true
                    ]);

                    return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
                });
            }


            //if the document has a date
            else {

                $date_arr = $documentDate;
                app('debugbar')->info($documentDate);
                usort($date_arr, function ($a, $b) {
                    $dateTimestamp1 = strtotime($a);
                    $dateTimestamp2 = strtotime($b);

                    $isDateValide = true;
                    $addressResponse = ([
                        'message' => 'date is valide',
                        'status' => true
                    ]);

                    return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
                });
            }


            if ($documentDate == null) {

                $documentDate =  "19900101";
                $currentdate = date("Y-m-d");
                $docdate  =   date('Y-m-d', strtotime($documentDate));

                //get months between two months
                $months = $this->getNumberOfMonths($currentdate, $docdate);
                app('debugbar')->info('months: ' . $months);

                // app('debugbar')->info($months);
                $request->session()->put('docDate', $date_arr[count($date_arr) - 1]);

                // $months = 10;
            } else {
                $documentDate =  $date_arr[count($date_arr) - 1];
                //  $documentDate =  $date_arr[count($date_arr) - 1];
                $currentdate = date("Y-m-d");
                $docdate  =   date('Y-m-d', strtotime($documentDate));



                //get months between two months
                $months = $this->getNumberOfMonths($currentdate, $docdate);
                app('debugbar')->info('months: ' . $months);

                // app('debugbar')->info($months);
                $request->session()->put('docDate', $date_arr[count($date_arr) - 1]);
                // $months = 10;
            }

            return  $months;
        } catch (\Exception $e) {
            $addressResponse = ([
                'message' => 'date is not valide',
                'status' => false
            ]);
        }

        // app('debugbar')->info($request);

        // return back()->withSuccess('Document date  successfully');
        return view('fica-process', [
            'fica' => $fica, 'consumer' => $consumer, 'homeAddressExist' => $homeAddressExist, 'postalAddressExist' => $postalAddressExist, 'workAddressExist' => $workAddressExist,
            'homeAddress' => $homeAddress, 'postalAddress' => $postalAddress, 'workAddress' => $workAddress, 'consumerIdentity' => $consumerIdentity, 'customerUser' => $customerUser,
            'DOB' => $DOB, 'selectedIndustryofoccupation' => $selectedIndustryofoccupation
        ]);
    }

    function proofOfAddress(Request $request)
    {
        // try {
        $this->validate(
            $request,
            [
                'py-street-line-1' => ['required', 'string', 'min:2', 'max:255'],
                'py-street-line-2' => ['required', 'string', 'min:2', 'max:255'],
                'py-city' => ['required'],
                'py-state' => ['required'],
                'py-zip' => ['required'],
                'checkbox-address' => 'sometimes',
                'po-street-line-1' => ['required_without:checkbox-address', 'max:255'],
                'po-street-line-2' => ['required_without:checkbox-address', 'max:255'],
                'po-city' => ['required_without:checkbox-address'],
                'po-state' => ['required_without:checkbox-address'],
                'po-zip' => ['required_without:checkbox-address'],
            ],
            [
                'py-street-line-1.required' => 'The address line 1 is required.',
                'py-street-line-1.min' => 'The address line 1 must be at least 2 characters..',
                'py-street-line-2.required' => 'The address line 2 is required.',
                'py-street-line-2.min' => 'The address line 2 must be at least 2 characters..',
                'py-city.required' => 'The city is required.',
                'py-state.required' => 'The state is required.',
                'py-zip.required' => 'The zip is required.',

                'po-street-line-1.required_without' => 'The address line 1 is required.',
                //'po-street-line-1.min' => 'The address line 1 must be at least 2 characters..',
                'po-street-line-2.required_without' => 'The address line 2 is required.',
                //'po-street-line-2.min' => 'The address line 2 must be at least 2 characters..',
                'po-city.required_without' => 'The city is required.',
                'po-state.required_without' => 'The state is required.',
                'po-zip.required_without' => 'The zip is required.',
            ]
        );

        $etextractedData =  $request->session()->get('dataTextracted');
        $documentDate =   $request->session()->get('docDate');
        $currentdate = date("Y-m-d");
        // $docdate  = DateTime::createFromFormat('d/m/Y', $documentDate);
        // $docdateFormart =  $docdate->format('Y-m-d');
        $docdate  =   date('Y-m-d', strtotime($documentDate));

        //get months between two months
        $months = $this->getNumberOfMonths($currentdate, $docdate);

        // app('debugbar')->info($months);
        $addressDetails = [];
        // app('debugbar')->info($etextractedData);
        //Residental address input
        $streetName1 = strtoupper($request->input('py-street-line-1'));
        $streetName2 = strtoupper($request->input('py-street-line-2'));
        $city = strtoupper($request->input('py-city'));
        $state = strtoupper($request->input('py-state'));
        $zip = $request->input('py-zip');
        $isChecked = $request->input('checkbox-address');

        // app('debugbar')->info($isChecked);

        //postal Address input
        $postalStreetName1 = strtoupper($request->input('po-street-line-1'));
        $postalStreetName2 = strtoupper($request->input('po-street-line-2'));
        $postalCity = strtoupper($request->input('po-city'));
        $PostalState = strtoupper($request->input('po-state'));
        $PostalZip = $request->input('po-zip');

        $AddressResult = ([
            'streetName1' => $streetName1,
            'streetName2' => $streetName2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,

            'postalStreetName1' => $postalStreetName1,
            'postalStreetName2' => $postalStreetName2,
            'postalCity' => $postalCity,
            'PostalState' => $PostalState,
            'PostalZip' => $PostalZip,
        ]);

        // $request->session()->put('AddressResult', $AddressResult);
        // app('debugbar')->info($streetName1 . ' ' .  $streetName2);



        $streetName1Arra = explode(" ", $streetName1);
        $streetName2Arra = explode(" ", $streetName2);

        $strLen1 = count($streetName1Arra);
        $strLen2 = count($streetName2Arra);


        for ($i = 0; $i <= count($etextractedData); $i++) {
            if (isset($etextractedData[$i], $streetName1, $streetName2, $zip)) {
                $uppercase = strtoupper($etextractedData[$i]);
                $removescore = str_replace(array(',', '-', '/'), '', substr($uppercase, 0, -3));

                if ($strLen1 > 0) {
                    for ($j = 0; $j < $strLen1; $j++) {
                        if (preg_match("($streetName1Arra[$j])", $removescore) === 1) {
                            array_push($addressDetails,  $removescore);
                        }
                    }
                }

                if ($strLen2 > 0) {
                    for ($j = 0; $j < $strLen2; $j++) {
                        if (preg_match("($streetName2Arra[$j])", $removescore) === 1) {
                            array_push($addressDetails,  $removescore);
                        }
                    }
                }
                if (preg_match("($zip)", $removescore) === 1) {
                    array_push($addressDetails,  $removescore);
                }
            }
        }


        $resultAddress = array_unique($addressDetails); //uncomment
        app('debugbar')->info($resultAddress);
        $addressPerc =  $this->getAddressFromIDSA($resultAddress);
        app('debugbar')->info('addressPerc: ' . $addressPerc);

        $addressResponse = ([
            'message' => '',
            'status' => false
        ]);

        $addressLookUpHomeValue = LookupDatas::where('ID', '=',  $this->homeAddressIDType)->first();
        $addressLookUpPostalValue = LookupDatas::where('ID', '=',   $this->PostalAddressIDType)->first();
        $addressLookUpWorkValue = LookupDatas::where('ID', '=',   $this->WorkAddressIDType)->first();
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
        // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        // $customerUser = CustomerUser::where('Id', '=',  session()->get('LoggedUser'))->first();
        // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        $consumerIdentity = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();

        $request->session()->put('FICAProgress', $fica->FICAProgress);

        //get addresses
        $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
        $postalAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 15)->first();
        $workAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 14)->first();

        $DOB =  date('Y-m-d', strtotime($consumerIdentity->DOB));
        $selectedIndustryofoccupation =  $consumer->Industryofoccupation;
        //Check if addresses exist
        $homeAddressExist =  $homeAddress != null ? true : false;
        $postalAddressExist =  $postalAddress != null ? true : false;
        $workAddressExist =  $workAddress != null ? true : false;


        //app('debugbar')->info($addressLookUpHomeValue->Value);

        //months must not be more then 3 months
        // if ($months <= 700) {
        if ($addressPerc >= 0) { //should be $addressPerc > 50

            //fica progress status
            $ficaProgress = $fica->FICAProgress + 1;

            //update KYC detalis
            KYC::where('FICA_id', $fica->FICA_id)->update(
                array(
                    'CreatedOnDate' =>  date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    // 'KYC_Status' => 1,
                    'DateonDocument' => $documentDate
                )
            );

            //update FICA detalis
            FICA::where('Consumerid', $consumer->Consumerid)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAProgress' =>  $ficaProgress,
                    'KYC_Status' => date("Y-m-d H:i:s")
                )
            );
            $request->session()->put('FICAProgress', $fica->FICAProgress);

            //home address
            if ($homeAddress != null) {
                //If Home Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $homeAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
            }
            //Postal
            if ($postalAddress != null) {
                //If Postal Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $postalAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
            }

            if ($isChecked == null) {
                if (
                    isset($streetName1) && isset($streetName2) && isset($city) && isset($state) && isset($zip)
                    && isset($postalStreetName1) && isset($postalStreetName2) && isset($postalCity) && isset($PostalState) && isset($PostalZip)
                ) {
                    $homeAddress = Address::create([
                        'ConsumerID' => $consumer->Consumerid,
                        'AddressTypeInd' => $addressLookUpHomeValue->Value,
                        'OriginalAddress1' => $streetName1,
                        'OriginalAddress2' =>   $streetName2,
                        'OriginalAddress3' => $city,
                        'OriginalAddress4' => $state,
                        'OriginalPostalCode' => $zip,
                        'RecordStatusInd' => 1,
                        'CreatedOnDate' => date("Y-m-d H:i:s"),
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    ]);
                    $postalAddress = Address::create([
                        'ConsumerID' => $consumer->Consumerid,
                        'AddressTypeInd' => $addressLookUpPostalValue->Value,
                        'OriginalAddress1' => $postalStreetName1,
                        'OriginalAddress2' => $postalStreetName2,
                        'OriginalAddress3' => $postalCity,
                        'OriginalAddress4' => $PostalState,
                        'OriginalPostalCode' => $PostalZip,
                        'RecordStatusInd' => 1,
                        'CreatedOnDate' => date("Y-m-d H:i:s"),
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    ]);
                }
            } else {
                if (isset($streetName1) && isset($streetName2) && isset($city) && isset($state) && isset($zip)) {
                    $homeAddress = Address::create([
                        'ConsumerID' => $consumer->Consumerid,
                        'AddressTypeInd' => $addressLookUpHomeValue->Value,
                        'OriginalAddress1' => $streetName1,
                        'OriginalAddress2' =>   $streetName2,
                        'OriginalAddress3' => $city,
                        'OriginalAddress4' => $state,
                        'OriginalPostalCode' => $zip,
                        'RecordStatusInd' => 1,
                        'CreatedOnDate' => date("Y-m-d H:i:s"),
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    ]);

                    $postalAddress = Address::create([
                        'ConsumerID' => $consumer->Consumerid,
                        'AddressTypeInd' => $addressLookUpPostalValue->Value,
                        'OriginalAddress1' => $streetName1,
                        'OriginalAddress2' => $streetName2,
                        'OriginalAddress3' => $city,
                        'OriginalAddress4' => $state,
                        'OriginalPostalCode' => $zip,
                        'RecordStatusInd' => 1,
                        'CreatedOnDate' => date("Y-m-d H:i:s"),
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    ]);
                }
            }
            $homeAddress->save();
            $postalAddress->save();


            $addressResponse = ([
                'message' => 'Address has been Validated Successfully!',
                'status' => true
            ]);
            $request->session()->put('AddressStatus', $addressResponse['status']);
            $response = ['data' =>  $addressResponse];
            return $response;
        } else {
            $addressResponse = ([
                'message' => 'Address is not matching', //'message' => 'Address is not matching',
                'status' => false
            ]);
            $response = ['data' =>  $addressResponse];
            app('debugbar')->info($addressResponse);
            return $response;
        }
        // } else {
        //     //return a message to tell the user that date is more than 3 months
        //     app('debugbar')->info('Document date is more then 3 month!');
        //     $addressResponse = ([
        //         'message' => 'Document date is older than 3 month',
        //         'status' => false
        //     ]);
        //     $response = ['data' =>  $addressResponse];
        //     app('debugbar')->info($addressResponse);
        //     return $response;
        // }
        // } catch (\Exception $e) {
        //     $addressResponse = ([
        //         'message' => 'Address has failed to Validate!',
        //         'status' => false
        //     ]);
        //  }


        return view('fica-process', [
            'fica' => $fica, 'consumer' => $consumer, 'homeAddressExist' => $homeAddressExist, 'postalAddressExist' => $postalAddressExist, 'workAddressExist' => $workAddressExist,
            'homeAddress' => $homeAddress, 'postalAddress' => $postalAddress, 'workAddress' => $workAddress, 'consumerIdentity' => $consumerIdentity, 'customerUser' => $customerUser,
            'DOB' => $DOB, 'selectedIndustryofoccupation' => $selectedIndustryofoccupation, 'avs' => $avs
        ]);
    }

    function getAddressFromIDSA($resultAddress)
    {
        try {
            $loggedInUserId = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
            //app('debugbar')->info($resultAddress);
            // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();

            $client = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
            //$client = ConsumerIdentity::where('Identity_Document_ID', '=', '9212055358081')->first();

            //$addressOnIDAS = [];

            // app('debugbar')->info($resultAddress);
            $HOME_ADDRESS1_LINE_1 = $client->HOME_ADDRESS1_LINE_1;
            $HOME_ADDRESS1_LINE_2 = $client->HOME_ADDRESS1_LINE_2;

            $HOME_ADDRESS2_LINE_1 = $client->HOME_ADDRESS2_LINE_1;
            $HOME_ADDRESS2_LINE_2 = $client->HOME_ADDRESS2_LINE_2;

            $HOME_ADDRESS3_LINE_1 = $client->HOME_ADDRESS3_LINE_1;
            $HOME_ADDRESS3_LINE_2 = $client->HOME_ADDRESS3_LINE_2;

            $addressOnIDAS = array(
                "HOME_ADDRESS1_LINE_1" =>  $HOME_ADDRESS1_LINE_1,
                "HOME_ADDRESS1_LINE_2" =>  $HOME_ADDRESS1_LINE_2,
                "HOME_ADDRESS2_LINE_1" => $HOME_ADDRESS2_LINE_1,
                "HOME_ADDRESS2_LINE_2" =>  $HOME_ADDRESS2_LINE_2,
                "HOME_ADDRESS3_LINE_1" => $HOME_ADDRESS3_LINE_1,
                "HOME_ADDRESS3_LINE_2" => $HOME_ADDRESS3_LINE_2
            );

            app('debugbar')->info($addressOnIDAS);
            $perc = $this->getAddressPercentageAccuracy($resultAddress, $addressOnIDAS);
            // app('debugbar')->info($perc);
            return $perc;
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    function getAddressPercentageAccuracy($addresses, $homeAddresses)
    {
        // app('debugbar')->info($homeAddresses);
        $finalResults = 0;
        $count = 0;
        try {
            foreach ($addresses as $address) {
                foreach ($homeAddresses as $homeAddress) {
                    $s1 = $address;
                    $s2 = $homeAddress;
                    $words1 = preg_split('/\s+/', $s1);
                    $words2 = preg_split('/\s+/', $s2);
                    $diffs1 = array_diff($words2, $words1);
                    $diffs2 = array_diff($words1, $words2);

                    $diffsLength = strlen(join("", $diffs1) . join("", $diffs2));
                    $wordsLength = strlen(join("", $words1) . join("", $words2));
                    if (!$wordsLength) return 0;

                    $differenceRate = ($diffsLength / $wordsLength);
                    $similarityRate = (1 - $differenceRate) * 100;
                    //app('debugbar')->info($similarityRate);
                    if ($similarityRate > 50) {
                        $finalResults = $finalResults +  $similarityRate;
                        $count++;
                        app('debugbar')->info($s1 . ' - ' . $s2 . ': ' . $similarityRate); //uncooment
                    }
                }
                //print_r($similarityRate);
            }
            $countResult = $count * 100;
            $percSimilarityResult = ($countResult > 0) ? ($finalResults / $countResult) * 100 : 0;
            app('debugbar')->info((int)$percSimilarityResult);
            return (int)$percSimilarityResult;
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    function getNumberOfMonths($currentdate, $docdate)
    {
        try {
            $d1 = strtotime($currentdate);
            $d2 = strtotime($docdate);
            // $totalSecondsDiff = abs($d1 - $d2);
            // $totalMonthsDiff  = $totalSecondsDiff / 60 / 60 / 24 / 30;
            // $timestamp = strtotime($str);
            $d1 = new DateTime($currentdate);
            $d2 = new DateTime($docdate);

            $Months = $d2->diff($d1)->m + ($d2->diff($d1)->y * 12);
            //app('debugbar')->info($Months);
            return $Months;
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    function bankDetails($texts, Request $request)
    {

        try {
            //app('debugbar')->info($request);
            $bankDataText = $request->session()->put('bankTextractedDetails', $texts);
            $bankData = array();
            $bankAccountNumber = array();
            $bankResult = array();
            foreach ($texts as $bankdetail) {
                $uppercasebankdetail = strtoupper($bankdetail);
                if (isset($uppercasebankdetail)) {
                    //FIRST NATIONAL BANK
                    if (preg_match('(FNB|FIRST NATIONAL BANK)', $uppercasebankdetail) === 1) {
                        array_push($bankData, "FIRST NATIONAL BANK");
                    };

                    //CAPITEC
                    if (preg_match('(CAPITEC)', $uppercasebankdetail) === 1) {
                        array_push($bankData, "CAPITEC");
                    };

                    //STANDARD BANK)
                    if (preg_match('(STANDARD BANK)', $uppercasebankdetail) === 1) {
                        array_push($bankData, "STANDARD BANK");
                    };
                }
            }
            $resultBank = array_unique($bankData);
            //app('debugbar')->info($resultBank[0]);
            $request->session()->put('bankTextractedDetails', $texts);
            // $this->proofOfBank($request);


            // foreach ($texts as $bankdetail) {

            //     $removeScore =  str_replace(array(',', '-'), '', substr($bankdetail, 0, -3));
            //     // app('debugbar')->info($removeScore);
            //     if (preg_match("($accNumber)", $removeScore) === 1) {
            //         // $accNumberAndScore = explode("-", $bankdetail);
            //         $accountNoIsValid = true;
            //         $accountNumber = $removeScore;
            //     };
            // }
            return $resultBank[0];
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }

    function proofOfBank(Request $request)
    {

        // $this->validate($request, [
        //     'initials' => 'required',
        //     'surname' => 'required',
        //     'acc-number' => 'required|numeric',
        //     'bank-name-dd' => 'required',
        //     'BankTypeid' => 'required',
        //     'branch' => 'required|numeric'
        // ]);

        // try {
        $this->validate(
            $request,
            [
                'initials' => ['required', 'string', 'min:2', 'max:255'],
                'surname' => ['required', 'string', 'min:5', 'max:255'],
                'acc-number' => ['required', 'numeric'],
                'bank-name-dd' => ['required'],
                'BankTypeid' => ['required'],
                'branch' => ['required', 'numeric'],
            ],
            [
                'initials.required' => 'The initials is required.',
                'surname.required' => 'The surname is required.',
                'surname.min' => 'The surname  must be at least 5 characters..',
                'acc-number.required' => 'The account number is required.',
                'acc-number.numeric' => 'The account number must be numeric.',
                'bank-name-dd.required' => 'The bank name is required.',
                'BankTypeid.required' => 'The Bank Code is required.',
                'branch.required' => 'The Bank Type is required.',
            ]
        );

        // try {
        $bankDataExtracted =  $request->session()->get('bankTextractedDetails');
        $bankName = $this->bankDetails($bankDataExtracted, $request);
        $bankTpye = BankAccountType::all();

        $initials = $request->input('initials');
        $surname = $request->input('surname');
        $accNumber = $request->input('acc-number');
        $bankName = $request->input('bank-name-dd');
        $bankTpyeid = $request->input('BankTypeid');
        $branch = $request->input('branch');

        $bankInfo = BankAccountType::where('BankTypeid', '=',  (int)$bankTpyeid)->first();

        app('debugbar')->info($request);

        $bankResult = ([
            'initials' => $initials,
            'surname' => $surname,
            'accNumber' => $accNumber,
            'bankName' => $bankName,
            'BankType' =>   $bankInfo->Account_description,
            'branch' => $branch
        ]);
        app('debugbar')->info($bankResult);

        $request->session()->put('bankResult', $bankResult);

        $bankResponse =  new stdClass();

        // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();

        $request->session()->put('FICAProgress', $fica->FICAProgress);


        //$test = ($fica->FICAProgress) + 1;
        //app('debugbar')->info($test);
        $accNumberAndScore = [];
        $accountNoIsValid = false; // $accountNoIsValid = false
        $accountNumber = '';

        foreach ($bankDataExtracted as $bankdetail) {

            $removeScore =  str_replace(array(',', '-', ' '), '', substr($bankdetail, 0, -3));
            // app('debugbar')->info($removeScore);
            if (preg_match("($accNumber)", $removeScore) === 1) {
                // $accNumberAndScore = explode("-", $bankdetail);
                $accountNoIsValid = true;
                $accountNumber = $removeScore;
            };
        }

        if ($accountNoIsValid) {
            $ficaProgress = $fica->FICAProgress + 1;

            //Save data if the AccNo is valid
            app('debugbar')->info('accountNoIsValid: ' . $accountNoIsValid);
            AVS::where('FICA_id', $fica->FICA_id)->update(
                array(
                    'Bank_name' =>  $bankName,
                    'Account_no' => $accNumber,
                    'Account_name' => $initials . ' ' . $surname,
                    'Branch_code' =>  $branch,
                    'BankTypeid' => (int)$bankTpyeid
                )
            );

            FICA::where('Consumerid', $consumer->Consumerid)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAProgress' =>  $ficaProgress,
                    'AVS_Status' => date("Y-m-d H:i:s")
                )
            );
            $request->session()->put('FICAProgress', $fica->FICAProgress);

            $bankResponse->status = true;
            $bankResponse->accountNo = $accNumber;
            $bankResponse->message = 'Bank details was successfully validated';

            $response = ['data' =>  $bankResponse];
            return $response;
        } else {
            //app('debugbar')->info('Account Number not valid');
            $bankResponse->status = false;
            $bankResponse->message = 'We cannot determine a valid Account Number';
            $response = ['data' =>  $bankResponse];
            app('debugbar')->info($response);
            return $response;
        }
        // } catch (\Exception $e) {
        //     $bankResponse->status = false;
        //     $bankResponse->message = 'Account Number not valid';
        //     $response = ['data' =>  $bankResponse];
        //     app('debugbar')->info($response);
        //     return $response;
        // }

        $bankResponse->bankName = $bankName;
        app('debugbar')->info($bankResponse);

        // return $bankResponse;
        return view('fica-process', ['bankTpye' => $bankTpye,]);
    }
}
class OCRdata
{
    public $text;
    public $confidence;
}
