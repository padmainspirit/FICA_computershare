<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AVS extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_AVS';
    public $timestamps = false;

    protected $fillable = [
        'Bank_id',
        'FICA_id',
        'Bank_name',
        'Account_no',
        'Account_name',
        'Branch',
        'Branch_code',
        'Income_taxno',
        'Readonly',
        'CreatedOnDate',
        'LastUpdatedDate',
        'AVS_Status',
        'Bank_Documentname',
        'Bank_File_Path',
        'Bank_Document_ID',
        'ERRORCONDITIONNUMBER',
        'ACCOUNTFOUND',
        'IDNUMBERMATCH',
        'INITIALSMATCH',
        'SURNAMEMATCH',
        'ACCOUNT_OPEN',
        'ACCOUNTDORMANT',
        'ACCOUNTOPENFORATLEASTTHREEMONTHS',
        'ACCOUNTACCEPTSDEBITS',
        'ACCOUNTACCEPTSCREDITS',
        'EMAILMATCH',
        'PHONEMATCH',
        'TAXREFERENCEMATCH',
        'EnquiryDate',
        'EnquiryType',
        'SubscriberName',
        'SubscriberUserName',
        'EnquiryInput',
        'EnquiryStatus',
        'XDsRefNo',
        'ExternalRef'
    ];

    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
