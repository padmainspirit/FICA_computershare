<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfBankingDetails extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_SelfBankingDetails';
    public $timestamps = true;

    const CREATED_AT = 'CreatedOnDate';
    const UPDATED_AT = 'LastUpdatedDate';


    protected $fillable = [
        'SelfBankingDetailsId',
        'SelfBankingLinkId',
        'Customerid',
        'IDNUMBER',
        'FirstName',
        'SecondName',
        'ThirdName',
        'Surname',
        'Email',
        'PhoneNumber',
        'PhoneNumberHome',
        'PhoneNumberWork',
        'Address_Line1',
        'Address_Line2',
        'City',
        'Province',
        'Zip',
        'AccountType',
        'AccountHolderInitial',
        'BankName',
        'AccountNumber',
        'IDV',
        'KYC',
        'AVS',
        'Compliance',
        'Risk',
        'Debt_summary',
        'Client_Ref',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'Id','Customerid');
    }

    public function selfBankingLink()
    {
        return $this->hasOne(SelfBankingLink::class,'Id','SelfBankingDetailsId');
    }

    public function SBCompanySRN()
    {
        return $this->hasMany(SelfBankingCompanySRN::class,'SelfBankingDetailsId','SelfBankingDetailsId');
    }

}
