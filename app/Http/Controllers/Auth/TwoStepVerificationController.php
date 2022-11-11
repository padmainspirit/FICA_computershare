<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerUser;
use App\Models\Consumer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TwoStepVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    public function otp(Request $request)
    {
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);
        
        return view('auth.two-step-verification')
        ->with('customer', $customer);
    }

    public function dateDiffenceInMinutes($startDate, $endDate)
    {
        $startTime  = strtotime($startDate);
        $endTime = strtotime($endDate);
        $differenceInSeconds = $endTime - $startTime;
        $min = intval($differenceInSeconds / 60);
        return $min;
    }


    public function otpVerify(Request $request)
    {       

        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);
        $client = Auth::user();

        // dd($client);

        $consumer = Consumer::where('Email', '=', Auth::user()->Email)->where('CustomerUSERID', '=', Auth::user()->Id)->first();
        $minute = $this->dateDiffenceInMinutes(Auth::user()->OTP_Date, date("Y-m-d H:i:s"));
        //dd($client->OTP);

        // $optData = $request->input('digit1-input') . $request->input('digit2-input') . $request->input('digit3-input') . $request->input('digit4-input') . $request->input('digit5-input') . $request->input('digit6-input');
        $optData = $request->input('otp-input');
        if (Auth::user()->OTP == $optData && $minute <= 5) {
            app('debugbar')->info($consumer);
            app('debugbar')->info($client);
            //dd('Correct OTP');
            
            if ($consumer != null) {
                return redirect()->route('fica')->with('customerName', $customer->RegistrationName)
                ->with('customer', $customer);
            } 
            else {
                return redirect()->route('startfica')->with('customerName', $customer->RegistrationName)
                ->with('customer', $customer);
            }
        } else {
            return back()->with('fail', 'Incorrect Code, please try again');
            //dd('Incorrect OTP');
        }


        $this->validate($request, [
            'otp' => 'required',
        ]);
    }

    public function reSendOTP(Request $request)
    {
        
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);
        $client = Auth::user();

        $Email = Auth::user()->Email;
       

        $client = CustomerUser::where('Email', '=', $Email)->where('CustomerId', '=', $Customerid)->first();
        // dd($client);
        $otp = new SmsOtpController();
        $sendotp = $otp->sendOTP($client->PhoneNumber);

        


        // $TradingName = $request->session()->get('TradingName');
        // $Icon = $request->session()->get('Icon');
        $YearNow = Carbon::now()->year;
        // app('debugbar')->info($customer);
        // app('debugbar')->info($Logo);
        // app('debugbar')->info($CustomerId);

        /* Mail::send(
            'auth.emailotp',
            ['otp' => $sendotp, 'Logo' => $Logo, 'TradingName' => $TradingName, 'YearNow' => $YearNow],
            function ($message) use ($request) {
                $message->to($request->session()->get('Email'));
                $message->subject('OTP Verification');
            }
        );*/
        DB::table('CustomerUsers')->where('Id', $client->Id)->update(['OTP' => $sendotp]);
        DB::table('CustomerUsers')->where('Id', $client->Id)->update(['OTP_Date' => date("Y-m-d H:i:s")]);

        app('debugbar')->info($request);
        return redirect()->route('otp');
    }
}
