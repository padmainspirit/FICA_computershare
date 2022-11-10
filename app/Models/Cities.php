<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Cities';
    public $timestamps = false;

    protected $fillable = [
        'City_id',
        'cityName',
        'latitude',
        'longitude',
        'province',
        'createdondate',
        'LastUpdate'
    ];
}
