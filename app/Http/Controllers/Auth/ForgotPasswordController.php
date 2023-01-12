<?php
#app\Http\Controllers\Auth\ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;


class ForgotPasswordController extends Controller
{

    public function ForgetPassword(Request $request)
    {
        $message = '';

        //$Customerid = $request->session()->get('Customerid');
        $customer = Customer::getCustomerDetailsByUrl();

        return view('auth.forget-password')->with('message', $message)
            ->with('customer', $customer);
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $customer = Customer::getCustomerDetailsByUrl();
        $request->validate([
            'Email' => 'required|email|exists:CustomerUsers',
        ]);

        //$userexsists = $user['Email'];

        $client = new Client;
        $token = $request->input('g-recaptcha-response-forget');

        $YearNow = Carbon::now()->year;

        $user = CustomerUser::where('Email', '=', $request->Email)->first();

        $ForgetEmail = $request->Email;
        $request->session()->put('ForgetEmail', $ForgetEmail);

        // dd($Email);

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                [
                    'secret' => '6LcWWaQhAAAAAID-WVERnHfeVgvy5A3LIvmle0bg',
                    'response' => $token
                ]
            ]
        );
        $responseData = json_decode((string)$response->getBody());

        //dd($responseData);
        //Check if user in not a robot using Recaptcha
        //$responseData->score = 0.4;
        if ($responseData->score < 0.5) {
            $message = 'Please contact Administrator';
            return back()->with('message', $message)
                ->with('customer', $customer);
        }


        if ($user != null) {
            $Customerid = $user->CustomerId;
            $customer = Customer::getCustomerDetails($Customerid);
            if ($request->Email == $ForgetEmail) {
                $token = Str::random(16);
                // Db::table('password_resets')->insert([
                //     'Email' => $request->Email, 
                //     'token' => $token, 
                //     'created_at' => Carbon::now()
                //   ]);

                Mail::send('auth.email', ['token' => $token, 'Logo' => $customer->Client_Logo, 'YearNow' => $YearNow, 'TradingName' => $customer->TradingName], function ($message) use ($request) {
                    $message->to($request->Email);
                    $message->subject('Reset Password');
                });

                $message = 'We have e-mailed your password reset link.';
                //$request->session()->put('message', $message);
                return view('auth.forget-password')->with('message', $message)->with('customer', $customer);
            } else {
                $message = 'No registered user found.';
                //$request->session()->put('message', $message);
                return view('auth.forget-password')->with('message', $message)->with('customer', $customer);
            }
        } else {
            $message = 'No registered user found.';
            //$request->session()->put('message', $message);
            return view('auth.forget-password')->with('message', $message)->with('customer', $customer);
        }
    }

    public function ResetPassword(Request $request, $token)
    {

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        // $Logo = $customer['Client_Logo'];

        // app('debugbar')->info($customer);
        $message = '';
        $ForgetEmail = $request->session()->get('ForgetEmail');

        if ($ForgetEmail != null) {
            $getCustomerid = CustomerUser::where('Email', '=', $ForgetEmail)->first();
            $Customerid = $getCustomerid->CustomerId;
        }else{
            return view('auth.forget-password')->with($message, 'No registered user found.');
        }

        // dd($Customerid);

        // $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        // dd($customer);

        return view('auth.reset-password', ['token' => $token])->with('message', $message)
            ->with('ForgetEmail', $ForgetEmail)
            ->with('customerName', $customerName)
            ->with('Logo', $Logo)
            ->with('Icon', $Icon);
        // return view('.$token', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        //dd($request);

        // $request->validate([
        //     'Email' => ['required'],
        //     'Password' => ['required', 'confirmed'],
        //     'Password_confirmation' => ['required'],
        // ]);

        $message = '';
        $client = new Client;
        $token = $request->input('g-recaptcha-response-reset');

        $Email = $request->session()->get('Email');
        $ForgetEmail = $request->session()->get('ForgetEmail');

        if ($ForgetEmail != null) {
            $getCustomerid = CustomerUser::where('Email', '=', $ForgetEmail)->first();
            $Customerid = $getCustomerid->CustomerId;
        }else{
            return view('auth.forget-password')->with($message, 'No registered user found.');
        }

        // $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        //dd($token);

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                [
                    'secret' => '6LcWWaQhAAAAAID-WVERnHfeVgvy5A3LIvmle0bg',
                    'response' => $token
                ]
            ]
        );
        $responseData = json_decode((string)$response->getBody());

        //dd($responseData);
        //Check if user in not a robot using Recaptcha
        //$responseData->score = 0.4;
        if ($responseData->score < 0.5) {
            $message = 'Please contact Administrator';
            return back()->with('fail', 'Please contact Administrator');
        }


        $user = CustomerUser::where('Email', '=', $request->Email)->where('CustomerId', '=', $Customerid)->first();

        if ($user != null) {
            if ($request->Email == $user->Email) {
                $token = Str::random(16);
                // Db::table('password_resets')->insert([
                //     'Email' => $request->Email, 
                //     'token' => $token, 
                //     'created_at' => Carbon::now()
                //   ]);

                DB::table('CustomerUsers')->where('Email', $user->Email)->update(['Password' => Hash::make($request->Password)]);

                $message = 'Password has been successfully changed. Please go and sign in with your new password.';
                return back()->with('success', 'Password has been successfully changed.')->with('Logo', $Logo)->with('Icon', $Icon)->with('Email', $Email);
                // return view('auth.login')->with('fail', $message);
            } else {
                $message = 'No registered user found.';
                // $request->session()->put('message', "No registered user found");
                return back()->with('fail', 'No user has been found, please contact an Administrator or register an account')->with('Logo', $Logo)->with('Icon', $Icon)->with('Email', $Email);
            }
        } else {
            $message = 'No registered user found.';
            // $request->session()->put('message', "No registered user found");
            return back()->with('fail', 'No user has been found, please contact an Administrator or register an account')->with('Logo', $Logo)->with('Icon', $Icon)->with('Email', $Email);
        }

        return redirect('login')->with('Logo', $Logo)->with('Icon', $Icon);
    }
}
