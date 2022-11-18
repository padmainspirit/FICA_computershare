<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerComplianceSanction extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Compliance_Sanction';
    public $timestamps = false;

    protected $fillable = [
        'Sanction_id',
        'Compliance_id',
        'ID',
        'Date_Listed',
        'Entity_type',
        'Gender',
        'Entityname',
        'BestNameScore',
        'EntityUniqueID',
        'ReasonListed',
        'ResultDate',
        'ListReferenceNumber',
        'Comments',
    ];
}
