<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SmsOtpController;
use App\Models\Customer;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
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
            'selfbanking', now()->addHours(2), ['sbid'=>$selfbankingId]
        );
        $request['Id'] = $selfbankingId;
        $request['CustomerId'] = config("app.CUSTOMER_DEFAULT_ID");
        $request['LinkGenerated'] = $linkGenerated;
        SelfBankingLink::create($request->all());
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
                
                return view('self-banking.sb_personalinfo')
                ->with('customer', $customer)
                ->with('sbid', $sbid);
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
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($sbid);
        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }else if(!empty($_POST)){ 
            
            $this->validate($request, [
                'sb-tnc' => ['required'],
            ],
            [
                'sb-tnc.required' => 'You have to agree to the terms and conditions of banking service to continue the flow',
            ]);

            SelfBankingLink::where(['Id'=>$sbid])->update(['tnc_flag'=>1]);
            return view('self-banking.sb_personalinfo')
            ->with('customer', $customer);
        }
        return view('self-banking.sb_personalinfo')
            ->with('customer', $customer)
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
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        if(!empty($_POST)){           

            $this->validate($request, [
                'IDNUMBER' => ['required','digits:13'],
                'FirstName' => ['required', 'string', 'min:2', 'max:50'],
                'Surname' => ['required', 'string', 'min:2', 'max:50'],
                'PhoneNumber' => ['required', 'digits:10', 'max:50'],
                'Email' => ['required', 'string', 'email', 'max:50'],
            ],[
                'IDNUMBER.digits' => 'ID Number must be of 13 digits',
            ]);

            $request['SelfBankingDetailsId'] = Str::upper(Str::uuid());
            $request['Customerid'] = $selfbanking->CustomerId;
            $request['SelfBankingLinkId'] = $sbid;
            SelfBankingDetails::create($request->all());

            return view('self-banking.digi_verify')
            ->with('customer', $customer);
        }
            return view('self-banking.digi_verify')
            ->with('customer', $customer);
     }

}
