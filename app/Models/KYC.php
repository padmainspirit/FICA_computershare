<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_KYC';
    public $timestamps = false;
    protected $fillable = [
        'KYC_id',
        'FICA_id',
        'Readonly',
        'CreatedOnDate',
        'LastUpdatedDate',
        'KYC_Status',
        'Address_Documentname',
        'Address_File_Path',
        'Address_Document_ID',
        'DateonDocument',
        'KYCStatusInd',
        'FirstName',
        'SecondName',
        'Surname',
        'IDNo',
        'BirthDate',
        'Gender',
        'TitleDesc',
        'MaritalStatusDesc',
        'Age',
        'PrivacyStatus',
        'ResidentialAddress',
        'PostalAddress',
        'HomeTelephoneNo',
        'WorkTelephoneNo',
        'CellularNo',
        'EmailAddress',
        'EmployerDetail',
        'ReferenceNo',
        'ExternalReference',
        'Nationality',
        'Sources',
        'TotalSourcesUsed',
        'EnquiryInput',
        'SubscriberName',
        'SubscriberUserName',
        'KYCStatusDesc',
        'EnquiryStatus',
        'XDsRefNo',
        'ExternalRef',
        'ERRORCONDITIONNUMBER',
        'ErrorMessage'
    ];
    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
