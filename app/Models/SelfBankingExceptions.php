<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfBankingExceptions extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'SelfBankingExceptions';
    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null;


    protected $fillable = [
        'Id',
        'SelfBankingLinkId',
        'API',
        'Status',
        'Comment',
    ];

    public function selfBankingLink()
    {
        return $this->hasOne(SelfBankingLink::class,'Id','SelfBankingLinkId');
    }
}
