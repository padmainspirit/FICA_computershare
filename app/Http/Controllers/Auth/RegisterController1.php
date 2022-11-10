<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Str;

use App\Models\CustomerUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:CustomerUsers'],
            'password' => ['required', 'string', 'min:9', 'confirmed'],
        ]);
    }


    public function index(Request $request)
    {
        $currentURL =  \URL::full();
        $customerName = substr($currentURL, (strpos($currentURL, '=') ?: -1) + 1);
        $customer = Customer::getCustomerDetailsByName($customerName);        

        $old = [
            'first' => $request->FirstName != '' ? $request->FirstName : null,
            'last' => $request->LastName != '' ? $request->LastName : null,
            'idnum' => $request->IDNumber != '' ? $request->IDNumber : null,
            'mail' => $request->Email != '' ? $request->Email : null,
            'phone' => $request->PhoneNumber != '' ? $request->PhoneNumber : null,
        ];

        return view('auth.register', ['customer' => $customer])
            ->with($old);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        return CustomerUser::create([
            //'Id' =>  Str::upper(Str::uuid()),
            'FirstName' => $data['name'],
            'LastName' => $data['name'],
            'Email' => $data['email'],
            'PhoneNumber' => rand(),                
            'Password' => Hash::make($data['password']),
            'IDNumber' => rand(),
            'IsAdmin' => 0,
            'Status' => NULL,
            'CustomerId' => '47B97C4A-E9F6-4283-BDB5-D500CA8851C1',
            'Code' => NULL,
            'SubscriptionId' => NULL,
            'Message' => NULL,
            'CreatedDate' =>  date("Y-m-d H:i:s"),
            'CreatedBy' => NULL,
            'ModifiedDate' => date("Y-m-d H:i:s"),
            'ModifiedBy' => NULL,
            'ActivatedBy' => NULL,
            'IsUserLoggedIn' => 1,
            'IsRestricted' => 0,
            'LastPasswordResetDate' =>  date("Y-m-d H:i:s"),
            'ActivatedDate' => date("Y-m-d H:i:s"),
            'LastLoginDate' =>  date("Y-m-d H:i:s"),
        ]);

        $currentURL =  \URL::full();
        $customerName = substr($currentURL, (strpos($currentURL, '=') ?: -1) + 1);
        $customer = Customer::getCustomerDetailsByName($customerName);
        return redirect()->route('login', ['customer' => $customer]);
    }
}
