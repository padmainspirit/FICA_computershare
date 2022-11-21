<?php

namespace App\Http\Controllers\Auth;

use App\Models\CustomerUser;
use App\Models\ConsumerIdentity;
use App\Models\Banks;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
        // $Bank = Banks::where('Bankid', '=', '4')->first();
        // dd($Bank);
    }


    /**  index function to render registration form with customer details*/
    public function index(Request $request)
    {
        $customer = Customer::getCustomerDetailsByUrl();
        return view('auth.register', ['customer' => $customer]);
    }


    /* Registration function with each field validation
    * customised validation messages 
    * save the customer and trigger a mail*/
    public function register(Request $request)
    {
        $customer = Customer::getCustomerDetailsByUrl();
        $YearNow = Carbon::now()->year;

        $this->validate($request, [
            'FirstName' => ['required', 'string', 'min:2', 'max:255'],
            'LastName' => ['required', 'string', 'min:2', 'max:255'],
            'IDNumber' => 'required|digits:13|unique:CustomerUsers',
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:CustomerUsers'],
            'PhoneNumber' => ['required', 'string', 'max:255', 'unique:CustomerUsers'],
            'Password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
            'confirm-passkey' => ['required', 'string', 'min:8', 'same:Password'],
        ], [
            'unique'        => 'The :attribute already been registered.',
            'IDNumber.required' => 'The ID number field is required.',
            'IDNumber.digits' => 'Please enter a valid 13 digit ID Number.',
            'Password.regex'   => 'The :attribute is invalid, password must contain at least one Uppercase, one Lower case, A number (0-9), Special Characters (!@#$%^&*) of least 8 Characters.',
        ]);


        $isUserExist = false;
        $token = $request->input('g-recaptcha-response');

        $client = new Client;
        //verify user that is not a robot
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

        $scoreResponse = $responseData->score;
        //Check if user in not a robot using Recaptcha
        //$responseData->score = 0.4;
        // dd($responseData);
        if ($scoreResponse < 0.5) {
            // dd($responseData);
            return back()->with('fail', 'Please contact Administrator')->with('customer', $customer);
        }

        $request['Password'] = Hash::make($request['Password']);
        $request['IsAdmin'] = 0;
        $request['CustomerId'] = $customer->Id;
        $request['CreatedDate'] = date("Y-m-d H:i:s");
        $request['IsUserLoggedIn'] = 0;

        $request['IsRestricted'] = 0;

        try {
            $user = CustomerUser::create($request->all());
            //CustomerUser::assignRoleWithId(env('CUSTOMER_USER_ROLE_ID'), $user->Id); //CustomerUser role id to be assigned for registered user
            CustomerUser::assignRoleWithId(config('app.CUSTOMER_USER_ROLE_ID'), $user->Id);
            $token = Str::random(16);
            $FirstName = $request->FirstName;
            $LastName = $request->LastName;
            $Email = $request->Email;
            $Password = $request->Password;

            /* Mail::send(
                'auth.emailreg',
                [
                    'token' => $token, 'FirstName' => $FirstName, 'LastName' => $LastName, 'Email' => $Email,
                    'Password' => $Password, 'Logo' => $Logo, 'TradingName' => $TradingName, 'YearNow' => $YearNow
                ],
                function ($message) use ($request) {
                    $message->to($request->Email);
                    $message->subject('New Registered User');
                }
            ); */
        } catch (\Exception $e) {
            print_r($e->getMessage());
            exit;
        }


        return redirect()->route('login', ['customer' => $customer->RegistrationName]);
    }
}
