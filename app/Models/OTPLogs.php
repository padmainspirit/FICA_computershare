<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPLogs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'OTP_Logs';
    public $timestamps = false;

    protected $fillable = [
        'OTP_Id',
        'Createddate',
        'CustomerId',
        'IDNumber',
        'OTP_Cost',
        'OTP_value'
    ];
}
