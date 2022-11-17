<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerComplianceEntityAdditional extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Compliance_Entity_additional';
    public $timestamps = false;

    protected $fillable = [
        'Entity_Additional_id',
        'Compliance_id',
        'Additional_type',
        'Additional_value',
        'Additional_comment'
    ];
}
