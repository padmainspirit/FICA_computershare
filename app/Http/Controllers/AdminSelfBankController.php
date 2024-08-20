<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SmsOtpController;
use App\Models\APILogs;
use App\Models\Company;
use App\Models\Customer;
use App\Http\Controllers\UserVerificationController;
use App\Models\AVS;
use App\Models\BankAccountType;
use App\Models\Banks;
use App\Models\ConsumerIdentity;

use App\Models\DOVS;
use App\Models\FICA;
use App\Models\LookupDatas;
use App\Models\SelfBankingCompanySRN;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingExceptions;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

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

    protected $soapUrlLive;
    protected $soapUrlDemo;
    protected $s3url;

    public function __construct()
    {
        //$this->middleware('permission:compliance-lite', ['only' => ['index']]);
        $this->homeAddressIDType = config("app.HOME_LOOKUP_TABLE_ID"); //HOME:16
        $this->PostalAddressIDType = config("app.POSTAL_LOOKUP_TABLE_ID"); //POSTAL:15
        $this->WorkAddressIDType = config("app.WORK_LOOKUP_TABLE_ID"); //WORK:14
        $this->IDAS_ID = config("app.IDAS_ID"); //IDAS_ID

        $this->xdsusername = config("app.API_LOGIN_USERNAME");
        $this->xdspassword = config("app.API_LOGIN_PASSWORD");

        $this->DOVS = config("app.API_ID_DOVS");
        $this->FACE = config("app.API_ID_FACE");

        $this->soapUrlLive = config("app.API_SOAP_URL_LIVE_XDS_SELFIE_RESULT");
        $this->soapUrlDemo = config("app.API_SOAP_URL_DEMO_XDS_SELFIE_RESULT");
        $this->s3url = config('app.API_UPLOAD_PATH');

        date_default_timezone_set('Africa/Johannesburg');
    }

    /* Function to generate link for self banking and send it via Email/SMS */
    public function SendLink(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::getCustomerDetails($user->CustomerId);
        $Year = Carbon::now()->year;
        if (!empty($_POST)) {
            $this->validate($request, [
                'Media' => ['required', 'string'],
                'PhoneNumber' => ['nullable', 'digits:10', 'required_if:Media,SMS'],
                'Email' => ['nullable', 'Email', 'required_if:Media,Email'],
            ]);

            $selfbankingId = Str::upper(Str::uuid());
            if ($_POST['Media'] == 'Email' || $_POST['Media'] == 'SMS') {
                $linkGenerated = URL::temporarySignedRoute(
                    'selfbanking',
                    now()->addHours(2),
                    ['sbid' => $selfbankingId]
                );
            } else {
                return false;
            }

            $request['Id'] = $selfbankingId;
            $request['CustomerUserId'] = $user->Id;
            $request['CustomerId'] = $user->CustomerId;
            $request['LinkGenerated'] = $linkGenerated;
            SelfBankingLink::create($request->all());



            if ($_POST['Media'] == 'Email') {
                Mail::send(
                    'email.email-selfbankinglink',
                    ['Logo' => $customer->Client_Logo, 'TradingName' => $customer->RegistrationName, 'YearNow' => $Year, 'linkGenerated' => $linkGenerated],
                    function ($message) use ($request) {
                        $message->to($_POST['Email']);
                        $message->subject('Self Service Banking Link');
                    }
                );
            } else if ($_POST['Media'] == 'SMS') {
                $sms = new SmsOtpController();
                $smsresult = $sms->sendselfServicelink($_POST['PhoneNumber'], $linkGenerated);
                print_r($smsresult);
                exit;
            } else {
                return false;
            }
        }
        return view('self-banking.send-link')
            ->with('customer', $customer)
            ->with('UserFullName', $user->FirstName . ' ' . $user->Surname);
    }

    public function genearateLink(Request $request)
    {
        $selfbankingId = Str::upper(Str::uuid());
        $linkGenerated = URL::temporarySignedRoute(
            'selfbanking',
            now()->addHours(config("app.SelfBankingLink_ExpiryTime")),
            ['sbid' => $selfbankingId]
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

        if (!$request->hasValidSignature()) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        } else {
            //$request->session()->invalidate();
            $request->session()->put('sbid', $sbid);
            $request->session()->put('sb_progress', 0);
            if ($selfbanking->tnc_flag == 1) {

                $routename = SelfBankingLink::checkStep($sbid);
                return redirect()->route($routename);
            }
            SelfBankingLink::where(['Id' => $sbid])->update(['IsClicked' => 1]);
            return view('self-banking.index')
                ->with('customer', $customer)
                ->with('sbid', $sbid);
        }
    }


    /* Self banking flow link  */
    public function selfBankingStart(Request $request)
    {
        $sbid = $request->session()->get('sbid');
        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $companies = Company::all('Company_Name')->sortBy('Company_Name');
        if (!empty($_POST)) {

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
        //return view('self-banking.sb_personalinfo')
        return view('self-banking.index')
            ->with('customer', $customer)
            ->with('companies', $companies)
            ->with('sbid', $sbid);
    }


    /* Self banking flow link  */
    public function sbPersonalInfo(Request $request)
    {

        $sbid = $request->session()->get('sbid');
        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $selfbanking->Id = $sbid;
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $companies = Company::all('Company_Name')->sortBy('Company_Name');
        if (!empty($_POST)) {

            //$this->validate($request, [
            $validator = Validator::make($request->all(), [
                'IDNUMBER' => ['required', 'digits:13'],
                'FirstName' => ['required', 'string', 'min:2', 'max:50'],
                'Surname' => ['required', 'string', 'min:2', 'max:50'],
                'PhoneNumber' => ['required', 'digits:10', 'max:50'],
                'Email' => ['required', 'string', 'email', 'max:50'],
                'reflist.*.refnum' => ['required', 'string', 'regex:/^[c|u|d|C|U|D]{1}[0-9]{10}$/',],
                //'reflist.*.company' => ['required_if:reflist.*.refnum,C1234567890']
            ], [
                'IDNUMBER.required' => 'ID Number should be of 13 digits',
                'reflist.*.refnum.required' => 'The SRN Number is required at row number :position of Account details',
                'reflist.*.refnum.regex' => 'Please provide a valid SRN Number :position row of Account details',
                //'reflist.*.company.required' => 'The company selection is required at :position row of Account details',
            ]);

            $validator->after(function ($validator) {
                foreach ($validator->getData()['reflist'] as $key => $value) {
                    $position = $key + 1;
                    if ((preg_match('/[C|c]{1}[0-9]{10}/', $value['refnum'])) && $value['company'] == null && $value['company'] == '') {
                        $validator->errors()->add('reflist.' . $key . '.company', 'The company selection is required at row number ' . $position . ' of Account details');
                    }
                }
            })->validate();

            /* code for validating ID number using idas API */
            $verifyData = new VerifyUserController();
            $apiresult = $verifyData->verifyUser($request->IDNUMBER, $request);

            if ($apiresult[0] != $request->IDNUMBER) {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Invalid ID number has been entered');
            }
            if (strtoupper($apiresult[4]) != strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname)) {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Firstname and surname does not match with the IDnumber');
            }
            if ($apiresult[24] != '' || $apiresult[24] != null) {
                return redirect()->route('sb-personalinfo')->withInput($request->input())->with('message', 'Idnumber of deseased person has been entered');
            }


            $selfbankingdetailsid = Str::upper(Str::uuid());
            SelfBankingLink::where(['Id' => $sbid])->update(['PersonalDetails' => 1]);

            $selfbanking->PersonalDetails = 1;
            /* Matches First name only */
            if (strtoupper($apiresult[4]) == strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname) && strtoupper($apiresult[6]) != strtoupper($request->SecondName)) {
                $sbe = SelfBankingExceptions::create([
                    'Id' => Str::upper(Str::uuid()),
                    'SelfBankingLinkId' => $selfbankingdetailsid,
                    'API' => 1,
                    'Status' => 'Validation Pending',
                    'Comment' => 'Pending Surname'
                ]);
                $sbe->save();
                SelfBankingLink::where(['Id' => $sbid])->update(['PersonalDetails' => 2]);
            }

            /* Matches First name and Second name only */
            if (strtoupper($apiresult[4]) == strtoupper($request->FirstName) && strtoupper($apiresult[5]) != strtoupper($request->Surname) && strtoupper($apiresult[6]) == strtoupper($request->SecondName)) {
                $sbe = SelfBankingExceptions::create([
                    'Id' => Str::upper(Str::uuid()),
                    'SelfBankingLinkId' => $selfbankingdetailsid,
                    'API' => 1,
                    'Status' => 'Validation Pending',
                    'Comment' => 'Pending Surname'
                ]);
                $sbe->save();
                SelfBankingLink::where(['Id' => $sbid])->update(['PersonalDetails' => 2]);
            }


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

            $fica_id = Str::upper(Str::uuid());

            $sbfica = FICA::create([
                'FICA_id' =>  $fica_id,
                'Consumerid' => $selfbankingdetailsid,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAStatus' => 'In progress',
                'FICA_Active' => 1,
                'ConsumerReferance' => 4,
            ]);
            $sbfica->save();

            $clientdata = new VerificationDataController();

            $consumerIdentity = ConsumerIdentity::where('FICA_id', '=',  $fica_id)->first();
            if ($consumerIdentity == null) {
                $consumeriden = ConsumerIdentity::create([
                    'Identity_ID' => Str::upper(Str::uuid()),
                    'FICA_id' =>  $fica_id,
                    'Identity_Document_ID' => $request->IDNUMBER,
                ]);
                $consumeriden->save();
            }
            $clientdata->verifyClientDataSb($request->IDNUMBER, $request, $fica_id);

            

            foreach ($request['reflist'] as $srndet) {
                $compnanysrn = new SelfBankingCompanySRN;
                $compnanysrn->ID = Str::upper(Str::uuid());
                $compnanysrn->SelfBankingDetailsId = $selfbankingdetailsid;
                $compnanysrn->SRN = $srndet['refnum'];
                $compnanysrn->companies = $srndet['company'];
                $compnanysrn->save();
            }
            $sbDovs = DOVS::create([
                'DOVS_id' =>  Str::upper(Str::uuid()),
                'FICA_id' => $fica_id,
                'CreatedOnDate' => date("Y-m-d H:i:s"),
                'SelfieStatus' => 'Pending',

            ]);
            $sbDovs->save();


            /* return view('self-banking.digi_verify')
            ->with('customer', $customer); */
             return redirect()->route('digi-verify');
        }
        return view('self-banking.sb_personalinfo')
            ->with('customer', $customer)
            ->with('companies', $companies)
            ->with('sbid', $sbid);
    }


     public function uploadid(Request $request) {
        $sbid = $request->session()->get('sbid');
        if($sbid == '' || $sbid == null){
            $url = '/';
                return response()->view('errors.401', ['message'=>'link has been expired','url'=>$url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }

        $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica'])->where('Id',$sbid)->first(); 
        $fica_id = $selfbankinglinkdetails->selfBankingDetails->fica->FICA_id;

        if($_POST)
        {
            $this->validate(
                $request,
                [
                    'file' => 'required|file|mimes:jpg,jpeg,png,pdf',
                ],
                [
                    'file.required' => 'Please upload a ID document',
                    'file.mimes' => 'Invalid document format. Please upload a PDF or Image with jpg, jpeg or png format',
                ]
            );
            $fileName = $request->file->getClientOriginalName();
            $filePath = 'SelfBanking/' . $sbid . '/IdDocs/'. $fileName;

            //Storing the file in s3 bucket            
            //Storage::disk('s3')->put($filePath, file_get_contents($request->file));
            Storage::disk('public')->put($filePath, file_get_contents($request->file));
            $urlFile = $this->s3url.$filePath;

            ConsumerIdentity::where('FICA_id', $fica_id)->update([
                    'Identity_Documentname' => $fileName,
                    'Identity_File_Path' =>  $urlFile,
            ]);

            SelfBankingLink::where(['Id'=>$sbid])->update(['IdDocumentUpload'=>1]);
            return redirect()->route('banking');

        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        return view('self-banking.upload_iddoc')
            ->with('customer', $customer);
     }

     /* Digital verification of self service banking */
     public function DigiVerification(Request $request) {
        $sbid = $request->session()->get('sbid');

        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        return view('self-banking.digi_verify')
            ->with('customer', $customer);
    }

    public function idvlink(Request $request)
    {
        $sbid = $request->session()->get('sbid');

        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename && $routename != "digi-verify") {
            return redirect()->route($routename);
        }

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->first();
        $phoneNumber = $selfbankingdetails->PhoneNumber;
        return view('self-banking.idvlink')
            ->with('customer', $customer)
            ->with('phoneNumber', $phoneNumber)
            ->with('sbid', $sbid);
    }

    public function bankingAvs(Request $request)
    {
       // $sbid = "90E7B1CC-4F65-4183-A0F4-2717CD9C82A0";
        $sbid = $request->session()->get('sbid');  
           
        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }

        $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica'])->where('Id',$sbid)->first(); 
        $fica_id = $selfbankinglinkdetails->selfBankingDetails->fica->FICA_id;

        if (!empty($_POST)) { 

            $this->validate(
                $request,
                [
                    'initial' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:3',
                    'accnumber' => 'required|numeric|min_digits:7|max_digits:11',
                    'BankName' => ['required'],
                    'AccountType' => ['required'],
                    'branchcode' => ['required'],
                    'file'=> 'required_if:BankName,other|mimes:jpg,jpeg,png,pdf'
                ],
                [
                    'sb-tnc.required' => 'You have to agree to the terms and conditions of banking service to continue the flow',
                    'accnumber.max_digits' => 'The account number cannot be more than 11 digits.',
                    'accnumber.min_digits' => 'The account number cannot be less than 7 digits.',
                    'file.required' => 'Bank document is required when bank name is other.',
                    'file.mimes' => 'Invalid document format. Please upload a PDF or Image with jpg, jpeg or png format',
                ]
            );

            $avs = AVS::where('FICA_id', '=', $fica_id)->first();
            if ($avs == null) {
                $avsuser = AVS::create([
                    'Bank_id' => Str::upper(Str::uuid()),
                    'FICA_id' => $fica_id,
                    'Bank_name' => $request->BankName,
                    'Branch_code' => $request->branchcode,
                    'Account_no' => $request->accnumber,
                    'Account_name' => $request->initial.' '.$selfbankinglinkdetails->selfBankingDetails->FirstName.' '.$selfbankinglinkdetails->selfBankingDetails->Surname,
                    'BankTypeid' => $request->AccountType,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                ]);
                $avsuser->save();
            }else{
                AVS::where(['FICA_id'=>$fica_id])->update([
                    'Bank_name' => $request->BankName,
                    'Branch_code' => $request->branchcode,
                    'Account_no' => $request->accnumber,
                    'Account_name' => $request->initial.' '.$selfbankinglinkdetails->selfBankingDetails->FirstName.' '.$selfbankinglinkdetails->selfBankingDetails->Surname,
                    'BankTypeid' => $request->AccountType,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                ]);
            }

            SelfBankingDetails::where(['SelfBankingLinkId'=>$sbid])->update([                
                'AccountType'=> $request->AccountType,
                'BankName' => $request->BankName,
                'BranchCode'=> $request->branchcode,
                'AccountNumber'=> $request->accnumber,
                'AccountHolderInitial' => $request->initial
            ]);

            if($request->BankName == 'other')
            {
                $fileName = $request->file->getClientOriginalName();
                $filePath = 'SelfBanking/' . $sbid . '/BankDocs/'. $fileName;

                //Storing the file in s3 bucket            
                //Storage::disk('s3')->put($filePath, file_get_contents($request->file));
                Storage::disk('public')->put($filePath, file_get_contents($request->file));
                $urlFile = $this->s3url.$filePath;

                $sbe = SelfBankingExceptions::create([
                    'Id' => Str::upper(Str::uuid()),
                    'SelfBankingLinkId' => $sbid,
                    'API' => 3,
                    'Status' => 'Validation Pending',
                    'Comment' => '3-Month Bank Statement'
                ]);
                $sbe->save();

                AVS::where('FICA_id', $fica_id)->update([
                        'Bank_Documentname' => $fileName,
                        'Bank_File_Path' =>  $urlFile,
                ]);
                SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>2,'BankDocumentUpload'=>1]);

                //return redirect()->route('sb-preview-details')->withInput($request->input())->with('Success', 'AVS has been executed succesfully');
                //return redirect()->route('banking')->withInput($request->input())->with('Success', 'Bank document is received succesfully');
            }else{
                SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>0,'BankDocumentUpload'=>0]);
                SelfBankingExceptions::where(['SelfBankingLinkId'=>$sbid, 'API'=>3])->delete();

                /* 
                $sb_api = new AdminSelfServiceBankingApiController();
                ob_start();
                $ticket = Session::has('xdsTicket') ? Session::get('xdsTicket') : $sb_api->connectandgetNewTicket(); //$this->connectandgetTicket();
                ob_end_clean();
                
                $bankInfo = BankAccountType::where('BankTypeid', '=',  $request->AccountType)->first();
                $verifyType = 'Individual';
                $entity = 'None';

                $avsLookup = LookupDatas::where(['Type'=>'API_ID','Text'=>'AVS'])->first();
                $surname = $selfbankinglinkdetails->selfBankingDetails->Surname; 
                $email = $selfbankinglinkdetails->selfBankingDetails->Email;
                $id_type = 'SID';
                $initials =  $request->initial;
                $accNo =   $request->accnumber;
                $branchCode =  $request->branchcode;
                $accType = $bankInfo->Account_description;
                $bankName =  $request->BankName;
                $id_no =  $selfbankinglinkdetails->selfBankingDetails->IDNUMBER;
                $contactNo =  $selfbankinglinkdetails->selfBankingDetails->PhoneNumber;
        
                $userVerification = new UserVerificationController();
        
                $returnValue = $userVerification->soapBankVerificationAPICall($this->soapUrlLive, $this->xdsusername, $this->xdspassword, $ticket, $verifyType, $entity, $initials, $surname, $id_no, $id_type, null, null, null, null, null, $accNo, $branchCode, $accType, $bankName, $contactNo, $email, null);
             
                // app('debugbar')->info($returnValue);
                
                
                $jsonres = $sb_api->parseSoapXml($returnValue);
                
                $jbody = $jsonres['Body']['ConnectAccountVerificationRealTimeWithContactsResponse']['ConnectAccountVerificationRealTimeWithContactsResult'];
                if(preg_match('<Error>', $jbody))
                {
                    $errorMessage = strip_tags($jbody);
                            $message = $errorMessage != null ? $errorMessage : 'AVS Failed, Please contact administrator';
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 0,
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ErrorMessage' => $message
                                )
                            );
                    return redirect()->route('banking')->withInput($request->input())->with('message', 'AVS Failure');
                }
                else if(array_key_exists('Fault',$jsonres['Body'])){
                    return redirect()->route('banking')->withInput($request->input())->with('message', 'There might be some sort of server or internet issue, please try again later.');
                } else {
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
        
                    $referenceNo = (int)preg_replace('/[^0-9]/', '', $tempData2[0]); //here we want to get only numbers and filter the rest of the characters
        
                    $returnValue = $userVerification->ConnectGetAccountVerificationResult($this->soapUrlLive, $this->xdsusername, $this->xdspassword, $ticket, $referenceNo);
        
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
        
                    $tempData3 = str_replace('&lt;', '', $tempData2);
                    $tempData4 = str_replace('&gt', '', $tempData3);
                    $tempData5 = explode(';', $tempData4[0]);
                    //print_r($returnValue);exit;
        
                    if ($tempData5[2] == 'Invalid Ticket/Error') {
                        return redirect()->route('banking')->withInput($request->input())->with('message', 'Internal error, please try again.');
                    } else {
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
                        //print_r($tempData5);exit;
        
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
                    //print_r($tempData5);exit;
                        if ($tempData5[1] == 'ResultFile') {
                            app('debugbar')->info($returnData);
                            app('debugbar')->info('tempData5');
                            app('debugbar')->info($tempData5);
                            //bank verification successful
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 1,
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
                                    'ErrorMessage' => NULL,
                                    'AVSResponse' => $returnValue
                                )
                            );
        
                            //API LOGS
                            APILogs::create([
                                'API_Log_Id' => Str::upper(Str::uuid()),
                                'FICAId' => $fica_id,
                                'ConsumerID' => $selfbankinglinkdetails->selfBankingDetails->Id,
                                'CustomerID' =>  config("app.CUSTOMER_DEFAULT_ID"),
                                'Createddate' => date("Y-m-d H:i:s"),
                                'API_ID' => $avsLookup->Value,
                            ]);
                            if($ACCOUNTFOUND == 'No'){
                                return redirect()->route('banking')->withInput($request->input())->with('message', 'Internal checks are failed');
                            }else{
                                return redirect()->route('banking')->withInput($request->input())->with('Success', 'Internal checks been executed succesfully');
                            }
                        } else {
                            //invalid bank information
                            $errorMessage = str_replace('/Error', '', $tempData5[2]);
                            $message = $errorMessage != null ? $errorMessage : 'AVS Failed, Please contact administrator';
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 0,
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ErrorMessage' => $message
                                )
                            );
                            return redirect()->route('banking')->withInput($request->input())->with('message', 'AVS Failure');
                        }
                    }
                }
            
                */
                
            }
            

            return redirect()->route('sb-preview-details');
        }
        $banks = Banks::all()->sortBy('bankname');
        $bankTpye = BankAccountType::all();

       
        $customer = Customer::getCustomerDetails($selfbankinglinkdetails->CustomerId);
        $avs = AVS::where(['FICA_id'=>$fica_id])->first();

        return view('self-banking.banking')
            ->with('customer', $customer)
            ->with('bankNames', $banks)
            ->with('bankTpye', $bankTpye)
            ->with('selfbankinglinkdetails', $selfbankinglinkdetails);
    }


    /* Self banking flow link  */
    public function sbEmailorPhone(Request $request)
    {

        $sbid = $request->session()->get('sbid');

        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        /* $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        } */

        $this->validate($request, [
            'phone' => ['nullable', 'digits:10'],
        ]);

        $selfbanking = SelfBankingLink::find($sbid);
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);

        $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->first();
        $phoneNumber = $selfbankingdetails->PhoneNumber;

        $ficadetails = FICA::where('Consumerid', '=', $selfbankingdetails->SelfBankingDetailsId)->first();


        if($_POST){
            $UserVerificationController = new UserVerificationController;
            try {
                $get_user_id = DOVS::select("TBL_Consumer_DOVS.*", "TBL_Consumer_SelfBankingDetails.*")
                    ->join("TBL_FICA", "TBL_FICA.FICA_id", "TBL_Consumer_DOVS.FICA_id")
                    ->join("TBL_Consumer_SelfBankingDetails", "TBL_FICA.Consumerid", "TBL_Consumer_SelfBankingDetails.SelfBankingDetailsId")
                    ->where("TBL_FICA.FICA_id", $ficadetails->FICA_id)
                    ->where("TBL_FICA.ConsumerReferance", 4)
                    ->get()
                    ->toArray();

               
                if (count($get_user_id) == 0) {
                    return redirect("some thing went wrong");
                }

                $IDNumber = $get_user_id[0]["IDNUMBER"];
                //$PhoneNumber = $get_user_id[0]["PhoneNumber"];
                $PhoneNumber = $request->input('phone');
                $DOVS_id = $get_user_id[0]["DOVS_id"];

                SelfBankingDetails::where('SelfBankingLinkId', '=', $sbid)->update(['DovsPhoneNumber'=>$PhoneNumber]);

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
                        return true;


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
        }
        // return redirect()->back()->with("error","Some thing went wrong please try after some time");



        //return view('self-banking.idvlink', [
        //  'sbid' => $sbid, 'phoneNumber' => $phoneNumber, 'customer' => $customer
        //]);

    }

    public function getSelfieResultFromxXDS(Request $request)
    {
       /* $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>  'Consumer','process_status' => 'NoPhoto'];
                        return $output_data; */
        $sbid = $request->session()->get('sbid');

        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }
        $selfbanking = SelfBankingLink::find($sbid);
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingLinkId', '=',  $sbid)->first();
        $customer = Customer::getCustomerDetails($selfbanking->CustomerId);
     
        try {
            /* $loggedInUserId = Auth::user()->Id;
            $client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
            $customers = Customer::where('Id', '=',  $client->CustomerId)->first();
            // $client = CustomerUser::where('Id', '=', session()->get('LoggedUser'))->first();
            // $customers = Customer::where('Id', '=',  $client->CustomerId)->first();
            $dovsLookup = LookupDatas::where('ID', '=', $this->DOVS)->first(); */


            //app('debugbar')->info($customers);

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


            //if ($client->isAdmin == 1 || $client->isAdmin == 0) {
                
            $UserVerificationController = new UserVerificationController;
            $soapUrlLive = config("app.API_SOAP_URL_LIVE_XDS_SELFIE_RESULT");
            $soapUrlDemo = config("app.API_SOAP_URL_DEMO_XDS_SELFIE_RESULT");
            //$soapUrlLive = $soapUrlDemo; //here we are changing the url to the demo/dev/testing environment
            $username = $this->xdsusername; // Demo username

            $password = $this->xdspassword;
           
            $returnValue = $UserVerificationController->soapLoginAPICall($soapUrlLive, $username, $password);
            //$enquiryId = $request->enquiryId;
            //$enquiryId = 57080687/57096945
            $enquiryId =  $request->session()->get('enquiryId');

            app('debugbar')->info($enquiryId);


            $tempData = explode('>', $returnValue);

            //app('debugbar')->info($tempData);
            if (isset($tempData[5])) {
                $tempData2 = explode('<', $tempData[5]);
                $ticketNo = $tempData2[0];

                $returnValue = $UserVerificationController->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);
                $tempData = explode('>', $returnValue);
                $tempData2 = explode('<', $tempData[5]);
                $valid = $tempData2[0];


                if ($valid  == "true") {
                    //here we want to use the consumer match DOVS methods
                    $returnConnectGetDOVResult = $UserVerificationController->connectGetDOVResult($soapUrlLive, $username, $password, $ticketNo, $enquiryId);
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
                        //$loggedInUserId = Auth::user()->Id;
                       // $IDNUMBER = Auth::user()->IDNumber;
                        //$client = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
                        //$consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
                        // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
                        $fica = FICA::where('Consumerid', '=',  $selfbankingdetails->SelfBankingDetailsId)->first();



                        $Enquirydate = strtotime($EnquiryDate);
                        $EnquiryDateformartDate = date("Y-m-d H:i:s", $Enquirydate);
                        app('debugbar')->info($tempData5);
                        session()->put('data', $tempData5);

                        $dovs = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();

                        if ($dovs == null) {
                            $dovsuser = DOVS::create([
                                'DOVS_id' => Str::upper(Str::uuid()),
                                'FICA_id' => $fica->FICA_id,
                            ]);
                            $dovsuser->save();
                        }

                        DOVS::where('FICA_id', $fica->FICA_id)->update(
                            array(
                                //'CreatedOnDate' =>  date("Y-m-d H:i:s"),
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


                        $process = 'Success';
                        /* Process passed due to no home affairs photo we have to redirect todocument upload screen */
                        if($ConsumerIDPhoto == '' || $ConsumerIDPhoto == null)
                        {
                            $sbe = SelfBankingExceptions::create([
                                'Id' => Str::upper(Str::uuid()),
                                'SelfBankingLinkId' => $sbid,
                                'API' => 4,
                                'Status' => 'Validation Pending',
                                'Comment' => 'No home affairs photo'
                            ]);
                            $sbe->save();

                            SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>2]);

                            $process = 'NoPhoto';
                        }else if($ConsumerIDPhotoMatch != 'Matched'){ 
                            /* Process failed flow, terminate the execution */
                            $sbe = SelfBankingExceptions::create([
                                'Id' => Str::upper(Str::uuid()),
                                'SelfBankingLinkId' => $sbid,
                                'API' => 4,
                                'Status' => 'Failed',
                                'Comment' => 'Photo does not match'
                            ]);
                            $sbe->save();

                            SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>-2]);

                            $process = 'Failed';
                        }else if($ConsumerIDPhotoMatch == 'Matched'){ 
                            SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>1]);
                            $process = 'Success';
                        }

                        FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->update(
                            array(
                                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                'DOVS_Status' => date("Y-m-d H:i:s")
                            )
                        );

                        //API LOGS
                        APILogs::create([
                            'API_Log_Id' => Str::upper(Str::uuid()),
                            'FICAId' => $fica->FICA_id,
                            'ConsumerID' => $fica->Consumerid,
                            'CustomerID' =>  $selfbanking->CustomerId,
                            'Createddate' => date("Y-m-d H:i:s"),
                            'API_ID' => 4,
                        ]);

                        // $request->session()->put('FICAProgress', $fica->FICAProgress);
                        $output_data = ['response' => true, 'message' => 'request is successful.', 'data' =>  $tempData5[0], 'messageResult' => $messageResult,'process_status' => $process];
                        return $output_data;
                    }
                }
            }
            /* } else {
                return 'failed';
            } */
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }
    }


    public function previewDetails(Request $request)
    {
        $sbid = $request->session()->get('sbid');

        $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica','selfBankingDetails.bankAccountType','selfBankingDetails.SBCompanySRN'])->where('Id',$sbid)->first(); 
        
        $fica_id = $selfbankinglinkdetails->selfBankingDetails->fica->FICA_id;
        $customer = Customer::getCustomerDetails($selfbankinglinkdetails->CustomerId);
        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }


        if($_POST){ 
            if($selfbankinglinkdetails->selfBankingDetails->BankName == "other")
            {
                return redirect()->route('process-status');
            }

            $sb_api = new AdminSelfServiceBankingApiController();
                ob_start();
                $ticket = Session::has('xdsTicket') ? Session::get('xdsTicket') : $sb_api->connectandgetNewTicket(); //$this->connectandgetTicket();
                ob_end_clean();
                
                $verifyType = 'Individual';
                $entity = 'None';

                $avsLookup = LookupDatas::where(['Type'=>'API_ID','Text'=>'AVS'])->first();
                $surname = $selfbankinglinkdetails->selfBankingDetails->Surname; 
                $email = $selfbankinglinkdetails->selfBankingDetails->Email;
                $id_type = 'SID';
                $initials =  $selfbankinglinkdetails->selfBankingDetails->AccountHolderInitial;
                $accNo =   $selfbankinglinkdetails->selfBankingDetails->AccountNumber;
                $branchCode =  $selfbankinglinkdetails->selfBankingDetails->BranchCode;
                $accType = $selfbankinglinkdetails->selfBankingDetails->bankAccountType->Account_description;
                $bankName =  $selfbankinglinkdetails->selfBankingDetails->BankName;
                $id_no =  $selfbankinglinkdetails->selfBankingDetails->IDNUMBER;
                $contactNo =  $selfbankinglinkdetails->selfBankingDetails->PhoneNumber;
        
                $userVerification = new UserVerificationController();
        
                $returnValue = $userVerification->soapBankVerificationAPICall($this->soapUrlLive, $this->xdsusername, $this->xdspassword, $ticket, $verifyType, $entity, $initials, $surname, $id_no, $id_type, null, null, null, null, null, $accNo, $branchCode, $accType, $bankName, $contactNo, $email, null);
            
                // app('debugbar')->info($returnValue);
                
                
                $jsonres = $sb_api->parseSoapXml($returnValue);
                
                $jbody = $jsonres['Body']['ConnectAccountVerificationRealTimeWithContactsResponse']['ConnectAccountVerificationRealTimeWithContactsResult'];
                if(preg_match('<Error>', $jbody))
                {
                    $errorMessage = strip_tags($jbody);
                            $message = $errorMessage != null ? $errorMessage : 'AVS Failed, Please contact administrator';
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 0,
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ErrorMessage' => $message
                                )
                            );
                    //return redirect()->route('process-status')->withInput($request->input())->with('message', 'AVS Failure');
                    SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>-2,'BankDocumentUpload'=>0]);
                    return redirect()->route('process-status');
                }
                else if(array_key_exists('Fault',$jsonres['Body'])){
                    //return redirect()->route('process-status')->withInput($request->input())->with('message', 'There might be some sort of server or internet issue, please try again later.');
                    SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>-1,'BankDocumentUpload'=>0]);
                    return redirect()->route('process-status');
                } else {
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
        
                    $referenceNo = (int)preg_replace('/[^0-9]/', '', $tempData2[0]); //here we want to get only numbers and filter the rest of the characters
        
                    $returnValue = $userVerification->ConnectGetAccountVerificationResult($this->soapUrlLive, $this->xdsusername, $this->xdspassword, $ticket, $referenceNo);
         
                   
                    $tempData = explode('>', $returnValue);
                    $tempData2 = explode('<', $tempData[5]);
        
                    $tempData3 = str_replace('&lt;', '', $tempData2);
                    $tempData4 = str_replace('&gt', '', $tempData3);
                    $tempData5 = explode(';', $tempData4[0]);
                    //print_r($returnValue);exit;
        
                    if ($tempData5[2] == 'Invalid Ticket/Error') {
                       // return redirect()->route('process-status')->withInput($request->input())->with('message', 'Internal error, please try again.');
                       return redirect()->route('process-status');
                    } else {
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
                        //print_r($tempData5);exit;
        
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
                    //print_r($tempData5);exit;
                        if ($tempData5[1] == 'ResultFile') {
                            app('debugbar')->info($returnData);
                            app('debugbar')->info('tempData5');
                            app('debugbar')->info($tempData5);
                            //bank verification successful
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 1,
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
                                    'ErrorMessage' => NULL,
                                    'AVSResponse' => $returnValue
                                )
                            );
        
                            //API LOGS
                            APILogs::create([
                                'API_Log_Id' => Str::upper(Str::uuid()),
                                'FICAId' => $fica_id,
                                'ConsumerID' => $selfbankinglinkdetails->selfBankingDetails->Id,
                                'CustomerID' =>  config("app.CUSTOMER_DEFAULT_ID"),
                                'Createddate' => date("Y-m-d H:i:s"),
                                'API_ID' => $avsLookup->Value,
                            ]);

                            if($ACCOUNTFOUND == 'No'){

                                SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>-2,'BankDocumentUpload'=>0]);
                                return redirect()->route('sb-preview-details')->withInput($request->input())->with('message', 'Internal checks are failed');
                                //return redirect()->route('process-status')->withInput($request->input())->with('message', 'Internal checks are failed');

                            }else if($ACCOUNTOPENFORATLEASTTHREEMONTHS == 'Yes'){
                                $sbe = SelfBankingExceptions::create([
                                    'Id' => Str::upper(Str::uuid()),
                                    'SelfBankingLinkId' => $sbid,
                                    'API' => 3,
                                    'Status' => 'Review',
                                    'Comment' => 'ACCOUNT OPEN FOR ATLEAST THREE MONTHS'
                                ]);
                                $sbe->save();
                                SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>1,'BankDocumentUpload'=>0]);
                                //return redirect()->route('process-status')->withInput($request->input())->with('message', 'Internal checks are failed');
                                return redirect()->route('process-status');
                            }else{
                                SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>1,'BankDocumentUpload'=>0]);
                                return redirect()->route('process-status')->withInput($request->input())->with('Success', 'Internal checks been executed succesfully');

                            }
                           // return redirect()->route('process-status');
                        } else {
                            //invalid bank information
                            $errorMessage = str_replace('/Error', '', $tempData5[2]);
                            $message = $errorMessage != null ? $errorMessage : 'AVS Failed, Please contact administrator';
                            AVS::where('FICA_id', $fica_id)->update(
                                array(
                                    'AVS_Status' => 0,
                                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                                    'ErrorMessage' => $message
                                )
                            );
                            //return redirect()->route('process-status')->withInput($request->input())->with('message', 'AVS Failure');
                            SelfBankingLink::where('Id', '=',  $sbid)->update(['BankingDetails'=>-2,'BankDocumentUpload'=>0]);
                                return redirect()->route('sb-preview-details')->withInput($request->input())->with('message', 'Internal checks are failed');
                        }
                    }
                }

        }

        return view('self-banking.preview-details')
            ->with('customer', $customer)
            ->with('selfbankinglinkdetails', $selfbankinglinkdetails);
    }


    public function processStatus(Request $request)
    {
        $sbid = $request->session()->get('sbid');
        $routename = SelfBankingLink::checkStep($sbid);
        if (Route::currentRouteName() != $routename) {
            return redirect()->route($routename);
        }
        $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica','selfBankingDetails.bankAccountType','selfBankingDetails.SBCompanySRN'])->where('Id',$sbid)->first(); 
        //print_r($selfbankinglinkdetails);exit;
        $fica_id = $selfbankinglinkdetails->selfBankingDetails->fica->FICA_id;
        $customer = Customer::getCustomerDetails($selfbankinglinkdetails->CustomerId);
        if ($sbid == '' || $sbid == null) {
            $url = '/';
            return response()->view('errors.401', ['message' => 'link has been expired', 'url' => $url], 401);
        }

        if($selfbankinglinkdetails->PersonalDetails == 1 && $selfbankinglinkdetails->DOVS == 1 && $selfbankinglinkdetails->BankingDetails == 1)
        {
            $success = "Your details have been verified and your account will be updated within 24 hours, followed by communication confirming that your account has been updated. Your reference for your application is your shareholder reference number(SRN) and today's date";
        }else{
            $success = "Your details have been partially verified and one of our agent will contact you within two working days. Your reference for your application is your shareholder reference number(SRN) and today's date";
        }

        return view('self-banking.process-status')
            ->with('customer', $customer)
            ->with('Success', $success)
            ->with('selfbankinglinkdetails', $selfbankinglinkdetails);
    }
}
