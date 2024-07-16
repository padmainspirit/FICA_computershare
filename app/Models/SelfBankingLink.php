<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfBankingLink extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'SelfBankingLink';
    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';


    protected $fillable = [
        'Id',
        'CustomerUserId',
        'Email',
        'PhoneNumber',
        'LinkGenerated',
        'IsClicked',
        'CustomerId',
        'tnc_flag'
    ];

    public function customer()
    {
        return $this->hasOne(CustomerUser::class,'Id','CustomerUserId');
    }
}
