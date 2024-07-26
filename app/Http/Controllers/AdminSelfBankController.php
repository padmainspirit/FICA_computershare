<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SmsOtpController;
use App\Models\Company;
use App\Models\Customer;
use App\Models\FICA;
use App\Models\SelfBankingCompanySRN;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingExceptions;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminSelfBankController extends Controller
{
    /* Function to generate link for self banking and send it via Email/SMS */
    public function SendLink(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::getCustomerDetails($user->CustomerId);
        $Year = Carbon::now()->year;
        if(!empty($_POST)){
            $this->validate($request, [
                'Media' => ['required', 'string'],
                'PhoneNumber' => ['nullable','digits:10', 'required_if:Media,SMS'],
                'Email' => ['nullable','Email', 'required_if:Media,Email'],
            ]);

            $selfbankingId = Str::upper(Str::uuid());
            if($_POST['Media'] == 'Email' || $_POST['Media'] == 'SMS')
            {
                $linkGenerated = URL::temporarySignedRoute(
                    'selfbanking', now()->addHours(2), ['sbid'=>$selfbankingId]
                );
            }else{
                return false;
            }

            $request['Id'] = $selfbankingId;
            $request['CustomerUserId'] = $user->Id;
            $request['CustomerId'] = $user->CustomerId;
            $request['LinkGenerated'] = $linkGenerated;
            SelfBankingLink::create($request->all());



            if($_POST['Media'] == 'Email'){
                Mail::send(
                    'email.email-selfbankinglink',
                    ['Logo' => $customer->Client_Logo, 'TradingName' => $customer->RegistrationName, 'YearNow' => $Year, 'linkGenerated'=>$linkGenerated],
                    function ($message) use ($request) {
                        $message->to($_POST['Email']);
                        $message->subject('Self Service Banking Link');
                    }
                );
            }else if($_POST['Media'] == 'SMS'){
                $sms = new SmsOtpController();
                $smsresult = $sms->sendselfServicelink($_POST['PhoneNumber'], $linkGenerated);
                print_r($smsresult);exit;
            }else{
                return false;
            }
        }
        return view('self-banking.send-link')
            ->with('customer', $customer)
            ->with('UserFullName', $user->FirstName.' '.$user->Surname);
    }

    public function genearateLink(Request $request)
    {
        $selfbankingId = Str::upper(Str::uuid());
        $linkGenerated = URL::temporarySignedRoute(
            'selfbanking', now()->addHours(config("app.SelfBankingLink_ExpiryTime")), ['sbid'=>$selfbankingId]
        );
        $request['Id'] = $selfbankingId;
        $request['CustomerId'] = config("app.CUSTOMER_DEFAULT_ID");
        $request['LinkGenerated'] = $linkGenerated;
        try {
            SelfBankingLink::create($request->all());
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->away($linkGenerated);
    }


    /* Self banking flow link  */
    public function selfBanking(Request $request)
    {        
        $sbid = $request->sbid;
        $selfbanking = SelfBankingLink::find($sbid);
        /* $selfbanking = SelfBankingLink::with(['actionStatusType'=>function ($query) {
            $query->select('ActionTypeid', 'Action_description');
        }])->where('Consumerid',$consumerId)->orderBy('ActionDate', 'desc')->get();  */
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);

        if (! $request->hasValidSignature()) {
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }else{
            //$request->session()->invalidate();
            $request->session()->put('sbid', $sbid);
            if($selfbanking->tnc_flag == 1){

                $routename = SelfBankingLink::checkStep($sbid);
                return redirect()->route($routename);
            }
            SelfBankingLink::where(['Id'=>$sbid])->update(['IsClicked'=>1]);
            return view('self-banking.index')
            ->with('customer', $customer)
            ->with('sbid', $sbid);
        }

    }


    /* Self banking flow link  */
    public function selfBankingStart(Request $request)
    {
        $sbid = $request->session()->get('sbid');
        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if(Route::currentRouteName() != $routename){
                return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $companies = Company::all('Company_Name')->sortBy('Company_Name');
        if(!empty($_POST)){

            $this->validate($request, [
                'sb-tnc' => ['required'],
            ],
            [
                'sb-tnc.required' => 'You have to agree to the terms and conditions of banking service to continue the flow',
            ]);

            SelfBankingLink::where(['Id'=>$sbid])->update(['tnc_flag'=>1]);
            
            return redirect()->route('agree-selfbanking-tnc');
        }
        return view('self-banking.sb_personalinfo')
            ->with('customer', $customer)
            ->with('companies', $companies)
            ->with('sbid', $sbid);

    }


     /* Self banking flow link  */
     public function sbPersonalInfo(Request $request)
     {       

        $sbid = $request->session()->get('sbid');
        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if(Route::currentRouteName() != $routename){
                return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $companies = Company::all('Company_Name')->sortBy('Company_Name');
        if(!empty($_POST)){

            //$this->validate($request, [
            $validator = Validator::make($request->all(), [
                'IDNUMBER' => ['required','digits:13'],
                'FirstName' => ['required', 'string', 'min:2', 'max:50'],
                'Surname' => ['required', 'string', 'min:2', 'max:50'],
                'PhoneNumber' => ['required', 'digits:10', 'max:50'],
                'Email' => ['required', 'string', 'email', 'max:50'],
                'reflist.*.refnum' => ['required', 'string', 'regex:/^[c|u|d|C|U|D]{1}[0-9]{10}$/',],
                //'reflist.*.company' => ['required_if:reflist.*.refnum,C1234567890']
            ],[
                'IDNUMBER.required'=>'ID Number should be of 13 digits',
                'reflist.*.refnum.required' => 'The SRN Number is required at row number :position of Account details',
                'reflist.*.refnum.regex' => 'Please provide a valid SRN Number :position row of Account details',
                //'reflist.*.company.required' => 'The company selection is required at :position row of Account details',
            ]);

            $validator->after(function ($validator) {
                foreach ($validator->getData()['reflist'] as $key => $value) {print_r($value['company']);
                    $position = $key+1;
                    if((preg_match('/[C|c]{1}[0-9]{10}/', $value['refnum'])) && $value['company'] == null && $value['company'] == '' ){
                        $validator->errors()->add('reflist.'.$key.'.company', 'The company selection is required at row number '.$position.' of Account details');
                    }
                }
                
            })->validate();

            /* code for validating ID number using idas API */
            $verifyData = new VerifyUserController();
            $apiresult = $verifyData->verifyUser($request->IDNUMBER, $request);
            print_r($apiresult);//exit;

            if($apiresult[0] != $request->IDNUMBER)
            {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Invalid ID number has been entered');
            }
            if(strtoupper($apiresult[4]) != strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname))
            {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Firstname and surname does not match with the IDnumber');
            }
            if($apiresult[24] != ''|| $apiresult[24] != null)
            {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Idnumber of deseased persona has been entered');
            }


            $selfbankingdetailsid = Str::upper(Str::uuid());
            $request['SelfBankingDetailsId'] = $selfbankingdetailsid;
            $request['Customerid'] = $selfbanking->CustomerId;
            $request['SelfBankingLinkId'] = $sbid;
            SelfBankingDetails::create($request->all());


            /* Matches First name only */
            if(strtoupper($apiresult[4]) == strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname) && strtoupper($apiresult[6]) != strtoupper($request->SecondName))
            {
                $sbe = SelfBankingExceptions::create([
                    'Id' => Str::upper(Str::uuid()),
                    'SelfBankingLinkId'=>$selfbankingdetailsid,
                    'API'=>1,
                    'Status'=> 'Validation Pending',
                    'Comment' => 'Pending Surname'
                ]);
                $sbe->save();
            }

            /* Matches First name and Second name only */
            if(strtoupper($apiresult[4]) == strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname) && strtoupper($apiresult[6]) == strtoupper($request->SecondName))
            {
                $sbe = SelfBankingExceptions::create([
                    'Id' => Str::upper(Str::uuid()),
                    'SelfBankingLinkId'=>$selfbankingdetailsid,
                    'API'=>1,
                    'Status'=> 'Validation Pending',
                    'Comment' => 'Pending Surname'
                ]);
                $sbe->save();
            }

            
            
            $selfbankingdetailsid = Str::upper(Str::uuid());
            $request['SelfBankingDetailsId'] = $selfbankingdetailsid;
            $request['Customerid'] = $selfbanking->CustomerId;
            $request['SelfBankingLinkId'] = $sbid;
            SelfBankingDetails::create($request->all());


            $fica_id = Str::upper(Str::uuid());
            $sbfica = FICA::create([
                'FICA_id' =>  $fica_id,
                'Consumerid' => $selfbankingdetailsid,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAStatus' => 'In progress',
                'FICA_Active' => 1,
                'ConsumerReferance'=>4,
            ]);
            $sbfica->save();

            $clientdata = new VerificationDataController();
            $clientdata->verifyClientData($request->IDNUMBER, $request, $fica_id);
            
            SelfBankingLink::where(['Id'=>$sbid])->update(['PersonalDetails'=>1]);

            foreach ($request['reflist'] as $srndet) {
                $compnanysrn = new SelfBankingCompanySRN;
                $compnanysrn->ID = Str::upper(Str::uuid());                
                $compnanysrn->SelfBankingDetailsId = $selfbankingdetailsid;
                $compnanysrn->SRN = $srndet['refnum'];
                $compnanysrn->companies = $srndet['company'];
                $compnanysrn->save();
            }

            return redirect()->route('digi-verify');
        }
        return view('self-banking.sb_personalinfo')
        ->with('customer', $customer)
        ->with('companies', $companies)
        ->with('sbid', $sbid);
     }


     /* Digital verification of self service banking */
     public function DigiVerification(Request $request) {
        $sbid = $request->session()->get('sbid');

        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        return view('self-banking.digi_verify')
            ->with('customer', $customer);
     }

     /* Self banking flow link  */
     public function sbEmailorPhone(Request $request)
     {
        $sbid = $request->session()->get('sbid');

        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);

            $request['SelfBankingDetailsId'] = Str::upper(Str::uuid());
            $request['Customerid'] = $selfbanking->CustomerId;
            $request['SelfBankingLinkId'] = $sbid;


            return view('self-banking.idvlink')
            ->with('customer', $customer);
     }

}


