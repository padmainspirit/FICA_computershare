<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FICA extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_FICA';
    public $timestamps = false;

    protected $fillable = [
        'FICA_id',
        'Consumerid',
        'CreatedOnDate',
        'LastUpdatedDate',
        'CompletedDate',
        'RejectedDate',
        'FICAProgress',
        'FICAStatus',
        'IDAS_Status',
        'ID_Status',
        'KYC_Status',
        'AVS_Status',
        'DOVS_Status',
        'Compliance_Status',
        'Personal_Status',
        'Financial_status',
        'Screening_status',
        'Declaration_status',
        'TandC_Status',
        'Signed_Status',
        'Signed_Place',
        'Signed_Date',
        'FICA_Active',
        'FailedDate',
        'Risk_Status',
        'Risk_Score',
        'Validation_Status',
        'ConsumerReferance',
        'Correction_Status',
        'Extracted'
    ];

    public function consumer()
    {
        return $this->belongsTo(\App\Models\Consumer::class);
    }

    public function avs()
    {
        return $this->hasOne(\App\Models\AVS::class);
    }
    public function consumerIdentity()
    {
        return $this->hasOne(\App\Models\ConsumerIdentity::class);
    }
    public function dovs()
    {
        return $this->hasOne(\App\Models\DOVS::class);
    }
    public function kyc()
    {
        return $this->hasOne(\App\Models\KYC::class);
    }
    public function riskAnswer()
    {
        return $this->hasOne(\App\Models\RiskAnswer::class);
    }
    public function compliance()
    {
        return $this->hasOne(\App\Models\Compliance::class);
    }

    public static function getRiskStatusbyFICA(Request $request)
    {
        $getSearchFica = Declaration::getFicaId($request);
        $SearchFica = $getSearchFica['FICA_ID'];
        $consumerBankDoc = FICA::where('FICA_id', '=', $SearchFica)->first();

        return $consumerBankDoc;
    }

    public static function getStepState($fica)
    {
        $stepstate = 0;
        $ficaProgress = $fica->FICAProgress;
        if($ficaProgress != null){

            if($fica->ID_Status == null)
            {
                $stepstate = 0;
            }
            else if($fica->KYC_Status == null)
            {
                $stepstate = 1;
            }
            else if($fica->AVS_Status == null)
            {
                $stepstate = 2;
            }
            else if($fica->DOVS_Status == null)
            {
                $stepstate = 3;
            }
            else if($ficaProgress >= 9 && ($fica->Compliance_Status == null || $fica->Validation_Status == null))
            {
                $stepstate = 8;
            }else{
                $stepstate = (int)$fica->FICAProgress;
            }
        }

        return $stepstate;
    }
}
