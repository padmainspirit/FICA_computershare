<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'DovsPhoneNumber',
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
        return $this->hasOne(SelfBankingLink::class,'Id','SelfBankingLinkId');
    }

    public function SBCompanySRN()
    {
        return $this->hasMany(SelfBankingCompanySRN::class,'SelfBankingDetailsId','SelfBankingDetailsId');
    }

    public function fica()
    {
        return $this->hasOne(FICA::class,'Consumerid','SelfBankingDetailsId');
    }

    public function bankAccountType()
    {
        return $this->hasOne(BankAccountType::class,'BankTypeid','AccountType');
    }


    /* public static function checkifExistIdSRN($srnlist, $idnumber)
    {
        $current_date_time = Carbon::now();
        $minus_72_hours = $current_date_time->subHour(72);
        $checksrn = SelfBankingDetails::whereHas('SBCompanySRN', function ($query) use($srnlist) {
                        $query->select('SelfBankingDetailsId','SRN', 'companies')
                        ->whereIn('SRN', $srnlist);
                    })
                    ->with(['SBCompanySRN'])
                    ->where("CreatedOnDate", ">", $minus_72_hours)
                    ->where(['IDNUMBER'=>$idnumber])->orderBy('CreatedOnDate', 'DESC')->first();
        if($checksrn){
            return true;
        }else{
            return false;
        }
    } */

}
