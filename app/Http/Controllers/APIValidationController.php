<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserVerificationController;
use Illuminate\Support\Facades\DB;

use App\Models\Consumer;
use App\Models\CustomerUser;
use App\Models\FICA;
use App\Models\Address;
use App\Models\BankAccountType;
use App\Models\ConsumerIdentity;
use App\Models\AVS;
use App\Models\KYC;
use App\Models\DOVS;
use App\Models\Compliance;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class APIValidationController extends Controller
{
    public function validateAPIs(Request $request)
    {
        // try {
        // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();

        //APIs
        $consumerIdentity = ConsumerIdentity::where('FICA_id', '=',  $fica->FICA_id)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $kyc = KYC::where('FICA_id', '=',  $fica->FICA_id)->first();
        $dovs = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $comply = Compliance::where('FICA_id', '=',  $fica->FICA_id)->first();

        //Run All API's
        if ($kyc->KYC_Status != 2 && $avs->AVS_Status != 2 && $comply->Compliance_Status != 2) {
            $this->validateKYCAPI($request);
            $this->validateAVSPI($request, 1);
            $this->validateCOMPLIENCEAPI($request);
        }

        //Run KYC API 
        if ($kyc->KYC_Status == 2) {
            $this->validateKYCAPI($request);
        }

        //Run AVS API 
        if ($avs->AVS_Status == 2) {
            $this->validateAVSPI($request, 1);
        }

        //Run Compliance API 
        if ($comply->Compliance_Status == 2) {
            $this->validateCOMPLIENCEAPI($request);
        }

        //APIs
        $consumerIdentity2 = ConsumerIdentity::where('FICA_id', '=',  $fica->FICA_id)->first();
        $avs2 = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $kyc2 = KYC::where('FICA_id', '=',  $fica->FICA_id)->first();
        $dovs2 = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $comply2 = Compliance::where('FICA_id', '=',  $fica->FICA_id)->first();

        if (isset($fica) && isset($kyc) && isset($avs) && isset($dovs) && isset($comply)) {
            $APIResultStatus = ([
                'IDAS_Status' => isset($consumerIdentity2->Identity_status) ?  (int)$consumerIdentity2->Identity_status : 0,
                'KYC_Status' => isset($kyc2->KYC_Status) ? (int)$kyc2->KYC_Status : 0,
                'AVS_Status' => isset($avs2->AVS_Status) ? (int)$avs2->AVS_Status : 0,
                'DOVS_Status' => isset($dovs2->DOVS_Status) ? (int)$dovs2->DOVS_Status : 0,
                'Compliance_Status' => isset($comply2->Compliance_Status) ? (int) $comply2->Compliance_Status : 0
            ]);

            //increment Fica Progress if validation passed
            $ficaProgress = 0;

            if ($APIResultStatus['IDAS_Status'] == 1 && $APIResultStatus['KYC_Status'] == 1 && $APIResultStatus['AVS_Status'] == 1 && $APIResultStatus['DOVS_Status'] == 1 && $APIResultStatus['Compliance_Status'] == 1) {
                $ficaProgress =  $fica->FICAProgress + 1;
            }
            if ($APIResultStatus['IDAS_Status'] == 2 || $APIResultStatus['KYC_Status'] == 2  ||  $APIResultStatus['AVS_Status'] == 2 || $APIResultStatus['DOVS_Status'] == 2 || $APIResultStatus['Compliance_Status'] == 2) {
                $ficaProgress =  $fica->FICAProgress + 1;
            }
            if ($APIResultStatus['IDAS_Status'] == 0 || $APIResultStatus['KYC_Status'] == 0  ||  $APIResultStatus['AVS_Status'] == 0 || $APIResultStatus['DOVS_Status'] == 0 || $APIResultStatus['Compliance_Status'] == 0) {
                $ficaProgress =  $fica->FICAProgress;
            }

            $ficaSTATUS  = ($ficaProgress == 10) ? 'Completed' : $fica->FICAStatus;
            if ($fica->Validation_Status == null) {
                FICA::where('Consumerid', $consumer->Consumerid)->update(
                    array(
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                        'FICAProgress' =>  $ficaProgress,
                        'FICAStatus' =>  $ficaSTATUS,
                        'Validation_Status' => date("Y-m-d H:i:s"),
                        'Correction_Status' => null
                    )
                );
            }

            //If one of the API failed, change the FICAStatus to Failed
            if ((int)$consumerIdentity2->Identity_status == 0 || (int)$kyc2->KYC_Status == 0 || (int)$avs2->AVS_Status  == 0  || (int)$dovs2->DOVS_Status == 0  ||  (int)$comply2->Compliance_Status == 0) {
                FICA::where('Consumerid', $consumer->Consumerid)->update(
                    array(
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                        'FICAStatus' =>  'Failed',
                        'FailedDate' => date("Y-m-d H:i:s"),
                    )
                );

                $YearNow = Carbon::now()->year;
                Mail::send('auth.emailfail', ['FirstName' => $customer->FirstName, 'YearNow' => $YearNow],
                function ($message) {
                        $client = Auth::user();
                        $message->to($client->Email);
                        $message->subject('FICA Status');
                    }
                );
            }

            //Risk Calculator
            DB::connection("sqlsrv2")->statement(DB::raw("SET NOCOUNT ON; exec SP_Risk_Calculator :consumerid"), [
                ':consumerid' =>  $fica->Consumerid
            ]);

            $response = ['data' =>  $APIResultStatus];
            return $response;
        }

        return back()->withSuccess('API Ran Successfully');
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }
    }
    public function validateKYCAPI(Request $request)
    {
        $validate = new UserVerificationController();
        $validate->verifyClientKYC($request);
    }
    public function validateAVSPI(Request $request, $i = null)
    {
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        if($i <= 2){
            $validate = new UserVerificationController();
            $validate->verifyClientBankAccount($request);
            $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
            if($avs['AVS_Status']!= 1){
                $i++;
                $this->validateAVSPI($request, $i);
            }
        }
        
    }
    public function validateCOMPLIENCEAPI(Request $request)
    {
        $validate = new UserVerificationController();
        $validate->verifyClientCompliance($request);
    }
}
