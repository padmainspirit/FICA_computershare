<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerUser;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Spatie\Permission\Traits\HasRoles;

    
class UserController extends Controller
{
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
        return view('users.create',compact('roles'));
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
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email|unique:customerusers,Email',
            'password' => 'same:confirm-password',
            'roles' => 'required'
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
            'Password' => Hash::make($input['password']),
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
    
        return view('users.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email|unique:customerusers,Email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['Password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
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