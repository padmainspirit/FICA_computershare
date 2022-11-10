<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountType extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Bank_Account_Types';
    public $timestamps = false;

    protected $fillable = [
        'BankTypeid',
        'AccountType',
        'Account_description',
        'Account_active',
        'Createondate',
        'Lastupdate'
    ];
}
