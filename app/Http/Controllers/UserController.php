<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerUser;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use Carbon\Carbon;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = CustomerUser::orderBy('Id', 'DESC')->paginate(5);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
            
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;
        $Logo = $customer->Client_Logo;
        $customerName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;
        $LogUserName = $client->FirstName;
        $LogUserSurname = $client->LastName;
        $IsSuperAdmin = false;
        $getRoleName = CustomerUser::getCustomerUserRoleName();
        $roles = Role::pluck('name', 'name')->all();
        $customers = Customer::pluck('RegistrationName', 'Id',);
        if ($getRoleName) {
            if ($getRoleName == 'SuperAdmin') {
                $IsSuperAdmin = true;
                
            } elseif ($getRoleName == 'CustomerAdmin') {
                $IsSuperAdmin = false;
                $roles = Role::where ('name', 'CustomerUser')->pluck('name', 'name')->all();
                $customers = Customer::where ('Id', $client->CustomerId)->pluck('RegistrationName', 'Id',);
            }
        }

        
        return view('users.create', compact('roles', 'customers'))
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)
            ->with('IsSuperAdmin', $IsSuperAdmin);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customerId = $request['CustomerId'];
        $this->validate($request, [
            'FirstName' => ['required', 'string', 'min:2', 'max:255'],
            'LastName' => ['required', 'string', 'min:2', 'max:255'],
            //'IDNumber' => 'required|digits:13|unique:CustomerUsers',
            'IDNumber' => ['required','digits:13','unique:CustomerUsers'],            
            // 'IDNumber' => ['required', 'digits:13', Rule::unique('CustomerUsers')->where(function ($query) use ($request) {
            //     return $query->where('CustomerId', $request->CustomerId);
            // })],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:CustomerUsers'],
            // 'Email' => ['required', 'string', 'email', 'max:255',Rule::unique('CustomerUsers')->where(function ($query) use ($request) {
            //     return $query->where('CustomerId', $request->CustomerId);
            // })],
            'PhoneNumber' => ['required', 'string', 'max:255', 'unique:CustomerUsers'],
            // 'PhoneNumber' => ['required', 'string', 'max:255',Rule::unique('CustomerUsers')->where(function ($query) use ($request) {
            //     return $query->where('CustomerId', $request->CustomerId);
            // })],
            'Password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
            'confirm-passkey' => ['required', 'string', 'min:8', 'same:Password'],
            'roles' => 'required',
            'CustomerId' => 'required'
        ], [
            'unique'        => 'The :attribute already been registered.',
            'IDNumber.required' => 'The ID number field is required.',
            'CustomerId.required' => 'The Customer ID field is required.',
            'IDNumber.digits' => 'Please enter a valid 13 digit ID Number.',
            'Password.regex'   => 'The :attribute is invalid, password must contain at least one Uppercase, one Lower case, A number (0-9), Special Characters (!@#$%^&*) of least 8 Characters.',
        ]);

        $input = $request->all();
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);

        if ($input['roles'] == 'SuperAdmin') {
            $isadmin = 2;
        } elseif ($input['roles'] == 'CustomerAdmin') {
            $isadmin = 1;
        } else {
            $isadmin = 0;
        }

        //$input['password'] = Hash::make($input['password']);

        //$user = CustomerUser::create($input);
        $YearNow = Carbon::now()->year;
        $user  = CustomerUser::create([
            //'Id' =>  Str::upper(Str::uuid()),
            'FirstName' => $input['FirstName'],
            'LastName' => $input['LastName'],
            'Email' => $input['Email'],
            'PhoneNumber' => $input['PhoneNumber'],
            'Password' => Hash::make($input['Password']),
            'IDNumber' => $input['IDNumber'],
            'IsAdmin' => $isadmin,
            'Status' => NULL,
            'CustomerId' => $input['CustomerId'],
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
        $user->assignRole($request->input('roles'));

        // return redirect()->route('admin-display')
        //     ->with('success', 'User created successfully')
        //     ->with('customerName', $customer->RegistrationName)
        //     ->with('Icon', $customer->Client_Icon)
        //     ->with('customer', $customer)
        //     ->with('Logo', $customer->Client_Logo);
        $getRoleName = CustomerUser::getCustomerUserRoleName();
        if ($getRoleName) {
            if ($getRoleName == 'SuperAdmin') {
                return redirect()->route('admin-display')
                ->with('success', 'User created successfully')
                ->with('customerName', $customer->RegistrationName)
                ->with('Icon', $customer->Client_Icon)
                ->with('customer', $customer)
                ->with('Logo', $customer->Client_Logo);
                
            } else{
                //return redirect('users/'.$id.'/edit')
                Mail::send(
                    'auth.emailreg',
                    [
                        'FirstName' => $input['FirstName'], 'LastName' => $input['LastName'], 'Email' => $input['Email'], 'Password' => $input['Password'], 'Logo' => $customer->Client_Logo, 'TradingName' => $customer->TradingName, 'YearNow' => $YearNow, 'RegistrationName' => $customer->RegistrationName
                    ],
                    function ($message) use ($request) {
                        $message->to($request->Email);
                        $message->subject('New Registered User');
                    }
                );
                return redirect()->route('users-display',['id'=>$customer->Id])
                ->with('success', 'User created successfully')
                ->with('customerName', $customer->RegistrationName)
                ->with('Icon', $customer->Client_Icon)
                ->with('customer', $customer)
                ->with('Logo', $customer->Client_Logo);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;
        // $Logo = $customer->Client_Logo;
        // $customerName = $customer->RegistrationName;
        // $Icon = $customer->Client_Icon;

        $user = CustomerUser::find($id);
        //$roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        //$customers = Customer::pluck('RegistrationName', 'Id');
        $userBelongsToCustomer = $user->CustomerId;

        $LogUserName = $client->FirstName;
        $LogUserSurname = $client->LastName;
        $IsSuperAdmin = false;
        $getRoleName = CustomerUser::getCustomerUserRoleName();
        $roles = Role::pluck('name', 'name')->all();
        $customers = Customer::pluck('RegistrationName', 'Id',);
        if ($getRoleName) {
            if ($getRoleName == 'SuperAdmin') {
                $IsSuperAdmin = true;
                
            } elseif ($getRoleName == 'CustomerAdmin') {
                $IsSuperAdmin = false;
                $roles = Role::where ('name', 'CustomerUser')->pluck('name', 'name')->all();
                $customers = Customer::where ('Id', $client->CustomerId)->pluck('RegistrationName', 'Id',);
            }
        }

        return view('users.edit', compact('user', 'roles', 'userRole', 'customers', 'userBelongsToCustomer'))
            ->with('UserFullName', $UserFullName)
            ->with('customerName', $customer->RegistrationName)
            ->with('Icon', $customer->Client_Icon)
            ->with('customer', $customer)
            ->with('Logo', $customer->Client_Logo)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)
            ->with('IsSuperAdmin', $IsSuperAdmin);
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
        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $this->validate($request, [
            'FirstName' => ['required', 'string', 'min:2', 'max:255'],
            'LastName' => ['required', 'string', 'min:2', 'max:255'],
            // 'IDNumber' => 'required|digits:13|unique:CustomerUsers,IDNumber,' . $id,
            // 'Email' => 'required|email|unique:CustomerUsers,Email,' . $id,
            // 'PhoneNumber' => 'required|string|unique:CustomerUsers,PhoneNumber,' . $id,
            'IDNumber' => ['required', 'digits:13', Rule::unique('CustomerUsers')->ignore($id)->where(function ($query) use ($request) {
                return $query->where('CustomerId', $request->CustomerId);
            })],
            'Email' => ['required', 'string', 'email', 'max:255',Rule::unique('CustomerUsers')->ignore($id)->where(function ($query) use ($request) {
                return $query->where('CustomerId', $request->CustomerId);
            })],
            'PhoneNumber' => ['required', 'string', 'max:255',Rule::unique('CustomerUsers')->ignore($id)->where(function ($query) use ($request) {
                return $query->where('CustomerId', $request->CustomerId);
            })],
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
        if ($input['roles'] == 'SuperAdmin') {
            $user->IsAdmin = 2;
        } elseif ($input['roles'] == 'CustomerAdmin') {
            $user->IsAdmin = 1;
        } else {
            $user->IsAdmin = 0;
        }

        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        $getRoleName = CustomerUser::getCustomerUserRoleName();
        if ($getRoleName) {
            if ($getRoleName == 'SuperAdmin') {
                return redirect()->route('admin-display')
                ->with('success', 'User updated successfully')
                ->with('UserFullName', $UserFullName)
                ->with('customerName', $customer->RegistrationName)
                ->with('Icon', $customer->Client_Icon)
                ->with('customer', $customer)
                ->with('Logo', $customer->Client_Logo);
                
            } else{
                //return redirect('users/'.$id.'/edit')
                return redirect()->route('users-display',['id'=>$customer->Id])
                ->with('success', 'User updated successfully')
                ->with('UserFullName', $UserFullName)
                ->with('customerName', $customer->RegistrationName)
                ->with('Icon', $customer->Client_Icon)
                ->with('customer', $customer)
                ->with('Logo', $customer->Client_Logo);
            }
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
