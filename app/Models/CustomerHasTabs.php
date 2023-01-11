<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHasTabs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'customer_has_tabs';
    public $timestamps = false;

    protected $fillable = [
        'CustomerId',
        'TabId',
    ];

    

}
