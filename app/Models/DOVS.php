<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        'ERRORCONDITIONNUMBER',
        'EnquiryID',
        'DOVSResponse',
        'FirstName',
        'SecondName',
        'ThirdName',
        'Surname',
        'MaidenName',
        'IDNo',
        'PassportNo',
        'BirthDate',
        'Gender',
        'TitleDesc',
        'MaritalStatusDesc',
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
        'ResidentialAddress1',
        'ResidentialAddress2',
        'ResidentialAddress3',
        'ResidentialAddress4',
        'ResidentialPostalCode',
        'PostalAddress1',
        'PostalAddress2',
        'PostalAddress3',
        'PostalAddress4',
        'PostalPostalCode',
        'InputCellularNo',
        'CellNumberMatched',
        'LinkedCount',
        'BonusXML',
        'TempReference',
        'EnquiryResultID',

    ];

    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }

    public static function getConsumerID(Request $request)
    {
        $getSearchFica = Declaration::getFicaId($request);
        $SearchFica = $getSearchFica['FICA_ID'];
        $getPhoto = DOVS::where('FICA_id', '=', $SearchFica)->first();

        return $getPhoto;
    }
}
