<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryOccupation extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Industry_occupation';
    public $timestamps = false;

    protected $fillable = [
        'Industry_occupation_ID',
        'Industry_occupation',
        'IO_Risk',
        'IO_Score',
        'Isactive'
    ];
}
