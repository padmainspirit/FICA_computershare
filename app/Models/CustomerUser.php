<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use DB;



class CustomerUser extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles, UuidTrait;

    protected $connection = 'sqlsrv';
    protected $table = 'CustomerUsers';
    public $timestamps = false;
    protected $primaryKey = 'Id';


    protected $fillable = [
        'Id',
        'FirstName',
        'LastName',
        'Title',
        'IDNumber',
        'Email',
        'Password',
        'IsAdmin',
        'Status',
        'CustomerId',
        'Code',
        'SubscriptionId',
        'PhoneNumber',
        'Message',
        'CreatedBy',
        'ModifiedDate',
        'ModifiedBy',
        'ActivatedBy',
        'ActivatedDate',
        'IsUserLoggedIn',
        'IsRestricted',
        'LastPasswordResetDate',
        'CreatedDate',
        'LastLoginDate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAuthIdentifier()
    {
        return $this->Id;
    }


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    
    public function getKey() {
        return $this->Id;
    }

    /* Get loggedin users role name */
    public static function getCustomerUserRoleName()
    {
        $id = Auth::user()->Id;
        $getRoleName = Auth::user()->getRoleNames();
        $userRole = isset($getRoleName[0]) ? $getRoleName[0] : '';
        return $userRole; 

    }

    /* add users role in model_has roles with $id */
    public static function assignRoleWithId($role_id, $userid)
    {
        $assignrole = DB::table('model_has_roles')->insert(['role_id' => $role_id,'model_id'=>$userid,'model_type'=>'App\Models\CustomerUser']);
        return true;
    }

}
