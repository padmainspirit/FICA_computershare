<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;


class AdminCreateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        // $Consumerid = $request->session()->get('LoggedUser');
        //$Consumerid =$client -> Id;
        // $client = CustomerUser::where('Id', '=', $Consumerid)->first();
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        // $Logo = $customer['Client_Logo'];
        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        // $GetAllUsers = CustomerUser::all();
        $GetAllCustomers = Customer::all();

        app('debugbar')->info($GetAllCustomers);

        return view('admin-display', [])

             ->with('customer', $customer)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }


    public function ShowConglomerateEdit(Request $request)
    {

        if (session()->has('success')) {
            session()->pull('success');
        }

        if (session()->has('fail')) {
            session()->pull('fail');
        }

        if (session()->has('getLoggedUsersID')) {
            session()->pull('getLoggedUsersID');
        }

        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId); //inspirit
        $UserFullName = $client->FirstName . ' ' . $client->LastName;


        $Logo = $customer->Client_Logo;
        $RegistrationName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;
        $GetAllCustomers = Customer::all();

        // $GetAllUsers = CustomerUser::all();
        $getCustomerId = $request->input('SelectClient');
        $GetAllConglomerateDetails = Customer::where('Id', '=', $getCustomerId)->first();  //computershare
        //dd($GetAllConglomerateDetails);

        $TradingName = $GetAllConglomerateDetails->TradingName != '' ? $GetAllConglomerateDetails->TradingName : null;
        $RegistrationName = $GetAllConglomerateDetails->RegistrationName != '' ? $GetAllConglomerateDetails->RegistrationName : null;
        $RegistrationNumber = $GetAllConglomerateDetails->RegistrationNumber != '' ? $GetAllConglomerateDetails->RegistrationNumber : null;
        $BranchLocation = $GetAllConglomerateDetails->BranchLocation != '' ? $GetAllConglomerateDetails->BranchLocation : null;
        $PhysicalAddress = $GetAllConglomerateDetails->PhysicalAddress != '' ? $GetAllConglomerateDetails->PhysicalAddress : null;
        $TypeOfBusiness = $GetAllConglomerateDetails->TypeOfBusiness != '' ? $GetAllConglomerateDetails->TypeOfBusiness : null;
        $TelephoneNumber = $GetAllConglomerateDetails->TelephoneNumber != '' ? $GetAllConglomerateDetails->TelephoneNumber : null;

        app('debugbar')->info($GetAllConglomerateDetails);
        return view('admin-conglomerate', [])

            ->with('UserFullName', $UserFullName)
            ->with('TradingName', $TradingName)
            ->with('RegistrationName', $RegistrationName)
            ->with('RegistrationNumber', $RegistrationNumber)
            ->with('BranchLocation', $BranchLocation)
            ->with('PhysicalAddress', $PhysicalAddress)
            ->with('TypeOfBusiness', $TypeOfBusiness)
            ->with('TelephoneNumber', $TelephoneNumber)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }


    public function EditDetails(Request $request)
    {

        $customerName = $request->RegistrationName;
        $GetAllConglomerateDetails = Customer::where('RegistrationName', '=', $customerName)->first();

        $Customerid = $GetAllConglomerateDetails->Id;
        $Logo = $GetAllConglomerateDetails['Client_Logo'];
        $customerName = $GetAllConglomerateDetails['RegistrationName'];
        $Icon = $GetAllConglomerateDetails['Client_Icon'];


        Customer::where('Id', '=', $Customerid)->update([

            'TradingName' => $request->input('TradingName'),
            'RegistrationName' => $request->input('RegistrationName'),
            'RegistrationNumber' => $request->input('RegistrationNumber'),
            'BranchLocation' => $request->input('BranchLocation'),
            'PhysicalAddress' => $request->input('PhysicalAddress'),
            'TypeOfBusiness' => $request->input('TypeOfBusiness'),
            'TelephoneNumber' => $request->input('TelephoneNumber'),

        ]);

        return redirect()->route('admin-display')
            ->with('success', 'User updated successfully')
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)
            ->with('Logo', $Logo);
    }

    public function ShowCustomerDisplay(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        $getCustomerUserSearchID = $request->input('SelectClient');

        $CustomerSearchID = CustomerUser::where('CustomerId', '=',  $getCustomerUserSearchID)->where('IsAdmin', '!=',  '2')->get();

        app('debugbar')->info($CustomerSearchID);

        return view('admin-client', [])

            ->with('CustomerSearchID', $CustomerSearchID)
            ->with('customerName', $customer->RegistrationName)
            ->with('UserFullName', $UserFullName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }

    public function ShowCustomerEdit(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $Logo = $customer->Client_Logo;
        $customerName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;

        $getLoggedUsersID = $request->input('SelectUser');

        $LoggedUsersID = CustomerUser::where('Id', '=',  $getLoggedUsersID)->first();
        // dd($LoggedUsersID->FirstName);

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
            ->with('UserFullName', $UserFullName)

            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = CustomerUser::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $customers = Customer::pluck('RegistrationName', 'Id');
        $userBelongsToCustomer = $user->CustomerId;
        return view('users.edit', compact('user', 'roles', 'userRole', 'customers', 'userBelongsToCustomer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $this->validate($request, [
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email|unique:customerusers,Email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]); */
        $this->validate($request, [
            'FirstName' => ['required', 'string', 'min:2', 'max:255'],
            'LastName' => ['required', 'string', 'min:2', 'max:255'],
            'IDNumber' => 'required|digits:13|unique:CustomerUsers,IDNumber,' . $id,
            'Email' => 'required|email|unique:CustomerUsers,Email,' . $id,
            'PhoneNumber' => 'required|string|unique:CustomerUsers,PhoneNumber,' . $id,
            'Password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
                "same:confirm-passkey"
            ],
            'confirm-passkey' => ['nullable', 'string', 'min:8'],
            'roles' => 'required'
        ], [
            'unique'        => 'The :attribute already been registered.',
            'IDNumber.required' => 'The ID number field is required.',
            'IDNumber.digits' => 'Please enter a valid 13 digit ID Number.',
            'Password.regex'   => 'The :attribute is invalid, password must contain at least one Uppercase, one Lower case, A number (0-9), Special Characters (!@#$%^&*) of least 8 Characters.',
        ]);

        $input = $request->all();
        if (!empty($input['Password'])) {
            $input['Password'] = Hash::make($input['Password']);
        } else {
            $input = Arr::except($input, array('Password'));
        }

        $user = CustomerUser::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        // $role = DB::table('roles')->where('name',$request['roles'])->first();
        // $assignrole = DB::table('model_has_roles')->insert(['role_id' => $role->id,'model_id'=>$id,'model_type'=>'App\Models\CustomerUser']);

        return redirect()->route('admin-display')
            ->with('success', 'User updated successfully');
    }

    public function ShowCustomerCreate(Request $request)
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        return view('admin-customer')
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }

    public function CreateCustomer(Request $request)
    {

        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $Logo = $customer->Client_Logo;
        $customerName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;

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

            'RegistrationName' => $request->RegistrationName,
        ]);
        // dd($newclient);
        $newclient->save();



        return view('admin-customer')
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }
}
