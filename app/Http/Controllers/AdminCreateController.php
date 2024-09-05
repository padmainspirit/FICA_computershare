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
use App\Models\CustomerTabs;
use App\Models\CustomerHasTabs;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

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


        // $Logo = $customer->Client_Logo;
        $RegistrationName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;
        $GetAllCustomers = Customer::all();

        // $GetAllUsers = CustomerUser::all();
        $getCustomerId = $request->input('SelectClient');
        $GetAllConglomerateDetails = Customer::where('Id', '=', $getCustomerId)->first();  //computershare

        $TradingName = $GetAllConglomerateDetails->TradingName != '' ? $GetAllConglomerateDetails->TradingName : null;
        $RegistrationName = $GetAllConglomerateDetails->RegistrationName != '' ? $GetAllConglomerateDetails->RegistrationName : null;
        $RegistrationNumber = $GetAllConglomerateDetails->RegistrationNumber != '' ? $GetAllConglomerateDetails->RegistrationNumber : null;
        $BranchLocation = $GetAllConglomerateDetails->BranchLocation != '' ? $GetAllConglomerateDetails->BranchLocation : null;
        $PhysicalAddress = $GetAllConglomerateDetails->PhysicalAddress != '' ? $GetAllConglomerateDetails->PhysicalAddress : null;
        $TypeOfBusiness = $GetAllConglomerateDetails->TypeOfBusiness != '' ? $GetAllConglomerateDetails->TypeOfBusiness : null;
        $TelephoneNumber = $GetAllConglomerateDetails->TelephoneNumber != '' ? $GetAllConglomerateDetails->TelephoneNumber : null;
        $VATnumber = $GetAllConglomerateDetails->VATNumber;
        $fontcode = $GetAllConglomerateDetails->Client_Font_Code;

        $tabs =  CustomerTabs::all('Id','Name');
        $customerTabs = DB::table("customer_has_tabs")->where("customer_has_tabs.CustomerId", $getCustomerId)
        ->pluck('customer_has_tabs.TabId', 'customer_has_tabs.TabId')
        ->all();

        app('debugbar')->info($GetAllConglomerateDetails);
        return view('admin-conglomerate', compact('tabs','customerTabs'))

            ->with('UserFullName', $UserFullName)
            ->with('TradingName', $TradingName)
            ->with('RegistrationName', $RegistrationName)
            ->with('CustomerId', $getCustomerId)
            ->with('RegistrationNumber', $RegistrationNumber)
            ->with('VATnumber', $VATnumber)
            ->with('BranchLocation', $BranchLocation)
            ->with('PhysicalAddress', $PhysicalAddress)
            ->with('TypeOfBusiness', $TypeOfBusiness)
            ->with('TelephoneNumber', $TelephoneNumber)
            ->with('fontcode', $fontcode)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $GetAllConglomerateDetails->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $GetAllConglomerateDetails->Client_Logo);
    }

    public function EditDetails(Request $request)
    {
        // $this->validate($request, [
        //     'fontcode'=> ['required','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        //     'Client_logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        //     'Client_icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp'
        // ]);

        $customerId = $request->CustomerId;
        $GetAllConglomerateDetails = Customer::where('Id', '=', $customerId)->first();

        $Customerid = $GetAllConglomerateDetails->Id;
        $Logo = $GetAllConglomerateDetails['Client_Logo'];
        $customerName = $GetAllConglomerateDetails['RegistrationName'];
        $Icon = $GetAllConglomerateDetails['Client_Icon'];


        if($request->file('Client_logo') || $request->file('Client_icon')){

            $logoIconPath = 'assets/logo';
            if (!File::isDirectory($logoIconPath)) {
                File::makeDirectory($logoIconPath, 0777, true, true);
            }
            $customerLogoIconPath = $logoIconPath.'/'.$Customerid;
            if (!File::isDirectory($customerLogoIconPath)) {
                File::makeDirectory($customerLogoIconPath, 0777, true, true);
            }

            if($request->file('Client_logo')){
                if($Logo){
                unlink('assets/logo/'.$Customerid.'/'.$GetAllConglomerateDetails->Client_Logo);
                }
                $Logo = random_int(1000, 9999).$request->Client_logo->getClientOriginalName();
                $request->Client_logo->move(public_path($customerLogoIconPath), $Logo);
            }

            if($request->file('Client_icon')){
                if($Icon){
                unlink('assets/logo/'.$Customerid.'/'.$GetAllConglomerateDetails->Client_Icon);
                }
                $Icon = random_int(1000, 9999).$request->Client_icon->getClientOriginalName();
                $request->Client_icon->move(public_path($customerLogoIconPath), $Icon);
            }
        }


        Customer::where('Id', '=', $Customerid)->update([

            'TradingName' => $request->input('TradingName'),
            'RegistrationName' => $request->input('RegistrationName'),
            'RegistrationNumber' => $request->input('RegistrationNumber'),
            'BranchLocation' => $request->input('BranchLocation'),
            'PhysicalAddress' => $request->input('PhysicalAddress'),
            'TypeOfBusiness' => $request->input('TypeOfBusiness'),
            'TelephoneNumber' => $request->input('TelephoneNumber'),
            'Client_logo' => $Logo,
            'Client_Icon' => $Icon,

        ]);

        $newtabs = [];

        if(!empty($request->input('tab'))){
            DB::table('customer_has_tabs')->where('CustomerId',$Customerid)->delete();
            $tab = [];
            foreach ($request->input('tab') as $key => $value) {
                $tab['CustomerId'] = $Customerid;
                $tab['TabId'] = $value;
                $newtabs[]=$tab;
            }
            CustomerHasTabs::insert($newtabs);
        }


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

    // public function ShowCustomerEdit(Request $request)
    // {
    //     $client = Auth::user();
    //     $customer = Customer::getCustomerDetails($client->CustomerId);
    //     $UserFullName = $client->FirstName . ' ' . $client->LastName;

    //     $Logo = $customer->Client_Logo;
    //     $customerName = $customer->RegistrationName;
    //     $Icon = $customer->Client_Icon;

    //     $getLoggedUsersID = $request->input('SelectUser');

    //     $LoggedUsersID = CustomerUser::where('Id', '=',  $getLoggedUsersID)->first();

    //     $FirstName = $LoggedUsersID->FirstName != '' ? $LoggedUsersID->FirstName : null;
    //     $LastName = $LoggedUsersID->LastName != '' ? $LoggedUsersID->LastName : null;
    //     $IDNumber = $LoggedUsersID->IDNumber != '' ? $LoggedUsersID->IDNumber : null;
    //     $Email = $LoggedUsersID->Email != '' ? $LoggedUsersID->Email : null;
    //     $Password = $LoggedUsersID->Password != '' ? $LoggedUsersID->Password : null;
    //     $PhoneNumber = $LoggedUsersID->PhoneNumber != '' ? $LoggedUsersID->PhoneNumber : null;
    //     $IsRestricted = $LoggedUsersID->IsRestricted != '' ? $LoggedUsersID->IsRestricted : null;
    //     $OTP = $LoggedUsersID->OTP != '' ? $LoggedUsersID->OTP : null;

    //     return view('admin-edit', [])

    //         ->with('FirstName', $FirstName)
    //         ->with('LastName', $LastName)
    //         ->with('IDNumber', $IDNumber)
    //         ->with('Email', $Email)
    //         ->with('Password', $Password)
    //         ->with('PhoneNumber', $PhoneNumber)
    //         ->with('IsRestricted', $IsRestricted)
    //         ->with('OTP', $OTP)
    //         ->with('UserFullName', $UserFullName)

    //         ->with('customerName', $customer->RegistrationName)
    //         ->with('Icon', $customer->Client_Icon)
    //         ->with('customer', $customer)
    //         ->with('Logo', $customer->Client_Logo);
    // }

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
        $tabs =  CustomerTabs::all('Id','Name');

        return view('admin-customer', compact('tabs'))
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }

    public function CreateCustomer(Request $request)
    {

        $this->validate(
            $request,
            [
                'TradingName' => ['required', 'string', 'unique:Customers', 'max:255'],
                'RegistrationName' => ['required', 'string', 'unique:Customers', 'max:255'],
                'RegistrationNumber' => ['required', 'unique:Customers', 'max:255'],
                'PhysicalAddress' => ['required'],
                'TypeOfBusiness' => ['required'],
                'TelephoneNumber' => ['required', 'numeric'],
                'VATNumber' => ['numeric', 'max:255'],
                'Client_logo' => 'required',
                'Client_icon' => 'required',
            ],
            [
                'unique'        => 'The :attribute has already been registered.',
                'TradingName.required' => 'The Trading Name is required.',
                'TradingName.string' => 'Only characters are allowed',

                'RegistrationName.required' => 'The Registration Name is required.',
                'RegistrationName.string' => 'Only characters are allowed',

                'RegistrationNumber.required' => 'The Registration Number is required.',
                'RegistrationNumber.numeric' => 'Only characters are allowed',

                'PhysicalAddress.required' => 'The Physical Address is required.',

                'TypeOfBusiness.required' => 'The Type Of Business is required.',

                'TelephoneNumber.required' => 'The Telephone Number is required.',
                'TelephoneNumber.numeric' => 'Only numbers are allowed',

                'VATNumber.numeric' => 'Only numbers are allowed',

                'Client_logo.required' => 'The Client logo is required.',
                'Client_icon.required' => 'The Client icon is required.',


            ]
        );

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
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;
        $GetAllCustomers = Customer::all();

        $this->validate($request, [
            'fontcode'=> ['required','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'Client_logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'Client_icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp'
        ]);


        $newCustomerId = Str::upper(Str::uuid());
        $newclient = Customer::create([
            'Id' =>  $newCustomerId,
            'TradingName' => $request->TradingName,
            'RegistrationName' => $request->RegistrationName,
            'RegistrationNumber' => $request->RegistrationNumber,
            'VATNumber' => $request->VATNumber,
            'BranchLocation' => $request->BranchLocation,
            'PhysicalAddress' => $request->PhysicalAddress,
            'TypeOfBusiness' => $request->TypeOfBusiness,
            'TelephoneNumber' => $request->TelephoneNumber,
            // 'CreatedDate' => Str::upper(Str::uuid()),
            // 'CreatedBy' => date("Y-m-d H:i:s"),
            // 'ModifiedDate' => date("Y-m-d H:i:s"),
            // 'ModifiedBy' => date("Y-m-d H:i:s"),
            // 'ActivatedBy' => Str::upper(Str::uuid()),
            // 'ActivatedDate' => date("Y-m-d H:i:s"),
            'IsRestricted' => 0,
            'Client_Logo' => $request->Client_logo,
            'Client_Font_Code' => $request->fontcode,
            'Client_Icon' => $request->Client_icon,
            // 'Api_AVS'  => $avschecked,
            // 'Api_KYC'  => $kycchecked,
            // 'Api_Comp' => $compchecked,
        ]);
        $newclient->save();

        if($request->file('Client_logo') || $request->file('Client_icon')){

            $logoIconPath = 'assets/logo';
            if (!File::isDirectory($logoIconPath)) {
                File::makeDirectory($logoIconPath, 0777, true, true);
            }
            $customerLogoIconPath = $logoIconPath.'/'.$newCustomerId;
            if (!File::isDirectory($customerLogoIconPath)) {
                File::makeDirectory($customerLogoIconPath, 0777, true, true);
            }

            if($request->file('Client_logo')){
                $Logo = random_int(1000, 9999).$request->Client_logo->getClientOriginalName();
                $request->Client_logo->move(public_path($customerLogoIconPath), $Logo);
            }

            if($request->file('Client_icon')){
                $Icon = random_int(1000, 9999).$request->Client_icon->getClientOriginalName();
                $request->Client_icon->move(public_path($customerLogoIconPath), $Icon);
            }
            DB::table('Customers')->where('Id', $newCustomerId)->update(['Client_Logo' => $Logo, 'Client_Icon' => $Icon]);
        }


        $newCustomerId = Str::upper(Str::uuid());
        $newclient = Customer::create([
            'Id' =>  $newCustomerId,
            'TradingName' => $request->TradingName,
            'RegistrationName' => $request->RegistrationName,
            'RegistrationNumber' => $request->RegistrationNumber,
            'VATNumber' => $request->VATNumber,
            'BranchLocation' => $request->BranchLocation,
            'PhysicalAddress' => $request->PhysicalAddress,
            'TypeOfBusiness' => $request->TypeOfBusiness,
            'TelephoneNumber' => $request->TelephoneNumber,
            // 'CreatedDate' => Str::upper(Str::uuid()),
            // 'CreatedBy' => date("Y-m-d H:i:s"),
            // 'ModifiedDate' => date("Y-m-d H:i:s"),
            // 'ModifiedBy' => date("Y-m-d H:i:s"),
            // 'ActivatedBy' => Str::upper(Str::uuid()),
            // 'ActivatedDate' => date("Y-m-d H:i:s"),
            'IsRestricted' => 0,
            'Client_Logo' => $request->Client_logo,
            'Client_Font_Code' => $request->fontcode,
            'Client_Icon' => $request->Client_icon,
            // 'Api_AVS'  => $avschecked,
            // 'Api_KYC'  => $kycchecked,
            // 'Api_Comp' => $compchecked,
        ]);
        $newclient->save();
        if(!empty($_POST['tab'])){
            DB::table('customer_has_tabs')->where('CustomerId',$newCustomerId)->delete();
            $tab = [];
            foreach ($_POST['tab'] as $key => $value) {
                $tab['CustomerId'] = $newCustomerId;
                $tab['TabId'] = $value;
                $newtabs[]=$tab;
            }
            CustomerHasTabs::insert($newtabs);
        }

        return redirect()->route('admin-display')
        ->with('success', 'A new company has been created successfully')
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('GetAllCustomers', $GetAllCustomers)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);
    }

    public function CustomerTabs(Request $request)
    {
        $customerId = "4717e73d-1f3f-4ace-be1a-0244770d6272";
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);

        $tabs =  CustomerTabs::all('Id','Name');
        $newtabs = [];
        if(!empty($_POST)){
            DB::table('customer_has_tabs')->where('CustomerId',$customerId)->delete();
            $tab = [];
            foreach ($_POST['tab'] as $key => $value) {
                $tab['CustomerId'] = $customerId;
                $tab['TabId'] = $value;
                $newtabs[]=$tab;
            }
            CustomerHasTabs::insert($newtabs);
        }
        $customerTabs = DB::table("customer_has_tabs")->where("customer_has_tabs.CustomerId", $customerId)
        ->pluck('customer_has_tabs.TabId', 'customer_has_tabs.TabId')
        ->all();

        return view('admin-customertabs', compact('tabs','customerTabs'))
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo);

    }
}
