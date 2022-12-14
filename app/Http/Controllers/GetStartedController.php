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

        // dd($Consumerid);

        // $SearchCustomerId = CustomerUser::where('Id', '=', $Consumerid)->first();

        $Customerid = Auth::user()->CustomerId;

        // dd($Customerid);
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

    public function getStarted(Request $request)
    {
        //try {
        //create Consumer  
        $user = Auth::user();
        $customerUserId =  $user->Id;
        $client = CustomerUser::where('Id', '=',  $customerUserId)->first();
        app('debugbar')->error($client);
        $consumerId = Str::upper(Str::uuid());
        $ficaId = Str::upper(Str::uuid());
        // $bankId =  Str::upper(Str::uuid());
        // $dovs =  Str::upper(Str::uuid());
        // $complianceId = Str::upper(Str::uuid());
        $consumerFinancial =  Str::upper(Str::uuid());
        // $riskConsumerId = Str::upper(Str::uuid());
        // $kycId = Str::upper(Str::uuid());
        // $identityId = Str::upper(Str::uuid());
        $DeclarationId = Str::upper(Str::uuid());


        // $request->session()->put('ficaId', $ficaId);
        // $request->session()->put('consumerId', $consumerId);


        $Customerid = Auth::user()->CustomerId;
        // $customer = Customer::getCustomerDetails($Customerid);
        // $Icon = $customer->Client_Icon;
        // $Logo = $customer->Client_Logo;
        // $RegistrationName = $customer->RegistrationName;


        // $NotificationLink = $request->session()->get('NotificationLink');

        // app('debugbar')->info($NotificationLink);

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

        // //CONSUMER IDENTITY
        // $consumerIdentity = ConsumerIdentity::create([
        //     'Identity_ID' => $identityId,
        //     'FICA_id' =>  $ficaId,
        //     'Identity_Document_ID' => $client->IDNumber,
        // ]);

        // //KYC
        // $kyc = KYC::create([
        //     'KYC_id' => $kycId,
        //     'FICA_id' => $ficaId,
        // ]);

        // //AVS
        // $avs = AVS::create([
        //     'Bank_id' => $bankId,
        //     'FICA_id' => $ficaId,
        // ]);

        // //DOVS
        // $dovs = DOVS::create([
        //     'DOVS_id' => $dovs,
        //     'FICA_id' => $ficaId,
        // ]);

        // //COMPLIANCE
        // $compliance = Compliance::create([
        //     'Compliance_id' => $complianceId,
        //     'FICA_id' => $ficaId,
        // ]);

        // //ADDRESS
        // $address = Address::create([
        //     'ConsumerID' => $consumerId,
        // ]);

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

        //TELEPHONES
        // $cellphoneNumber = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 12)->get();

        $cellNumber =  $client->PhoneNumber;
        //Adding New Cell Number 
        $telLength = strlen($cellNumber);
        //Check the length of the Cell number
        if ($telLength == 10) {
            // if (Count($cellphoneNumber) > 0) {
            //     foreach ($cellphoneNumber as $number) {
            //         //dd($number);
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

        // $riskAnswer = RiskAnswer::create([
        //     'Risk_CONSUMER_id' =>  $riskConsumerId,
        //     'Fica_id' => $ficaId,
        //     'question_id' => NULL,
        //     'Question_Name' => NULL,
        //     'RiskLevel_id' => NULL,
        //     'ConsumerRisk_Score' => NULL,
        //     'CreatedOnDate' => NULL,
        //     'LastUpdatedDate' => NULL
        // ]);

        $consumer->save();
        $fica->save();
        // $avs->save();
        // $dovs->save();
        // $address->save();
        // $compliance->save();
        // $telephones->save();
        $financial->save();
        // $kyc->save();
        // $consumerIdentity->save();
        $declaration->save();

        //$riskAnswer->save();


        return redirect('fica');
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }
        // return view('start-fica-process', ['article' =>
        // 'Passing Data to View']);
    }
}
