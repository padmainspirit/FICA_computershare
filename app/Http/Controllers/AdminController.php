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
        $this->middleware('auth');
        $this->middleware('permission:admin-dashboard', ['only' => ['ShowDashboard']]);
        $this->middleware('permission:admin-seach-user', ['only' => ['FindUsers']]);
    }

    public function ShowDashboard(Request $request)
    {

        $request->session()->put('idnumber', null);
        $user = Auth::user();

        // $LogUserName = $user->FirstName;
        // $LogUserSurname = $user->LastName;

        $Customerid = $user->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;


        $DashboardInfo = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Dashboard :Customerid"),
            [
                ':Customerid' => $Customerid
            ]
        );

        $DashboardData = $DashboardInfo[0] != '' ? $DashboardInfo[0] : null;

        $NumClients = $DashboardInfo != '' ? $DashboardInfo[0]->NumClients : null;

        $HighRisk = $DashboardInfo != '' ? $DashboardInfo[0]->HighRisk : null;
        $MediumRisk = $DashboardInfo != '' ? $DashboardInfo[0]->MediumRisk : null;
        $LowRisk = $DashboardInfo != '' ? $DashboardInfo[0]->LowRisk : null;

        $HighPerc = $NumClients != 0 ? (($HighRisk / $NumClients) * 100) : 0;
        $MediumPerc = $NumClients != 0 ? (($MediumRisk / $NumClients) * 100) : 0;
        $LowPerc = $NumClients != 0 ? (($LowRisk / $NumClients) * 100) : 0;



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

            ->with('Logo',  $customer->Client_Logo)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)

            ->with('LogUserName', $user->FirstName)
            ->with('LogUserSurname', $user->LastName);
    }

    public function FindUsers(Request $request)
    {
        $client = Auth::user();
        // $loggedInUserId = $client->Id;
        $LogUserName = $client->FirstName;
        $LogUserSurname = $client->LastName;
        $Customerid = $client->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        // dd($client);

        $Logo = $customer->Client_Logo;
        $customerName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;


        return view('admin-findusers')
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)
            ->with('Logo', $Logo)
            ->with('customer', $customer);
        // ->with('NotificationLink', $NotificationLink)
    }

    public function Display(Request $request)
    {
        $request->session()->pull('exception');

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

        $client = Auth::user();
        $customerid = $client->CustomerId;
        // $customerid = "4717E73D-1F3F-4ACE-BE1A-0244770D6272";
        $IDNUMBER = $request->IDNumber;
        $SURNAME = $request->LastName;
        $FIRSTNAME = $request->FirstName;
        $CONTACTNO = $request->PhoneNumber;
        $FICASTATUS = $request->FICAStatus;
        $CLIENTREF = $request->ClientUniqueRef;
        $searchResponse = (['status' => false, 'message' => '']);


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
            //  app('debugbar')->info($message);

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
}
