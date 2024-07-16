<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConsumerIdentity extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_IDENTITY';
    public $timestamps = false;

    protected $fillable = [
        'Identity_ID',
        'FICA_id',
        'Identity_Documentname',
        'Identity_File_Path',
        'Identity_Document_ID',
        'Identity_Document_TYPE',
        'CreatedonDate',
        'Identity_status',
        'ID_DateofIssue',
        'ID_CountryResidence',
        'DOB',
        'TITLE',
        'INITIALS',
        'FIRSTNAME',
        'SURNAME',
        'SECONDNAME',
        'OTHER_NAMES',
        'SPOUSE_NAME',
        'SPOUSE_SURNAME',
        'PROFILE_GENDER',
        'PROFILE_AGE_GROUP',
        'PROFILE_MARITAL_STATUS',
        'LSM',
        'PROFILE_CONTACT_ABILITY',
        'INCOME',
        'PROFILE_HOMEOWNERSHIP',
        'NUM_PROPERTIES',
        'PROPERTYVALUE',
        'PROFILE_DIRECTORSHIP',
        'NUM_DIRECTORSHIPS',
        'ADVERSE_INDICATOR',
        'DECEASED_IND',
        'DATEOFDEATH',
        'PLACEOFDEATH',
        'OCCUPATION',
        'X_EMPLOYMENT_1',
        'EMPLOYMENT_1_DATE',
        'X_EMPLOYMENT_2',
        'EMPLOYMENT_2_DATE',
        'X_EMPLOYMENT_3',
        'EMPLOYMENT_3_DATE',
        'X_EMPLOYMENT_4',
        'EMPLOYMENT_4_DATE',
        'X_EMPLOYMENT_5',
        'EMPLOYMENT_5_DATE',
        'X_EMAIL',
        'HOME_ADDRESS1_LINE_1',
        'HOME_ADDRESS1_LINE_2',
        'HOME_ADDRESS1_TOWNSHIP',
        'HOME_ADDRESS1_REGION',
        'HOME_ADDRESS1_PROVINCE',
        'HOME_ADDRESS1_POSTAL_CODE',
        'HOME_ADDRESS1_DATE',
        'HOME_ADDRESS2_LINE_1',
        'HOME_ADDRESS2_LINE_2',
        'HOME_ADDRESS2_TOWNSHIP',
        'HOME_ADDRESS2_REGION',
        'HOME_ADDRESS2_PROVINCE',
        'HOME_ADDRESS2_POSTAL_CODE',
        'HOME_ADDRESS2_DATE',
        'HOME_ADDRESS3_LINE_1',
        'HOME_ADDRESS3_LINE_2',
        'HOME_ADDRESS3_TOWNSHIP',
        'HOME_ADDRESS3_REGION',
        'HOME_ADDRESS3_PROVINCE',
        'HOME_ADDRESS3_POSTAL_CODE',
        'HOME_ADDRESS3_DATE',
        'POSTAL_ADDRESS1_LINE_1',
        'POSTAL_ADDRESS1_LINE_2',
        'POSTAL_ADDRESS1_TOWNSHIP',
        'POSTAL_ADDRESS1_REGION',
        'POSTAL_ADDRESS1_PROVINCE',
        'POSTAL_ADDRESS1_POSTAL_CODE',
        'POSTAL_ADDRESS1_DATE',
        'POSTAL_ADDRESS2_LINE_1',
        'POSTAL_ADDRESS2_LINE_2',
        'POSTAL_ADDRESS2_TOWNSHIP',
        'POSTAL_ADDRESS2_REGION',
        'POSTAL_ADDRESS2_PROVINCE',
        'POSTAL_ADDRESS2_POSTAL_CODE',
        'POSTAL_ADDRESS2_DATE',
        'POSTAL_ADDRESS3_LINE_1',
        'POSTAL_ADDRESS3_LINE_2',
        'POSTAL_ADDRESS3_TOWNSHIP',
        'POSTAL_ADDRESS3_REGION',
        'POSTAL_ADDRESS3_PROVINCE',
        'POSTAL_ADDRESS3_POSTAL_CODE',
        'POSTAL_ADDRESS3_DATE',
        'HOME_1_PHONE_NUMBER',
        'HOME_1_DATE',
        'WORK_1_PHONE_NUMBER',
        'WORK_1_DATE',
        'CELL_1_PHONE_NUMBER',
        'CELL_1_DATE',
        'HOME_2_PHONE_NUMBER',
        'HOME_2_DATE',
        'WORK_2_PHONE_NUMBER',
        'WORK_2_DATE',
        'CELL_2_PHONE_NUMBER',
        'CELL_2_DATE',
        'HOME_3_PHONE_NUMBER',
        'HOME_3_DATE',
        'WORK_3_PHONE_NUMBER',
        'WORK_3_DATE',
        'CELL_3_PHONE_NUMBER',
        'CELL_3_DATE',
        'HOME_4_PHONE_NUMBER',
        'HOME_4_DATE',
        'WORK_4_PHONE_NUMBER',
        'WORK_4_DATE',
        'CELL_4_PHONE_NUMBER',
        'CELL_4_DATE',
        'HOME_5_PHONE_NUMBER',
        'HOME_5_DATE',
        'WORK_5_PHONE_NUMBER',
        'WORK_5_DATE',
        'CELL_5_PHONE_NUMBER',
        'CELL_5_DATE',
    ];

    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }

    public static function getconsumerIDDoc(Request $request)
    {
        $getSearchFica = Declaration::getFicaId($request);
        $SearchFica = $getSearchFica['FICA_ID'];
        $getconsumerIDDoc = ConsumerIdentity::where('FICA_id', '=', $SearchFica)->first();

        return $getconsumerIDDoc;
    }

    public static function getconsumerIDDoc1($ficaId)
    {
        $getconsumerIDDoc = ConsumerIdentity::where('FICA_id', '=', $ficaId)->first();

        return $getconsumerIDDoc;
    }
}
