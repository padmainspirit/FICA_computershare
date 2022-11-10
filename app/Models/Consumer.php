<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
