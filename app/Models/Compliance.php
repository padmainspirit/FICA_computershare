<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Compliance';
    public $timestamps = false;

    protected $fillable = [
        'Compliance_id',
        'FICA_id',
        'CreatedOnDate',
        'LastUpdatedDate',
        'Compliance_Status',
        'EnquiryDate',
        'EnquiryInput',
        'HA_IDNO',
        'HA_IDNOMatchStatus',
        'HA_Names',
        'HA_Surname',
        'HA_DateOfBirth',
        'HA_DeceasedStatus',
        'HA_DeceasedDate',
        'HA_IDBookIssuedDate',
        'HA_ErrorDescription',
        'ErrorMessage'
    ];
    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
