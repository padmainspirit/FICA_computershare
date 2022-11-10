<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceOfFunds extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_SourceFunds';
    public $timestamps = false;

    protected $fillable = [
        'Funds_Id',
        'Funds',
        'Funds_Risk',
        'Funds_Score',
        'Isactive',
    ];
}
