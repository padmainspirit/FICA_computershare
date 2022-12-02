<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use App\Models\FAQData;
use Illuminate\Support\Facades\Auth;


class FAQ extends Controller
{
        public function ShowPage(Request $request)
        {
                $client = Auth::user();
                $Customerid = $client->CustomerId;
                $customer = Customer::where('Id', '=',  $Customerid)->first();

                // dd($customer);
                // $Icon = $customer->Client_Icon;
                // $Logo = $customer->Client_Logo;
                // $RegistrationName = $customer->RegistrationName;

                // $LogUserName  = $client->FirstName;
                // $LogUserSurname = $client->LastName;
                $NotificationLink = $request->session()->get('NotificationLink');
                // $Customerid = $request->session()->get('Customerid');

                $Questions = FAQData::where('Customerid', '=', $Customerid)->get();

                // $Customerid = session()->get('Customerid');

                app('debugbar')->info($customer);

                return view('FAQ', [])

                        ->with('Questions', $Questions)

                        ->with('NotificationLink', $NotificationLink)
                        ->with('customer', $customer)
                        ->with('LogUserName', $client->FirstName)
                        ->with('LogUserSurname', $client->LastName)
                        ->with('RegistrationName', $customer->RegistrationName)
                        ->with('Icon', $customer->Client_Icon)
                        ->with('Logo', $customer->Client_Logo);
        }
}
