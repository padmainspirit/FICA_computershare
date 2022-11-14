<?php

namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerUser;
use Illuminate\Support\Facades\Hash;
use  App\Http\Controllers\Auth\SmsOtpController;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;




class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'Email';
    }


    /* Function to render login screen */
    public function index(Request $request)
    {   
        $this->guard()->logout();
        $customer = Customer::getCustomerDetailsByUrl();        
        return view('auth.login', ['customer' => $customer]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);

        //$is_role = Auth::user()->getRoleNames();
        $getRoleName = CustomerUser::getCustomerUserRoleName(); 
            if($getRoleName){ 
                if($getRoleName == 'SuperAdmin' || $getRoleName == 'CustomerAdmin'){
                    return redirect('/admin-dashboard');
                    //return redirect('/home');
                }else{
                    $otp = new SmsOtpController();
                    $sendotp = $otp->sendOTP($client->PhoneNumber, $customer->RegistrationName);

                    DB::table('CustomerUsers')
                        ->where('Id', $client->Id)
                        ->update([
                            'OTP' => $sendotp,
                            'OTP_Date' => date("Y-m-d H:i:s")
                        ]);

                    // Mail::send(
                    //     'auth.emailotp',
                    //     ['otp' => $sendotp, 'Logo' => $Logo, 'TradingName' => $TradingName, 'YearNow' => $YearNow],
                    //     function ($message) use ($request) {
                    //         $message->to($request->session()->get('Email'));
                    //         $message->subject('OTP Verification');
                    //     }
                    // );


                    return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended('otp');

                }
            }else{
                $this->guard()->logout();
                return back()->with('fail', 'Role has not been assigned to the user. You account will be activated soon');
            }


        /* return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath()); */
    }


    public function login(Request $request)
    {        
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
