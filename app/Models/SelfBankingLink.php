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
        'IdDocumentUpload',
        'BankingDetails',
        'BankDocumentUpload',
    ];

    public function customer()
    {
        return $this->hasOne(CustomerUser::class,'Id','CustomerUserId');
    }

    public function SelfBankingExceptions()
    {
        return $this->hasMany(SelfBankingExceptions::class,'SelfBankingLinkId','Id');
    }

    public function selfBankingDetails()
    {
        return $this->belongsTo(SelfBankingDetails::class,'Id','SelfBankingLinkId');
    }


    /* Function to check the steps done */
    public static function checkStep($sblink_id)
    {
        $selfbankingLink= SelfBankingLink::find($sblink_id);
        
        if($selfbankingLink->tnc_flag == 0)
        {    
            $routename = 'agree-selfbanking-tnc';
        }else if($selfbankingLink->PersonalDetails == 0){

            $routename = 'sb-personalinfo';
        }
        else if($selfbankingLink->DOVS == 0){
            $routename = 'digi-verify';
        }
        else if($selfbankingLink->DOVS == 2 && $selfbankingLink->IdDocumentUpload == 0){
            $routename = 'uploadid';
        }else if($selfbankingLink->DOVS == 2 && $selfbankingLink->IdDocumentUpload == 1){
            $routename = 'banking';
        }
        else if($selfbankingLink->BankingDetails == 0){
            $routename = 'banking';
        }
        else if($selfbankingLink->BankingDetails != 0 && $selfbankingLink->BankDocumentUpload == 1){
            $routename = 'sb-preview-details';
        }else{
            $routename = 'register';
        }
        return $routename;

    }
}
