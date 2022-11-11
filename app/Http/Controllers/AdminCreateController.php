<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminCreateController extends Controller
{
    public function index(Request $request)
    {
        $Consumerid = $request->session()->get('LoggedUser');
        $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $request->session()->put('UserFullName', $client->FirstName . ' ' . $client->LastName);

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        // $GetAllUsers = CustomerUser::all();
        $GetAllCustomers = Customer::all();

        app('debugbar')->info($GetAllCustomers);

        return view('admin-display', [])
        
        // ->with('GetAllUsers', $GetAllUsers)
        ->with('GetAllCustomers', $GetAllCustomers)
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function ShowCustomerDisplay(Request $request)
    {
        $Consumerid = $request->session()->get('LoggedUser');
        $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $request->session()->put('UserFullName', $client->FirstName . ' ' . $client->LastName);

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        $getCustomerUserSearchID = $request->input('SelectClient');

        $CustomerSearchID = CustomerUser::where('CustomerId', '=',  $getCustomerUserSearchID)->where('IsAdmin', '=',  '0')->get();

        app('debugbar')->info($CustomerSearchID);

        return view('admin-client', [])

        ->with('CustomerSearchID', $CustomerSearchID)
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function ShowCustomerEdit(Request $request)
    {
        $Consumerid = $request->session()->get('LoggedUser');
        $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $request->session()->put('UserFullName', $client->FirstName . ' ' . $client->LastName);

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        $getLoggedUsersID = $request->input('SelectUser');

        $LoggedUsersID = CustomerUser::where('Id', '=',  $getLoggedUsersID)->first();

        $FirstName = $LoggedUsersID->FirstName != '' ? $LoggedUsersID->FirstName : null;
        $LastName = $LoggedUsersID->LastName != '' ? $LoggedUsersID->LastName : null;
        $IDNumber = $LoggedUsersID->IDNumber != '' ? $LoggedUsersID->IDNumber : null;
        $Email = $LoggedUsersID->Email != '' ? $LoggedUsersID->Email : null;
        $Password = $LoggedUsersID->Password != '' ? $LoggedUsersID->Password : null;
        $PhoneNumber = $LoggedUsersID->PhoneNumber != '' ? $LoggedUsersID->PhoneNumber : null;
        $IsRestricted = $LoggedUsersID->IsRestricted != '' ? $LoggedUsersID->IsRestricted : null;
        $OTP = $LoggedUsersID->OTP != '' ? $LoggedUsersID->OTP : null;

        return view('admin-edit', [])

        ->with('FirstName', $FirstName)
        ->with('LastName', $LastName)
        ->with('IDNumber', $IDNumber)
        ->with('Email', $Email)
        ->with('Password', $Password)
        ->with('PhoneNumber', $PhoneNumber)
        ->with('IsRestricted', $IsRestricted)
        ->with('OTP', $OTP)

        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function ShowCustomerCreate(Request $request)
    {
        $Consumerid = $request->session()->get('LoggedUser');
        $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $request->session()->put('UserFullName', $client->FirstName . ' ' . $client->LastName);

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        return view('admin-customer')
        
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function CreateCustomer(Request $request)
    {
        $Consumerid = $request->session()->get('LoggedUser');
        $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $request->session()->put('UserFullName', $client->FirstName . ' ' . $client->LastName);

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];
        
        $newclient = Customer::create([
            'Id' =>  Str::upper(Str::uuid()),
            'TradingName' => $request->TradingName,
            'RegistrationName' => $request->RegistrationName,
            'RegistrationNumber' => $request->RegistrationNumber,
            'VATNumber' => $request->VATNumber,
            'BranchLocation' => $request->BranchLocation,
            'PhysicalAddress' => $request->PhysicalAddress,
            'TypeOfBusiness' => $request->TypeOfBusiness,
            'TelephoneNumber' => $request->TelephoneNumber,

            'FaxNumber' => NULL,
            'BillingEmail' => NULL,
            'Status' => NULL,
            'BillingType' => NULL,
            'Code' => NULL,
            'Turnover' => NULL,
            'CustOwnIDNumber' => NULL,
            'PostalAddress' => NULL,
            'WebAddress' => NULL,
            'AccountDeptContactPerson' => NULL,
            'AccountDeptTelephoneNumber' => NULL,
            'AccountDeptFaxNumber' => NULL,
            'AuthIDNumber' => NULL,
            'AuthPosition' => NULL,
            'AccountDeptEmail' => NULL,
            'AuthFirstName' => NULL,
            'AuthSurName' => NULL,
            'AuthCellNumber' => NULL,
            'AuthEmail' => NULL,
            'BusinessDescription' => NULL,
            'CreditBureauInformation' => NULL,
            'Purpose' => NULL,
            'CreatedDate' => date("Y-m-d H:i:s"),
            'CreatedBy' => date("Y-m-d H:i:s"),
            'ModifiedDate' => date("Y-m-d H:i:s"),
            'ModifiedBy' => date("Y-m-d H:i:s"),
            'ActivatedBy' => date("Y-m-d H:i:s"),
            'ActivatedDate' => date("Y-m-d H:i:s"),
            'TabSelected' => NULL,
            'IsRestricted' => NULL,
            'Customer_URL' => NULL,
            'Inspirit_Logo' => NULL,
            'Client_Logo' => NULL,
            'Client_Font_Code' => NULL,
            'Customer_Email' => NULL,
            'Client_Icon' => NULL,

            'Customer_Name' => $request->RegistrationName,
        ]);

        $newclient->save();
        
        return view('admin-customer')
        
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }
    

}
