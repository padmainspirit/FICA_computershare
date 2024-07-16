<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\CustomerUser;
use App\Models\FICA;
use App\Models\AVS;
use App\Models\DOVS;
use App\Models\Address;
use App\Models\Compliance;
use App\Models\Telephones;
use App\Models\Financial;
use App\Models\RiskAnswer;
use App\Models\KYC;
use App\Models\ConsumerIdentity;
use App\Models\Declaration;
use App\Models\APILogs;
use App\Models\SendEmail;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class GetStartedController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
        $this->middleware('auth');
        $this->middleware('permission:customeruser-fica', ['only' => ['startFica', 'getStarted']]);
    }

    public function startFica(Request $request)
    {
        // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        // $LoggedInConsumerId = $consumer['Consumerid'];
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $LoggedInConsumerId)->where('IsRead', '=', '1')->get();

        if (session()->has('ForgetEmail')) {
            session()->pull('ForgetEmail');
        }

        // $Consumerid = Auth::user()->Id;


        // $SearchCustomerId = CustomerUser::where('Id', '=', $Consumerid)->first();
        $Customerid = Auth::user()->CustomerId;

        $customer = Customer::getCustomerDetails($Customerid);
        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer['Client_Icon'];



        //print_r($Customerid);exit;
        /* $Logo = $customerBrand['Client_Logo'];
        $Icon = $customerBrand['Client_Icon'];
        $customerName = $customerBrand['RegistrationName']; */

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // $Logo =  session()->get('Logo');
        // $customerName =  session()->get('customerName');

        // app('debugbar')->info($Logo);

        return view('start-fica-process')
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo)
            ->with('RegistrationName', $customer->RegistrationName)
            ->with('Icon', $customer['Client_Icon'])
            ->with('LogUserName', Auth::user()->FirstName)
            ->with('LogUserSurname', Auth::user()->LastName);
    }

    public function getStarted()
    {
        //try {
        //create Consumer  
        $user = Auth::user();
        
        $customerUserId = Auth::user()->Id;
        $client = CustomerUser::where('Id', '=',  $customerUserId)->first();
        app('debugbar')->error($client);

        $consumerId = Str::upper(Str::uuid());
        $ficaId = Str::upper(Str::uuid());
        $consumerFinancial =  Str::upper(Str::uuid());
        $DeclarationId = Str::upper(Str::uuid());

        $Customerid = Auth::user()->CustomerId;
        $CheckIfStartedExsist = Consumer::where('CustomerUSERID', '=',  $customerUserId)->first() != null ? Consumer::where('CustomerUSERID', '=',  $customerUserId)->first() : null;

        if ($CheckIfStartedExsist == null) {
            //Consumer
            $consumer = Consumer::create([
                'Consumerid' => $consumerId,
                'CustomerUSERID' => $customerUserId,
                'IDNUMBER' => $client->IDNumber,
                'FirstName' => $client->FirstName,
                'Surname' => $client->LastName,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'Email' => $client->Email,
                'Customerid' => $Customerid,
                'PhoneNumber' => $user->PhoneNumber,
            ]);

            //FICA
            $fica = FICA::create([
                'FICA_id' => $ficaId,
                'Consumerid' => $consumerId,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAStatus' => 'In progress',
                'FICA_Active' => 1,
            ]);

            //FINANCIAL
            $financial = Financial::create([
                'ConsumerFinancial' => $consumerFinancial,
                'FICA_id' => $ficaId,
            ]);

            // DECLARATION
            $declaration = Declaration::create([
                'Declaration_ID' => $DeclarationId,
                'FICA_ID' => $ficaId,
                'ConsumerID' => $consumerId,
            ]);

            $cellNumber =  $client->PhoneNumber;
            //Adding New Cell Number 
            $telLength = strlen($cellNumber);
            //Check the length of the Cell number
            if ($telLength == 10) {
                // if (Count($cellphoneNumber) > 0) {
                //     foreach ($cellphoneNumber as $number) {
                //         Telephones::where("ConsumerID", $consumer->Consumerid)->where("TelephoneTypeInd", 12)->update(['RecordStatusInd' => 0]);
                //     }
                // }
                app('debugbar')->info($telLength);
                // if ($telLength == 10) {
                $extension = substr($cellNumber, 0, 3);
                $telno = substr($cellNumber, 3, 10);
                Telephones::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'TelephoneTypeInd' => 12, //use lookup table
                    'InternationalDialingCode',
                    'TelephoneCode' => $extension,
                    'TelephoneNo' =>  $telno,
                    'RecordStatusInd' => 1,
                    'CreatedonDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }

            $consumer->save();
            $fica->save();
            $financial->save();
            $declaration->save();

            return redirect('fica');
        }else{
            return redirect('fica');
        }
    }


}
