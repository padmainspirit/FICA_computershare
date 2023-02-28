<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Consumer extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer';
    public $timestamps = false;

    protected $fillable = [
        'Consumerid',
        'CustomerUSERID',
        'IDNUMBER',
        'FirstName',
        'SecondName',
        'ThirdName',
        'Surname',
        'BirthDate',
        'TitleCode',
        'GenderInd',
        'Marital_status',
        'Passport',
        'Reason_no_id_doc',
        'Marriage_date',
        'Married_under',
        'Anc_no',
        // 'Readonly',
        'CreatedOnDate',
        'LastUpdatedDate',
        'Email',
        'Customerid',
        'ClientUniqueRef',
        'CustHolderID',
        'ReFICADate',
        'FICAFLAG',
        'Employmentstatus',
        'Nameofemployer',
        'Industryofoccupation',
        'NOYearsAtEmployer',
        'Employmenttype',
        'PhoneNumber',
    ];

    public function address()
    {
        return $this->hasOne(\App\Models\Address::class);
    }

    public function fica()
    {
        return $this->hasMany(\App\Models\FICA::class); //here is the first condition for UserOtp Model
    }
    public function telephones()
    {
        return $this->hasMany(\App\Models\Telephones::class); //here is the first condition for UserOtp Model
    }

    public static function getConsumerId(Request $request)
    {
        $client = CustomerUser::getCustomerUserId($request);
        $clientId = $client->Id;           
        $getSearchConsumerID = Consumer::where('CustomerUSERID', '=', $clientId)->first();
        // $SearchConsumerID = $getSearchConsumerID['Consumerid']; 

        return $getSearchConsumerID;
    }

    public static function getSPDetails(Request $request)
    {
        $getSearchFica = Consumer::getConsumerId($request);
        $SearchConsumerID = $getSearchFica['Consumerid']; 

        $testing  = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Consumerresults :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );

        return $testing;
    }

}
