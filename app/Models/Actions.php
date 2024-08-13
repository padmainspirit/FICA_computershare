<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actions extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Actions';
    public $timestamps = false;

    protected $fillable = [
        'AdminID'
        ,'Consumerid'
        ,'ActionDate'
        ,'ActionType'
        ,'Action_Comment'
        ,'Admin_User'
    ];

    public function customerUser()
    {
        return $this->hasOne(CustomerUser::class,'Id','AdminID');
    }
}
