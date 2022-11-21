<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQData extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_FAQ';
    public $timestamps = false;

    protected $getfaq = [
        'FAQ_ID'
        ,'Customerid'
        ,'Question'
        ,'Answer'
        ,'IsActive'
    ];
}
