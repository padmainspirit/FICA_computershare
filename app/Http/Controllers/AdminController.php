<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerUser;
use App\Http\Controllers\Controller;
use App\Models\Consumer;
use App\Models\Customer;
use App\Models\SendEmail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:admin-dashboard', ['only' => ['ShowDashboard']]);
         $this->middleware('permission:admin-seach-user', ['only' => ['FindUsers']]);
    }

    public function ShowDashboard(Request $request)
    {

        // $idnumber = null;
        $request->session()->put('idnumber', null);
        // $findnote = SendEmail::all()->toArray();
        //$Consumerid = $request->session()->get('LoggedUser');
        $Consumerid =Auth::user()->Id;

        $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        $LogUserName = $getLogUser['FirstName'];
        $LogUserSurname = $getLogUser['LastName'];

        $request->session()->put('LogUserName', $LogUserName);
        $request->session()->put('LogUserSurname', $LogUserSurname);

        app('debugbar')->info($LogUserName);
        app('debugbar')->info($LogUserSurname);

        //$Customerid = $request->session()->get('Customerid');
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        // dd($Icon);


        $DashboardInfo = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Dashboard :Customerid"),
            [
                ':Customerid' => $Customerid
            ]
        );

        // dd($DashboardInfo);

        $DashboardData = $DashboardInfo[0] != '' ? $DashboardInfo[0] : null;

        // $DashboardData = [

        //     'NumClients' => $DashboardInfo != '' ? $DashboardInfo[0]->NumClients : null,
        //     'InProgress' => $DashboardInfo != '' ? $DashboardInfo[0]->InProgress : null,
        //     'Completed' => $DashboardInfo != '' ? $DashboardInfo[0]->Completed : null,
        //     'Rejected' => $DashboardInfo != '' ? $DashboardInfo[0]->Rejected : null,
        //     'Failed' => $DashboardInfo != '' ? $DashboardInfo[0]->Failed : null,
        //     'Correction' => $DashboardInfo != '' ? $DashboardInfo[0]->Correction : null,
        //     'HighRisk' => $DashboardInfo != '' ? $DashboardInfo[0]->HighRisk : null,
        //     'MediumRisk' => $DashboardInfo != '' ? $DashboardInfo[0]->MediumRisk : null,
        //     'LowRisk' => $DashboardInfo != '' ? $DashboardInfo[0]->LowRisk : null,
        //     'Oneto5Count' => $DashboardInfo != '' ? $DashboardInfo[0]->Oneto5Count : null,
        //     'Fiveto10Count' => $DashboardInfo != '' ? $DashboardInfo[0]->Fiveto10Count : null,
        //     'Tento15count' => $DashboardInfo != '' ? $DashboardInfo[0]->Tento15count : null,
        //     'Fifteenpluscount' => $DashboardInfo != '' ? $DashboardInfo[0]->Fifteenpluscount : null,

        // ];

        $NumClients = $DashboardInfo != '' ? $DashboardInfo[0]->NumClients : null;

        $HighRisk = $DashboardInfo != '' ? $DashboardInfo[0]->HighRisk : null;
        $MediumRisk = $DashboardInfo != '' ? $DashboardInfo[0]->MediumRisk : null;
        $LowRisk = $DashboardInfo != '' ? $DashboardInfo[0]->LowRisk : null;

        $HighPerc = $NumClients!= 0 ? (($HighRisk / $NumClients) * 100): 0;
        $MediumPerc = $NumClients!= 0 ? (($MediumRisk / $NumClients) * 100): 0;
        $LowPerc = $NumClients!= 0 ? (($LowRisk / $NumClients) * 100): 0;


        // $emailid = SendEmail::where('EmailID', '=',  $NotificationLink->EmailID)->first();
        // $allMessages = ['EmailMessage' => $getallMessages];
        // $Messages = $allMessages['EmailMessage'];

        // $EmailID = SendEmail::where('EmailID', '=', $findnote->EmailID)->first();


        // $request->session()->put('NotificationLink', $NotificationLink);

        // if (isset($_POST['remove'])) {
        //     $key=array_search($_GET['idnumber'],$_SESSION['idnumber']);
        //     if($key!==false)
        //     unset($_SESSION['idnumber'][$key]);
        //     $_SESSION["idnumber"] = array_values($_SESSION["idnumber"]);
        // } 

        if (session()->has('LoggedUser')) {
            session()->pull('FirstName');
            session()->pull('Surname');
            session()->pull('NotificationLink');
            session()->pull('maritialstatus');
            session()->pull('nationality');
            session()->pull('ResidentialAddress');
            session()->pull('Sources');
            session()->pull('TotalSourcesUsed');
            session()->pull('IDStatus');
            session()->pull('KYCStatusInd');
            session()->pull('Account_no');
            session()->pull('Branch_code');
            session()->pull('AccountType');
            session()->pull('Bank_name');
            session()->pull('ACCOUNT_OPEN');
            session()->pull('Identity_Document_TYPE');
            session()->pull('INITIALS');
            session()->pull('SURNAME');
            session()->pull('IDNUMBER');
            session()->pull('Email');
            session()->pull('CellularNo');
            session()->pull('Income_taxno');
            session()->pull('ACCOUNTDORMANT');
            session()->pull('ACCOUNTOPENFORATLEASTTHREEMONTHS');
            session()->pull('ACCOUNTACCEPTSDEBITS');
            session()->pull('ACCOUNTACCEPTSCREDITS');
            session()->pull('BankTypeid');
            session()->pull('ConsumerIDPhotoMatch');
            session()->pull('DeceasedStatus');
            session()->pull('MatchResponseCode');
            session()->pull('LivenessDetectionResult');
            session()->pull('Latitude');
            session()->pull('Longitude');
            session()->pull('email');
            session()->pull('ConsumerIDPhoto');
            session()->pull('ConsumerCapturedPhoto');
            session()->pull('SearchConsumerID');
            session()->pull('SearchFica');
            session()->pull('FICAStatusbyFICA');
            session()->pull('RiskStatusbyFICA');
            session()->pull('ProgressbyFICA');
            session()->pull('IDDoc');
            session()->pull('AddressDoc');
            session()->pull('BankDoc');
            session()->pull('kycstatus');
            session()->pull('bankstatus');
            session()->pull('facialrecognitionstatus');
            session()->pull('compliancestatus');
            session()->pull('FetchComplianceSanct');
            session()->pull('FetchComplianceAdd');
            session()->pull('residential');
            session()->pull('insidedata');
            session()->pull('ComplianceData');
            session()->pull('firstname');
            session()->pull('surname');
            session()->pull('consumerid');
            session()->pull('idnumber');
            session()->pull('TitleDesc');
            session()->pull('ContactNumbers');
            session()->pull('exception');
            session()->pull('message');
            session()->pull('SNameMatch');
            session()->pull('IDMatch');
            session()->pull('EmailMatch');
            session()->pull('TaxNumMatch');
            session()->pull('Tax_Number');
        }

        return view('admin-dashboard', [])

            ->with('DashboardData', $DashboardData)
            ->with('LowPerc', $LowPerc)
            ->with('MediumPerc', $MediumPerc)
            ->with('HighPerc', $HighPerc)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)
            ->with('customer', $customer)

            // ->with('NotificationLink', $NotificationLink)
            // ->with('NumClients', $NumClients)
            // ->with('InProgress', $InProgress)
            // ->with('Completed', $Completed)
            // ->with('Rejected', $Rejected)
            // ->with('Failed', $Failed)
            // ->with('Correction', $Correction)
            // ->with('HighRisk', $HighRisk)
            // ->with('MediumRisk', $MediumRisk)
            // ->with('LowRisk', $LowRisk)
            // ->with('Oneto5Count', $Oneto5Count)
            // ->with('Fiveto10Count', $Fiveto10Count)
            // ->with('Tento15count', $Tento15count)
            // ->with('Fifteenpluscount', $Fifteenpluscount)

            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname);
    }

    public function FindUsers(Request $request)
    {

        $Consumerid = $request->session()->get('LoggedUser');

        // app('debugbar')->info($Consumerid);

        /* $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        $LogUserName = $getLogUser['FirstName'];
        $LogUserSurname = $getLogUser['LastName']; */
        $LogUserName = Auth::user()->FirstName;
        $LogUserSurname = Auth::user()->LastName;
        // $SearchConsumerID = $request->session()->get('SearchConsumerID');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $SearchConsumerID)->where('IsRead', '=', '1')->get();
        // $request->session()->put('NotificationLink', $NotificationLink);

        // $NotificationLink = $request->session()->get('NotificationLink');

        // $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?', ['4717E73D-1F3F-4ACE-BE1A-0244770D6272', '2', '', 'Naidoo']);


        // $RefData = [
        //     'consumerid' => "D834D56E-5896-4FDD-99CF-7E0476FD8A8A",
        //     'FirstName' => "Mischa",
        //     'SecondName' => null,
        //     'Surname' => "Naidoo",
        //     'TitleCode' => "3",
        //     'IDNUMBER' => "7711025013082",
        //     'Email' => "mischa.naidoo@inspirit.co.za",
        //     'ClientUniqueRef' => null,
        //     'FICAStatus' => "Correction",
        //     'LastUpdatedDate' => "2022-09-06 08:14:36.000",
        // ];


        // app('debugbar')->info($clientsDetails);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        /* $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first(); */
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        if (session()->has('LoggedUser')) {
            session()->pull('idnumber');
            session()->pull('FirstName');
            session()->pull('Surname');
            session()->pull('maritialstatus');
            session()->pull('nationality');
            session()->pull('ResidentialAddress');
            session()->pull('Sources');
            session()->pull('TotalSourcesUsed');
            session()->pull('IDStatus');
            session()->pull('KYCStatusInd');
            session()->pull('Account_no');
            session()->pull('Branch_code');
            session()->pull('AccountType');
            session()->pull('Bank_name');
            session()->pull('ACCOUNT_OPEN');
            session()->pull('Identity_Document_TYPE');
            session()->pull('INITIALS');
            session()->pull('SURNAME');
            session()->pull('IDNUMBER');
            session()->pull('Email');
            session()->pull('CellularNo');
            session()->pull('Income_taxno');
            session()->pull('ACCOUNTDORMANT');
            session()->pull('ACCOUNTOPENFORATLEASTTHREEMONTHS');
            session()->pull('ACCOUNTACCEPTSDEBITS');
            session()->pull('ACCOUNTACCEPTSCREDITS');
            session()->pull('BankTypeid');
            session()->pull('ConsumerIDPhotoMatch');
            session()->pull('DeceasedStatus');
            session()->pull('MatchResponseCode');
            session()->pull('LivenessDetectionResult');
            session()->pull('Latitude');
            session()->pull('Longitude');
            session()->pull('email');
            session()->pull('ConsumerIDPhoto');
            session()->pull('ConsumerCapturedPhoto');
            session()->pull('SearchConsumerID');
            session()->pull('SearchFica');
            session()->pull('FICAStatusbyFICA');
            session()->pull('RiskStatusbyFICA');
            session()->pull('ProgressbyFICA');
            session()->pull('IDDoc');
            session()->pull('AddressDoc');
            session()->pull('BankDoc');
            session()->pull('kycstatus');
            session()->pull('bankstatus');
            session()->pull('facialrecognitionstatus');
            session()->pull('compliancestatus');
            session()->pull('FetchComplianceSanct');
            session()->pull('FetchComplianceAdd');
            session()->pull('residential');
            session()->pull('insidedata');
            session()->pull('ComplianceData');
            session()->pull('firstname');
            session()->pull('surname');
            session()->pull('consumerid');
            session()->pull('TitleDesc');
            session()->pull('ContactNumbers');
            session()->pull('message');
            session()->pull('SNameMatch');
            session()->pull('IDMatch');
            session()->pull('EmailMatch');
            session()->pull('TaxNumMatch');
            session()->pull('Tax_Number');
            // session()->pull('exception');
        }

        return view('admin-findusers')
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)
            ->with('Logo', $Logo)
            ->with('customer', $customer);
        // ->with('NotificationLink', $NotificationLink)
    }

    public function show()
    {

        // app('debugbar')->info('Testing');

        return view('admin-users');
    }


    public function Display(Request $request)
    {

        // app('debugbar')->info('Testing');


        // app('debugbar')->info($request);

        // $cusid = CustomerUser::where('CustomerId', '=', $request->CustomerId)->first();
        // $cusid = DB::connection("sqlsrv2")->select(DB::table('CustomerUsers')->where('CustomerId')->first());



        // $first = CustomerUser::where('FirstName', '=', session()->get('LoggedUser'))->first();
        // $last = CustomerUser::where('LastName', '=', session()->get('LoggedUser'))->first();
        // $cel = CustomerUser::where('PhoneNumber', '=', session()->get('LoggedUser'))->first();
        // $idno = CustomerUser::where('IDNumber', '=', session()->get('LoggedUser'))->first();

        // $customerid = "4717E73D-1F3F-4ACE-BE1A-0244770D6272";
        // $SearchType = "1";
        // $IDNUMBER = "0000000000000";

        // app('debugbar')->info($request);

        $SearchType = "0";


        $idno = $request->IDNumber;
        $first = $request->FirstName;
        $last = $request->LastName;
        $cel = $request->PhoneNumber;
        $status = $request->FICAStatus;
        $refnum = $request->ClientUniqueRef;
        // $cusid = $request->Id;


        if (!empty($idno) && empty($first) && empty($last) && empty($cel) && empty($refnum)) {
            $SearchType = "1";
        } else if (empty($idno) && empty($first) && !empty($last) && empty($cel) && empty($status) && empty($refnum)) {
            $SearchType = "2";
        } else if (empty($idno) && !empty($first) && empty($last) && empty($cel) && empty($status) && empty($refnum)) {
            $SearchType = "3";
        } else if (empty($idno) && !empty($first) && !empty($last) && empty($cel) && empty($status) && empty($refnum)) {
            $SearchType = "4";
        } else if (empty($idno) && empty($first) && empty($last) && !empty($cel) && empty($status) && empty($refnum)) {
            $SearchType = "5";
        } else if (empty($idno) && empty($first) && empty($last) && empty($cel) && !empty($status) && empty($refnum)) {
            $SearchType = "6";
        } else if (empty($idno) && empty($first) && empty($last) && empty($cel) && empty($status) && !empty($refnum)) {
            $SearchType = "7";
        }


        // }catch (\Exception $noUserLastName) {
        //     app('debugbar')->info($noUserLastName);

        //     $message = '';
        //     $noUserLastName = ([
        //         'IDNumber' => null,
        //         'FirstName' => null,
        //         'LastName' => null,
        //         'FICAStatus' => null,
        //         'ClientUniqueRef' => null,
        //         'PhoneNumber' => null,
        //     ]);

        //     if ($noUserLastName = true){
        //         $message = "No input found, please fill in at least one field.";
        //     }
        // }


        // app('debugbar')->info($noUserLastName);

        $customerid = $request->session()->get('Customerid');
        // $customerid = "4717E73D-1F3F-4ACE-BE1A-0244770D6272";
        $IDNUMBER = $request->IDNumber;
        $SURNAME = $request->LastName;
        $FIRSTNAME = $request->FirstName;
        $CONTACTNO = $request->PhoneNumber;
        $FICASTATUS = $request->FICAStatus;
        $CLIENTREF = $request->ClientUniqueRef;
        $searchResponse = (['status' => false, 'message' => '']);

        // app('debugbar')->info($SURNAME);

        // $values = [$customerid,$SearchType,$IDNUMBER];
        // $data = DB::select('EXEC sp_ConsumerSearch ?,?,?',$values);

        // $data = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?', [$customerid, $SearchType, $IDNUMBER]);

        try {
            switch ($SearchType) {
                case '1':

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?', [$customerid, $SearchType, $IDNUMBER]);
                    $idnum =  $clientsDetails[0]->IDNUMBER;

                    if ($clientsDetails == 'Undefined') {
                        $searchResponse = ([
                            'status' => false,
                            'message' => 'User not found'
                        ]);
                    }

                    app('debugbar')->info($clientsDetails);

                    // $dataArray = [
                    //     array("name" => "Ram", "age" => "21", "gender" => "Male", "occupation" => "Doctor"),
                    //     array("name" => "Mohan", "age" => "32", "gender" => "Male", "occupation" => "Teacher"),
                    //     array("name" => "Mlu", "age" => "40", "gender" => "Male", "occupation" => "Developer")
                    // ];

                    // return response()->json(["status" => true, "IDNUMBER" => $idnum ]);

                    if (!$idnum) {
                        return back()->with('fail', 'ID Number does not exsist');
                    } else {
                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    return view('admin-findusers');

                    break;
                case "2":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?', [$customerid, $SearchType, '', $SURNAME]);
                    $clientData = [];
                    foreach ($clientsDetails as  $x) {
                        array_push($clientData,  $x);
                    }
                    // dd($clientData);
                    // echo $clientData;
                    $lastname =  $clientsDetails[0]->Surname;

                    $idLen = strlen($clientsDetails[0]->IDNUMBER) == 13 ? true : false;
                    if ($idLen != true) {
                        $searchResponse = ([
                            'status' => false,
                            'message' => 'User not found'
                        ]);
                    }

                    // if (!$clientsDetails) {
                    //     return back()->with('fail', 'Surname does not exsist');
                    // } else {
                    //     $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails, 'searchResponse' => $searchResponse];
                    //     return  $output_data;

                    //     return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    // }

                    // app('debugbar')->info($test);

                    $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails, 'searchResponse' => $searchResponse];
                    return  $output_data;
                    return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));

                    dd($request);

                    break;
                case "3":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?,?', [$customerid, $SearchType, '', '', $FIRSTNAME]);
                    $firstname =  $clientsDetails[0]->FirstName;

                    if ($clientsDetails == 'Undefined') {
                        $searchResponse = ([
                            'status' => false,
                            'message' => 'User not found'
                        ]);
                    }
                    // return response()->json(["status" => true, "FirstName" => $firstname ]);
                    // return response()->json(["status" => true, "clientsDetails" => $clientsDetails]);

                    if (!$firstname) {
                        return back()->with('fail', 'First Name does not exsist');
                    } else {
                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    return view('admin-findusers');

                    break;
                case "4":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?,?', [$customerid, $SearchType, '', $SURNAME, $FIRSTNAME]);
                    $firstname =  $clientsDetails[0]->FirstName;
                    $lastname =  $clientsDetails[0]->Surname;
                    if ($clientsDetails == 'Undefined') {
                        $searchResponse = ([
                            'status' => false,
                            'message' => 'User not found'
                        ]);
                    }

                    if (!$firstname && !$lastname) {
                        return back()->with('fail', 'First Name and Last Name does not exsist');
                    } else {
                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    // return response()->json(["status" => true, "clientsDetails" => $clientsDetails]);

                    // app('debugbar')->info($request);

                    return view('admin-findusers');

                    break;
                case "5":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?,?,?', [$customerid, $SearchType, '', '', '',  $CONTACTNO]);
                    $cell =  $clientsDetails[0]->PhoneNumber;

                    app('debugbar')->info($clientsDetails);

                    if (!$cell) {
                        return back()->with('fail', 'Contact Number does not exsist');
                    } else {

                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    return view('admin-findusers');

                    break;
                case "6":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?,?,?,?', [$customerid, $SearchType, '', '', '', '', $FICASTATUS]);
                    $ficastatus =  $clientsDetails[0]->FICAStatus;

                    // $request->session()->put('TestResult', $clientsDetails);

                    if (!$ficastatus) {
                        return back()->with('fail', 'No FICA Statuses exsist');
                    } else {

                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    // $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                    // return  $output_data;

                    return view('admin-findusers');

                    break;
                case "7":

                    $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_ConsumerSearch ?,?,?,?,?,?,?,?', [$customerid, $SearchType, '', '', '', '', '', $CLIENTREF]);
                    $uniref =  $clientsDetails[0]->ClientUniqueRef;

                    if (!$uniref) {
                        return back()->with('fail', 'Client Reference does not exsist');
                    } else {

                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];
                        return  $output_data;

                        return view('admin-findusers', compact('output_data.data[i].IDNUMBER'));
                    }

                    break;
                default:
                    echo "";
            }
        } catch (\Exception $exception) {

            $exception = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($exception->getMessage(), true));
            // $exception = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($exception->getMessage(), true));

            $LogUserName = $request->session()->get('LogUserName');
            $LogUserSurname = $request->session()->get('LogUserSurname');

            $request->session()->put('exception', $exception);

            $Customerid = $request->session()->get('Customerid');
            $customer = Customer::where('Id', '=',  $Customerid)->first();
            $Logo = $customer['Client_Logo'];
            $customerName = $customer['RegistrationName'];
            $Icon = $customer['Client_Icon'];

            // app('debugbar')->info($exception);

            return view('admin-findusers')->with('exception', $exception)

                ->with('customerName', $customerName)
                ->with('Logo', $Logo)
                ->with('Icon', $Icon)
                ->with('LogUserName', $LogUserName)
                ->with('LogUserSurname', $LogUserSurname);

            // $message = $e->getMessage();
            // var_dump('Exception Message: '. $message);
            // // app('debugbar')->info($message);

            // $code = $e->getCode();       
            // var_dump('Exception Code: '. $code);
            // // app('debugbar')->info($code);

            // $string = $e->__toString();       
            // var_dump('Exception String: '. $string);
            // // app('debugbar')->info($string);

            // exit;

        }

        // dd($request->all());

    }

    // public function GetSurname(Request $request)
    // {

    //     $consumerid = "2D12F5FB-BE59-4A50-BD6A-3896720D8F89";
    //     $idnumber = "0000000000001";
    //     // $idnumber = $request->search2;

    //     $clientsDetails = DB::connection("sqlsrv2")->select('EXEC sp_IdentityDetails ?,?', [$consumerid, $idnumber]);

    //     $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>   $clientsDetails];

    //     return  $output_data;

    //     app('debugbar')->info($output_data);

    //     return view('admin-dashboard');

    // }

    public function ReadNotification(Request $request)
    {

        // $NotificationLink = $request->session()->get('NotificationLink');

        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];
            

        // $Consumerid = $request->session()->get('LoggedUser');
        // $EmailID = SendEmail::where('EmailID', '=', $findnote->EmailID)->first();

        // $getbyemailID = SendEmail::all();
        // $byemailID = SendEmail::where('EmailID', '=', $getbyemailID)->where('IsRead', '=', '1')->first();

        app('debugbar')->info($request);

        $EmailID = $request->emailid;

        app('debugbar')->info($EmailID);

        SendEmail::where('EmailID', '=', $EmailID)->update([

            'IsRead' => 0,

        ]);

        return redirect()->back()

        // ->with('NotificationLink', $NotificationLink)
        ->with('customerName', $customerName)
        ->with('Logo', $Logo)
        ->with('Icon', $Icon)
        ->with('LogUserName', $LogUserName)
        ->with('LogUserSurname', $LogUserSurname);
    }

    // public function ScreenUsersFirst()
    // {
    //     return view('admin-screening-first');
    // }

    // public function ScreenUsersSecond()
    // {
    //     return view('admin-screening-second');
    // }

    // public function ScreenUsersThird()
    // {
    //     return view('admin-screening-third');
    // }

    // public function ScreenUsersFourth()
    // {
    //     return view('admin-screening-fourth');
    // }

    // public function ScreenUsersFifth()
    // {
    //     return view('admin-screening-fifth');
    // }

    // public function ScreenUsersSixth()
    // {
    //     return view('admin-screening-sixth');
    // }

    // public function ScreenUsersSeventh()
    // {
    //     return view('admin-screening-seventh');
    // }

}
