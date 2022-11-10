<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APILogs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'API_Logs';
    public $timestamps = false;

    protected $fillable = [
        'API_Log_Id',
        'Createddate',
        'FICAId',
        'ConsumerID',
        'CustomerID',
        'API_ID'
    ];
}
