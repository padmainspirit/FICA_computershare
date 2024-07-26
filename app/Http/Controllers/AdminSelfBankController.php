<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SmsOtpController;
use App\Models\APILogs;
use App\Models\Company;
use App\Models\Customer;
use App\Http\Controllers\UserVerificationController;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\LookupDatas;
use App\Models\SelfBankingCompanySRN;
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
    protected $xdsusername;
    protected $xdspassword;

    protected $homeAddressIDType;
    protected $PostalAddressIDType;
    protected $WorkAddressIDType;
    protected $IDAS_ID;

    protected $DOVS; //DOVS
    protected $FACE; //DOVS

    public function __construct()
    {
        //$this->middleware('permission:compliance-lite', ['only' => ['index']]);
        $this->homeAddressIDType = config("app.HOME_LOOKUP_TABLE_ID"); //HOME:16
        $this->PostalAddressIDType = config("app.POSTAL_LOOKUP_TABLE_ID"); //POSTAL:15
        $this->WorkAddressIDType = config("app.WORK_LOOKUP_TABLE_ID"); //WORK:14
        $this->IDAS_ID = config("app.IDAS_ID"); //IDAS_ID
        $this->middleware('auth');

        $this->xdsusername = config("app.API_LOGIN_USERNAME");
        $this->xdspassword = config("app.API_LOGIN_PASSWORD");

        $this->DOVS = config("app.API_ID_DOVS");
        $this->FACE = config("app.API_ID_FACE");
        // $this->Key = config("app.AWS_ACCESS_KEY_ID");
        // $this->Secret = config("app.AWS_SECRET_ACCESS_KEY");
        // $this->Region = config("app.AWS_DEFAULT_REGION");

        date_default_timezone_set('Africa/Johannesburg');
    }
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

               /*  return view('self-banking.sb_personalinfo')
                ->with('customer', $customer)
                ->with('sbid', $sbid); */
                return redirect()->route('agree-selfbanking-tnc');
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
            /* return view('self-banking.sb_personalinfo')
            ->with('companies', $companies)
            ->with('customer', $customer); */
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
        $FICAid = Str::upper(Str::uuid());
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
                'reflist.*.refnum' => ['required', 'string', 'regex:/^[c|u|d|C|U|D]{1}[0-9]{10}$/',],
                'reflist.*.company' => ['required', 'string']
            ],[
                'IDNUMBER.required'=>'ID Number should be of 13 digits',
                'reflist.*.refnum.required' => 'The SRN Number is required at :position row of Account details',
                'reflist.*.refnum.regex' => 'Please provide a valid SRN Number :position row of Account details',
                'reflist.*.company.required' => 'The company selection is required at :position row of Account details',
            ]);

            $selfbankingdetailsid = Str::upper(Str::uuid());
            $request['SelfBankingDetailsId'] = $selfbankingdetailsid;
            $request['Customerid'] = $selfbanking->CustomerId;
            $request['SelfBankingLinkId'] = $sbid;
            SelfBankingDetails::create($request->all());

            foreach ($request['reflist'] as $srndet) {
                $compnanysrn = new SelfBankingCompanySRN;
                $compnanysrn->ID = Str::upper(Str::uuid());
                $compnanysrn->SelfBankingDetailsId = $selfbankingdetailsid;
                $compnanysrn->SRN = $srndet['refnum'];
                $compnanysrn->companies = $srndet['company'];
                $compnanysrn->save();
            }

            $sbfica = FICA::create([
                'FICA_id' =>  $FICAid,
                'Consumerid' => $selfbankingdetailsid,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAStatus' => 'In progress',
                'FICA_Active' => 1,
                'ConsumerReferance'=>4,
            ]);
            $sbfica->save();

            $sbDovs = DOVS::create([
                'DOVS_id' =>  Str::upper(Str::uuid()),
                'FICA_id' => $FICAid,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'SelfieStatus' => 'Pending',

            ]);
            $sbDovs->save();


            /* return view('self-banking.digi_verify')
            ->with('customer', $customer); */
           // return redirect()->route('digi-verify');
        }
            return view('self-banking.digi_verify')
            ->with('customer', $customer);
     }


     public function uploadid(Request $request) {
        $sbid = $request->session()->get('sbid');

        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        return view('self-banking.upload_iddoc')
            ->with('customer', $customer);
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
     public function idvlink(Request $request) {
        $sbid = $request->session()->get('sbid');

        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->first();
            $phoneNumber= $selfbankingdetails->PhoneNumber;
        return view('self-banking.idvlink')
            ->with('customer', $customer)
            ->with('phoneNumber', $phoneNumber)
            ->with('sbid', $sbid);
     }

     public function bankingAvs(Request $request) {
        $sbid = $request->session()->get('sbid');

        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->first();
            $phoneNumber= $selfbankingdetails->PhoneNumber;
        return view('self-banking.banking')
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

            $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->first();
            $phoneNumber= $selfbankingdetails->PhoneNumber;

            $ficadetails = FICA::where('Consumerid', '=', $selfbankingdetails->SelfBankingDetailsId)->first();



            $UserVerificationController = new UserVerificationController;
            try
            {
                $user = Auth::user();
                $get_user_id = DOVS::select("TBL_Consumer_DOVS.*","TBL_Consumer_SelfBankingDetails.*")
                                        ->join("TBL_FICA","TBL_FICA.FICA_id","TBL_Consumer_DOVS.FICA_id")
                                        ->join("TBL_Consumer_SelfBankingDetails","TBL_FICA.Consumerid","TBL_Consumer_SelfBankingDetails.SelfBankingDetailsId")
                                        ->where("TBL_FICA.FICA_id",$ficadetails->FICA_id)
                                        ->where("TBL_FICA.ConsumerReferance",4)
                                        ->get()
                                        ->toArray();

                                     //   print_r($get_user_id);exit;

                                        if(count($get_user_id)==0){
                                            return redirect("some thing went wrong");
                                        }

                                            $IDNumber = $get_user_id[0]["IDNUMBER"];
                                            //$PhoneNumber = $get_user_id[0]["PhoneNumber"];
                                            $PhoneNumber = $request->input('phone');
                                            $DOVS_id = $get_user_id[0]["DOVS_id"];


                                            $soapUrlLive = config("app.API_SOAP_URL_LIVE_FACIAL");
                                            $soapUrlDemo = config("app.API_SOAP_URL_DEMO_FACIAL");

                                           // $soapUrlLive = $soapUrlDemo; //here we are changing the url to the demo/dev/testing environment
                                            $username = $this->xdsusername; // Demo username
                                            //$username = 'czs_ws'; // Live username
                                            $password = $this->xdspassword;


                                            //app('debugbar')->info($client);
                                            $returnValue = $UserVerificationController->soapLoginAPICall($soapUrlLive, $username, $password);



                                            $enquiryId = null;
                                            $enquiryResultId = null;

                                            $tempData = explode('>', $returnValue);

                                            if (isset($tempData[5])) {
                                                $tempData2 = explode('<', $tempData[5]);
                                                $ticketNo = $tempData2[0];


                                                $returnValue = $UserVerificationController->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                                                $tempData = explode('>', $returnValue);
                                                $tempData2 = explode('<', $tempData[5]);
                                                $valid = $tempData2[0];


                                                if ($valid  == "true") { //if ticket is valid

                                                    //here we want to use the consumer match DOVS methods

                                                    $returnMatchDOVS = $UserVerificationController->connectConsumerMatchDOVS($soapUrlLive, $username, $password, $ticketNo, 194, $IDNumber, $passport_no = null, $PhoneNumber);
                                                   // print_r($returnMatchDOVS);
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

                                                    $returnDOVRequest = $UserVerificationController->connectDOVRequest($soapUrlLive, $username, $password, $ticketNo, $enquiryId, $enquiryResultId, 194);
                                                  //  print_r($returnDOVRequest); exit;
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

                                                    /* Store the Enquiry ID  */


                                                    DOVS::where('DOVS_id', $DOVS_id)->update(
                                                        array(
                                                            'LastUpdatedDate' => date("Y-m-d H:i:s"),

                                                        )
                                                    );
                                                    $request->session()->put('enquiryId', $enquiryId);
                                                    return "true";


                                                    //API LOGS
                                                    //dd($this->FACE);
                                                   // $dovsLookup = LookupDatas::where('ID', '=', $this->FACE)->first();




                                                   // $request->session()->put('enquiryId', $enquiryId);
                                                   // return redirect()->back()->with("success","Successfully submited")->with("phone",$phoneNumber);
                                               // }else{
                                                    //return redirect()->back()->with("error","Token Expired");
                                                }
                                                //end of if statement ticket still valid
                                            } //end of if statement
                                       // return redirect()->back()->with("error","Some thing went wrong please try after some time");
                                       return false;
                                    } catch (\Exception $e) {
                                        //app('debugbar')->info($e);
                                        return false;
                                    }
                                   // return redirect()->back()->with("error","Some thing went wrong please try after some time");



            //return view('self-banking.idvlink', [
              //  'sbid' => $sbid, 'phoneNumber' => $phoneNumber, 'customer' => $customer
            //]);

     }


}


