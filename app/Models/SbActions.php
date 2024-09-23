<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbActions extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Selfbanking_Actions';
    public $timestamps = false;

    protected $fillable = [
        'ActionId',
        'AdminID' ,  //$consumer->Consumerid,
        'SelfBankingdetailsId' ,
        'CreatedAt',
        'ActionFrom',
        'ActionTo',
        'Comment',
        'Admin_User'
    ];

    public function customerUser()
    {
        return $this->hasOne(CustomerUser::class,'Id','AdminID');
    }
}
