<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AWSLogs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'AWS_Logs';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Createddate',
        'CustomerId',
        'FICAId',
        'CustomerUserId',
        'ConsumerID',
        'AWS_Cost',
        'IdOrPassportNumber',
        'AWSSearchType',
        'Documentname',
    ];
}
