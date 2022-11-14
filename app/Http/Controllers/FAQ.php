<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use App\Models\FAQData;


class FAQ extends Controller
{
    public function ShowPage(Request $request)
    {

        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');
        $NotificationLink = $request->session()->get('NotificationLink');
        $Customerid = $request->session()->get('Customerid');

        $Questions = FAQData::where('Customerid', '=', $Customerid)->get();

        $Customerid = session()->get('Customerid');

        $customerBrand = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customerBrand['Client_Logo'];
        $Icon = $customerBrand['Client_Icon'];
        $customerName = $customerBrand['RegistrationName'];

        app('debugbar')->info($customerBrand);

        return view('FAQ', [])

        ->with('Questions', $Questions)
        
        ->with('NotificationLink', $NotificationLink)
        ->with('LogUserName', $LogUserName)
        ->with('LogUserSurname', $LogUserSurname)
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }
}
