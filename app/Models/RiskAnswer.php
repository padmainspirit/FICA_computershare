<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAnswer extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Risk_Answers';
    public $timestamps = false;

    protected $fillable = [
        'Risk_CONSUMER_id',
        'Fica_id',
        'question_id',
        'Question_Name',
        'RiskLevel_id',
        'ConsumerRisk_Score',
        'CreatedOnDate',
        'LastUpdatedDate'
    ];
    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
