<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'Customers';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'TradingName',
        'RegistrationName',
        'RegistrationNumber',
        'VATNumber',
        'BranchLocation',
        'PhysicalAddress',
        'TypeOfBusiness',
        'TelephoneNumber',
        'FaxNumber',
        'BillingEmail',
        'Status',
        'BillingType',
        'Code',
        'Turnover',
        'CustOwnIDNumber',
        'PostalAddress',
        'WebAddress',
        'AccountDeptContactPerson',
        'AccountDeptTelephoneNumber',
        'AccountDeptFaxNumber',
        'AuthIDNumber',
        'AuthPosition',
        'AccountDeptEmail',
        'AuthFirstName',
        'AuthSurName',
        'AuthCellNumber',
        'AuthEmail',
        'BusinessDescription',
        'CreditBureauInformation',
        'Purpose',
        'CreatedDate',
        'CreatedBy',
        'ModifiedDate',
        'ModifiedBy',
        'ActivatedBy',
        'ActivatedDate',
        'TabSelected',
        'IsRestricted',
        'Customer_URL',
        'Inspirit_Logo',
        'Client_Logo',
        'Client_Font_Code',
        'Customer_Name',
        'Customer_Email',
        'Client_Icon',
        'Api_Comp',
        'Api_AVS',
        'Api_Facial',
    ];

    
    /* function to get customer details by customer id */
    public static function getCustomerDetails($Customerid)
    {
        $customer = Customer::where('Id', '=',  $Customerid)->first(['Id','Client_Logo','Client_Icon','TradingName','RegistrationName']);
        return $customer;
    }
    
    /* function to get customer details by customer name */
    public static function getCustomerDetailsByName($customerName)
    {
        $customer = Customer::where('RegistrationName', '=',  $customerName)->first(['Id','Client_Logo','Client_Icon','TradingName','RegistrationName']);
        return $customer;
    }

    /* function to get customer details by customer name */
    public static function getCustomerDetailsByUrl()
    {
        $currentURL =  \URL::full();  //"http://127.0.0.1:8000/login?customer=Computershare"
        $customerName = substr($currentURL, (strpos($currentURL, '=') ?: -1) + 1); //Computershare
        $customer = Customer::where('RegistrationName', '=',  $customerName)->first(['Id','Client_Logo','Client_Icon','TradingName','RegistrationName']);
                
        return $customer;
    }
    

}
