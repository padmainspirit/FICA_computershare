<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOVS extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_DOVS';
    public $timestamps = false;
    protected $fillable = [
        'DOVS_id',
        'FICA_id',
        'Readonly',
        'CreatedOnDate',
        'LastUpdatedDate',
        'DOVS_Status',
        'DOVS_Documentname',
        'DOVS_File_Path',
        'DOVS_Document_ID',
        'EnquiryDate',
        'DOVSStatusInd',
        'SubscriberName',
        'SubscriberUserName',
        'EnquiryInput',
        'DeceasedStatus',
        'ConsumerIDPhotoMatch',
        'MatchResponseCode',
        'LivenessDetectionResult',
        'AgeEstimationOfLiveness',
        'ConsumerIDPhoto',
        'ConsumerCapturedPhoto',
        'StreetNumber',
        'Route',
        'Locality',
        'Country',
        'PostalCode',
        'Latitude',
        'Longitude',
        'ERRORCONDITIONNUMBER'
    ];

    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
