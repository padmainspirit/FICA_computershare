<?php

namespace App\Http\Controllers;

use App\Models\AVS;
use App\Models\ConsumerIdentity;
use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\SbActions;
use App\Models\SelfBankingCompanySRN;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingExceptions;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SbAdminController extends Controller
{
    /* admin portal dashoboard counts */
    public function showsbdashboard(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        // $Consumerid = $request->session()->get('LoggedUser');
        //$Consumerid =$client -> Id;
        // $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        // $Logo = $customer['Client_Logo'];
        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        // $GetAllUsers = CustomerUser::all();
        $GetAllCustomers = Customer::all();

        $dashboard = DB::connection("sqlsrv2")->select('EXEC SelfServiceDashBoardStatuses');

        $DashboardInfo = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Dashboard :Customerid"),
            [
                ':Customerid' => $client->CustomerId
            ]
        );
       // print_r($client->CustomerId);exit;

        $DashboardData = $DashboardInfo[0] != '' ? $DashboardInfo[0] : null;

        $NumClients = $DashboardInfo != '' ? $DashboardInfo[0]->NumClients : null;

        $HighRisk = $DashboardInfo != '' ? $DashboardInfo[0]->HighRisk : null;
        $MediumRisk = $DashboardInfo != '' ? $DashboardInfo[0]->MediumRisk : null;
        $LowRisk = $DashboardInfo != '' ? $DashboardInfo[0]->LowRisk : null;

        $HighPerc = $NumClients != 0 ? (($HighRisk / $NumClients) * 100) : 0;
        $MediumPerc = $NumClients != 0 ? (($MediumRisk / $NumClients) * 100) : 0;
        $LowPerc = $NumClients != 0 ? (($LowRisk / $NumClients) * 100) : 0;

        app('debugbar')->info($GetAllCustomers);
        $getRoleName = CustomerUser::getCustomerUserRoleName();

        return view('users.sb-dashboard', [])

             ->with('customer', $customer)
             ->with('DashboardData', $DashboardData)
             ->with('LowPerc', $LowPerc)
             ->with('MediumPerc', $MediumPerc)
             ->with('HighPerc', $HighPerc)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('LogUserName', $client->FirstName)
            ->with('LogUserSurname', $client->LastName)
            ->with('dashboard', $dashboard)
            ->with('Logo', $customer->Client_Logo)
            ->with('getRoleName', $getRoleName);
    }


    public function showselfsb(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        // $Consumerid = $request->session()->get('LoggedUser');
        //$Consumerid =$client -> Id;
        // $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        // $Logo = $customer['Client_Logo'];
        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        // $GetAllUsers = CustomerUser::all();
        $GetAllCustomers = Customer::all();

        app('debugbar')->info($GetAllCustomers);

        return view('self-banking.self-sb', [])

             ->with('customer', $customer)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo)
            ->with('LogUserName', $client->FirstName)
            ->with('LogUserSurname', $client->LastName);
    }
    

    /* Search for self banking */
    public function searchsb(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $customerId = $client->CustomerId;

        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $idno = $request->IDNumber;
        $first = $request->FirstName;
        $last = $request->LastName;
        $cel = $request->phone;
        $status = $request->avsStatus;


        $results = DB::connection("sqlsrv2")->select('EXEC spSelfBankingSearch ?,?,?,?,?,?', [$idno, $first, $last, $cel, $status,$customerId]);

       // print_r($results);exit;
        if (request()->ajax()) {
            return view('self-banking.search-sb', ['results' => $results]);
        }
        $GetAllCustomers = Customer::all();

        app('debugbar')->info($GetAllCustomers);

        return view('self-banking.search-sb', ['results' => $results])
        ->with('customer', $customer)
        ->with('GetAllCustomers', $GetAllCustomers)
        ->with('UserFullName', $UserFullName)
        ->with('customerName', $customer->RegistrationName)
        ->with('Icon', $customer->Client_Icon)
        ->with('Logo', $customer->Client_Logo);
    }


    /* get results of aa self banking details*/
    public function sbresults(Request $request,$id)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);

        $message ='';
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $reason = $request->reason;
        $status = $request->avsStatus;

        $getCustomerId = $id;
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingDetailsId', '=',  $getCustomerId)->first();
        $selfbankinglink = SelfBankingLink::where('Id', '=',  $selfbankingdetails->SelfBankingLinkId)->first();

       //print_r($selfbankingdetails);exit;
        $sbdetails = SelfBankingDetails::where(['SelfBankingDetailsId' => $getCustomerId])
        ->join('TBL_FICA', 'TBL_FICA.Consumerid', '=', 'TBL_Consumer_SelfBankingDetails.SelfBankingDetailsId')
        ->first();

         $exceptions = SelfBankingExceptions::where('SelfBankingLinkId', '=', $selfbankingdetails->SelfBankingLinkId)->get();

         $avs = AVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $dovs = DOVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $consumerIdentity  = ConsumerIdentity::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $fica =  FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->first();
         $SbActions =  SbActions::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();
         $SelfBankingCompanySRN =  SelfBankingCompanySRN::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();



        // print_r($SelfBankingCompanySRN);exit;
         $cell1 = $consumerIdentity->CELL_1_PHONE_NUMBER;
         $cell2 = $consumerIdentity->CELL_2_PHONE_NUMBER;
         $cell3 = $consumerIdentity->CELL_3_PHONE_NUMBER;
         $cell4 = $consumerIdentity->CELL_4_PHONE_NUMBER;
         $cell5 = $consumerIdentity->CELL_5_PHONE_NUMBER;
         $cellmatch = "Unmatched";
         $emailmatch = 'Unmatched';
         $namematch = 'Unmatched';
         $smatch = 'Unmatched';
         $secnamematch = 'Unmatched';
         $thirdnamematch = 'Unmatched';
         if($selfbankingdetails->PhoneNumber ==$cell1 || $selfbankingdetails->PhoneNumber ==$cell2 ||
         $selfbankingdetails->PhoneNumber ==$cell3 || $selfbankingdetails->PhoneNumber ==$cell4|| $selfbankingdetails->PhoneNumber ==$cell5)
         {
            $cellmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->Email) == strtolower($consumerIdentity->X_EMAIL) )
         {
            $emailmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->FirstName) == strtolower($consumerIdentity->FIRSTNAME) )
         {
            $namematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->SecondName) == strtolower($consumerIdentity->SECONDNAME) )
         {
            $secnamematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->ThirdName) == strtolower($consumerIdentity->OTHER_NAMES) )
         {
            $thirdnamematch = 'Matched';
         }


         if(strtolower($selfbankingdetails->Surname) == strtolower($consumerIdentity->SURNAME) )
         {
            $smatch = 'Matched';
         }
        //print_r($sbdetails);exit;
         if(!empty($_POST))
         {
            FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAStatus' =>  $status,
                )
            );


                SbActions::create([
                    'ActionId' => Str::upper(Str::uuid()),
                    'AdminID' => $client->Id,
                    'SelfBankingdetailsId' =>  $selfbankingdetails->SelfBankingDetailsId,
                    'CreatedAt' => date("Y-m-d H:i:s"),
                    'ActionFrom' => $fica->FICAStatus,
                    'ActionTo' => $status,
                    'Comment' => $reason,
                    'Admin_User' => $UserFullName
                ]);

            $message = 'Flow status has been succesfully updated';

         }
        if (request()->ajax()) {
            return view('self-banking.sb-results', ['selfbankingdetails' => $selfbankingdetails]);
        }

        return view('self-banking.sb-results', ['selfbankingdetails' => $selfbankingdetails])
        ->with('customer', $customer)
        ->with('avs', $avs)
        ->with('dovs', $dovs)
        ->with('UserFullName', $UserFullName)
        ->with('customerName', $customer->RegistrationName)
        ->with('sbdetails', $sbdetails)
        ->with('Icon', $customer->Client_Icon)
        ->with('message', $message)
        ->with('SelfBankingCompanySRN', $SelfBankingCompanySRN)
        ->with('exceptions', $exceptions)
        ->with('Logo', $customer->Client_Logo)
        ->with('LogUserName', $client->FirstName)
        ->with('cellmatch', $cellmatch)
        ->with('emailmatch', $emailmatch)
        ->with('thirdnamematch', $thirdnamematch)
        ->with('secnamematch', $secnamematch)
        ->with('FICAStatus', $fica->FICAStatus)
        ->with('namematch', $namematch)
        ->with('SbActions', $SbActions)
        ->with('smatch', $smatch)
        ->with('ha_name', $consumerIdentity->FIRSTNAME)
        ->with('ha_secondname', $consumerIdentity->SECONDNAME)
        ->with('ha_surname', $consumerIdentity->SURNAME)
        ->with('selfbankinglink', $selfbankinglink)
        ->with('iddoc', $consumerIdentity->Identity_File_Path)
        ->with('LogUserSurname', $client->LastName);

    }


    /* send mail from admin from a self banking details */
    public function SendEmail(Request $request,$id)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);

        $message ='';
        $messageemail ='';
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $Subject = $request->Subject;
        $messagetyped = $request->EmailMessage;


        $getCustomerId = $id;
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingDetailsId', '=',  $getCustomerId)->first();
        $selfbankinglink = SelfBankingLink::where('Id', '=',  $selfbankingdetails->SelfBankingLinkId)->first();

       //print_r($selfbankingdetails);exit;
        $sbdetails = SelfBankingDetails::where(['SelfBankingDetailsId' => $getCustomerId])
        ->join('TBL_FICA', 'TBL_FICA.Consumerid', '=', 'TBL_Consumer_SelfBankingDetails.SelfBankingDetailsId')
        ->first();

         $exceptions = SelfBankingExceptions::where('SelfBankingLinkId', '=', $selfbankingdetails->SelfBankingLinkId)->get();

         $avs = AVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $dovs = DOVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $consumerIdentity  = ConsumerIdentity::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $fica =  FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->first();
         $SbActions =  SbActions::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();
         $SelfBankingCompanySRN =  SelfBankingCompanySRN::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();


         //print_r($avs);exit;
         $cell1 = $consumerIdentity->CELL_1_PHONE_NUMBER;
         $cell2 = $consumerIdentity->CELL_2_PHONE_NUMBER;
         $cell3 = $consumerIdentity->CELL_3_PHONE_NUMBER;
         $cell4 = $consumerIdentity->CELL_4_PHONE_NUMBER;
         $cell5 = $consumerIdentity->CELL_5_PHONE_NUMBER;
         $cellmatch = "Unmatched";
         $emailmatch = 'Unmatched';
         $namematch = 'Unmatched';
         $smatch = 'Unmatched';
         $secnamematch = 'Unmatched';
         $thirdnamematch = 'Unmatched';
         if($selfbankingdetails->PhoneNumber ==$cell1 || $selfbankingdetails->PhoneNumber ==$cell2 ||
         $selfbankingdetails->PhoneNumber ==$cell3 || $selfbankingdetails->PhoneNumber ==$cell4|| $selfbankingdetails->PhoneNumber ==$cell5)
         {
            $cellmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->Email) == strtolower($consumerIdentity->X_EMAIL) )
         {
            $emailmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->FirstName) == strtolower($consumerIdentity->FIRSTNAME) )
         {
            $namematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->SecondName) == strtolower($consumerIdentity->SECONDNAME) )
         {
            $secnamematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->ThirdName) == strtolower($consumerIdentity->OTHER_NAMES) )
         {
            $thirdnamematch = 'Matched';
         }


         if(strtolower($selfbankingdetails->Surname) == strtolower($consumerIdentity->SURNAME) )
         {
            $smatch = 'Matched';
         }
        $ClientFullName = $selfbankingdetails->FirstName . ' ' . $selfbankingdetails->Surname;

        $email = $selfbankingdetails->Email;

        $YearNow = Carbon::now()->year;
        $TradingName = $customer->TradingName;

        Mail::send(
            'self-banking.emailclient',
            ['Logo' => $customer->Client_Logo, 'TradingName' => $customer->RegistrationName, 'YearNow' => $YearNow,'FirstName'=>$selfbankingdetails->FirstName, 'Surname'=>$selfbankingdetails->Surname, 'ClientFullName'=>$ClientFullName, 'messagetyped'=>$messagetyped],
            function ($messageemail) use ($request, $email,$Subject) {

                $messageemail->from(config('app.cssb_adminemail'));
                $messageemail->to($email);
                $messageemail->subject($Subject);
            }

        );
        $message = 'Email has been sent succesfully';
        return view('self-banking.sb-results', ['selfbankingdetails' => $selfbankingdetails])
        ->with('customer', $customer)
        ->with('avs', $avs)
        ->with('dovs', $dovs)
        ->with('sbdetails', $sbdetails)
        ->with('UserFullName', $UserFullName)
        ->with('customerName', $customer->RegistrationName)
        ->with('Icon', $customer->Client_Icon)
        ->with('message', $message)
        ->with('exceptions', $exceptions)
        ->with('Logo', $customer->Client_Logo)
        ->with('LogUserName', $client->FirstName)
        ->with('cellmatch', $cellmatch)
        ->with('emailmatch', $emailmatch)
        ->with('thirdnamematch', $thirdnamematch)
        ->with('secnamematch', $secnamematch)
        ->with('FICAStatus', $fica->FICAStatus)
        ->with('namematch', $namematch)
        ->with('SelfBankingCompanySRN', $SelfBankingCompanySRN)
        ->with('SbActions', $SbActions)
        ->with('smatch', $smatch)
        ->with('ha_name', $consumerIdentity->FIRSTNAME)
        ->with('ha_secondname', $consumerIdentity->SECONDNAME)
        ->with('ha_surname', $consumerIdentity->SURNAME)
        ->with('selfbankinglink', $selfbankinglink)
        ->with('iddoc', $consumerIdentity->Identity_File_Path)
        ->with('LogUserSurname', $client->LastName);

    }


}
