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
        'tnc_flag',
        'PersonalDetails',
        'DOVS',
        'BankingDetails'
    ];

    public function customer()
    {
        return $this->hasOne(CustomerUser::class,'Id','CustomerUserId');
    }

    public function SelfBankingExceptions()
    {
        return $this->hasMany(SelfBankingExceptions::class,'SelfBankingLinkId','Id');
    }


    /* Function to check the steps done */
    public static function checkStep($sblink_id)
    {
        $selfbankingLink= SelfBankingLink::find($sblink_id);
        
        if($selfbankingLink->tnc_flag == 0)
        {    
            //return redirect()->route('agree-selfbanking-tnc');
            $routename = 'agree-selfbanking-tnc';
        }else if($selfbankingLink->PersonalDetails == 0){

            //return redirect()->route('sb-personalinfo');
            $routename = 'sb-personalinfo';
        }
        else if($selfbankingLink->DOVS == 0){print_r('dovs');
            //return redirect()->route('digi-verify');
            $routename = 'digi-verify';
        }
        else if($selfbankingLink->BankingDetails == 0){
            //return redirect()->route('bank-verify');
            $routename = 'bank-verify';
        }
        return $routename;

    }
}
