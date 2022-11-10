<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephones extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Telephones';
    public $timestamps = false;

    protected $fillable = [
        'ConsumerID',
        'TelephoneTypeInd',
        'InternationalDialingCode',
        'TelephoneCode',
        'TelephoneNo',
        'RecordStatusInd',
        'CreatedonDate',
        'ChangedonDate',
        'LastUpdatedDate'
    ];
    public function consumer()
    {
        return $this->belongsTo(\App\Models\Consumer::class);
    }
}
