<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Provinces';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'Province_name',
        'short_desc',
        'CreatedOnDate',
        'LastUpdatedDate'
    ];
}
