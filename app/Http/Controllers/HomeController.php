<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($customerName)
    {

        // print_r($customerName);

        return view('home');
        // $customer = Customer::getCustomerDetailsByUrl(); 
        // // dd($customer );
        // $Client_Logo = $customer->Client_Logo;
        // $RegistrationName = $customer->RegistrationName;
        // return view('home', ['customer' => $customer, 'Client_Logo' => $Client_Logo, 'RegistrationName' =>$RegistrationName]);
    }
}
