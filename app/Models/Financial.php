<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Financial';
    public $timestamps = false;

    protected $fillable = [
        'ConsumerFinancial',
        'FICA_id',
        'Tax_Number',
        'Tax_Oblig_outside_SA',
        'Foreign_Tax_Number',
        'Sources_Funds',
        'Public_official',
        'Public_official_type_DPIP',
        'Public_official_type_FPPO',
        'Public_official_Family',
        'Public_official_type_family_DPIP',
        'Public_official_type_family_FPPO',
        'SanctionList',
        'AdverseMedia',
        'NonResidentOther',
    ];
    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
}
