<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupDatas extends Model
{
    use HasFactory;

    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'LookupDatas';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Type',
        'Value',
        'Text',
        'IsActive'
    ];
}
