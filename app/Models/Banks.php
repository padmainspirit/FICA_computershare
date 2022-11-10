<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'Ref_Banks';
    public $timestamps = false;

    protected $fillable = [
        'Bankid',
        'bankname',
        'branchcode',
        'Bankactive',
        'createdondate',
        'lastupdate'
    ];
}
