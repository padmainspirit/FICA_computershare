<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Nationality';
    public $timestamps = false;

    protected $fillable = [
        'Nationality_ID',
        'Nationality',
        'Nationlity_Risk',
        'Nationlity_Score',
        'IsActive'
    ];
}
