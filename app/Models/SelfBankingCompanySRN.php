<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfBankingCompanySRN extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_SelfBankingCompanySRN';
    public $timestamps = true;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;


    protected $fillable = [
        'Id',
        'SelfBankingDetailsId',
        'companies',
    ];

    public function customer()
    {
        return $this->hasOne(SelfBankingDetails::class,'SelfBankingDetailsId','SelfBankingDetailsId');
    }

}
