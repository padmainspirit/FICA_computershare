<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTabs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'CustomerTabs';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'slug',
        'name',
    ];

    

}
