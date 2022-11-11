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
use Spatie\Permission\Traits\HasRoles;
use App\Models\Address;

    
class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $data = CustomerUser::orderBy('Id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $customers = Customer::pluck('RegistrationName','Id', );
        return view('users.create',compact('roles','customers'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'FirstName' => ['required', 'string', 'min:2','max:255'],
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
            'roles' => 'required',
            'CustomerId'=>'required'
        ], [
            'unique'        => 'The :attribute already been registered.',
            'IDNumber.required' => 'The ID number field is required.',
            'CustomerId.required' => 'The Customer ID field is required.',
            'IDNumber.digits' => 'Please enter a valid 13 digit ID Number.',
            'Password.regex'   => 'The :attribute is invalid, password must contain at least one Uppercase, one Lower case, A number (0-9), Special Characters (!@#$%^&*) of least 8 Characters.',
        ]); 
    
        $input = $request->all();
        //$input['password'] = Hash::make($input['password']);
    
        //$user = CustomerUser::create($input);
        $user  = CustomerUser::create([
            //'Id' =>  Str::upper(Str::uuid()),
            'FirstName' => $input['FirstName'],
            'LastName' => $input['LastName'],
            'Email' => $input['Email'],
            'PhoneNumber' => rand(),                
            'Password' => Hash::make($input['Password']),
            'IDNumber' => rand(),
            'IsAdmin' => 0,
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
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
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
        return view('users.show',compact('user'));
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
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $customers = Customer::pluck('RegistrationName','Id');
        $userBelongsToCustomer = $user->CustomerId;
        return view('users.edit',compact('user','roles','userRole', 'customers','userBelongsToCustomer'));
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
            'FirstName' => ['required', 'string', 'min:2','max:255'],
            'LastName' => ['required', 'string', 'min:2', 'max:255'],
            'IDNumber' => 'required|digits:13|unique:CustomerUsers,IDNumber,'.$id,
            'Email' => 'required|email|unique:CustomerUsers,Email,'.$id,
            'PhoneNumber' => 'required|string|unique:CustomerUsers,PhoneNumber,'.$id,
            'Password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',                
            ],
            'confirm-passkey' => ['required', 'string', 'min:8', 'same:Password'],
            'roles' => 'required'
        ], [
            'unique'        => 'The :attribute already been registered.',
            'IDNumber.required' => 'The ID number field is required.',
            'IDNumber.digits' => 'Please enter a valid 13 digit ID Number.',
            'Password.regex'   => 'The :attribute is invalid, password must contain at least one Uppercase, one Lower case, A number (0-9), Special Characters (!@#$%^&*) of least 8 Characters.',
        ]); 
    
        $input = $request->all();
        if(!empty($input['Password'])){ 
            $input['Password'] = Hash::make($input['Password']);
        }else{
            $input = Arr::except($input,array('Password'));    
        }
    
        $user = CustomerUser::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        
        $user->assignRole($request->input('roles'));

        // $role = DB::table('roles')->where('name',$request['roles'])->first();
        // $assignrole = DB::table('model_has_roles')->insert(['role_id' => $role->id,'model_id'=>$id,'model_type'=>'App\Models\CustomerUser']);
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
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
                        ->with('success','User deleted successfully');
    }
}