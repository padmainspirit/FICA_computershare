<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\CustomerUser;
use App\Models\FICA;
use App\Models\AVS;
use App\Models\DOVS;
use App\Models\Address;
use App\Models\Compliance;
use App\Models\Telephones;
use App\Models\Financial;
use App\Models\RiskAnswer;
use App\Models\KYC;
use App\Models\ConsumerIdentity;
use App\Models\Declaration;
use App\Models\APILogs;
use App\Models\SendEmail;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Auth;


class GetStartedController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function startFica(Request $request)
    {
        // $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        // $LoggedInConsumerId = $consumer['Consumerid'];
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $LoggedInConsumerId)->where('IsRead', '=', '1')->get();

        if (session()->has('ForgetEmail')) {
            session()->pull('ForgetEmail');
        }

        $Consumerid = Auth::user()->Id;

        // dd($Consumerid);

        $SearchCustomerId = CustomerUser::where('Id', '=', $Consumerid)->first();

        $Customerid = Auth::user()->CustomerId;

        // dd($Customerid);
        $customer = Customer::getCustomerDetails($Customerid);

        //print_r($Customerid);exit;
        /* $Logo = $customerBrand['Client_Logo'];
        $Icon = $customerBrand['Client_Icon'];
        $customerName = $customerBrand['RegistrationName']; */

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // $Logo =  session()->get('Logo');
        // $customerName =  session()->get('customerName');

        // app('debugbar')->info($Logo);

        return view('start-fica-process')->with('customer', $customer);
    }

    public function getStarted(Request $request)
    {
        //try {
        //create Consumer  
        $customerUserId =  Auth::user()->Id;
        $client = CustomerUser::where('Id', '=',  $customerUserId)->first();
        app('debugbar')->error($client);
        $consumerId = Str::upper(Str::uuid());
        $ficaId = Str::upper(Str::uuid());
        $bankId =  Str::upper(Str::uuid());
        $dovs =  Str::upper(Str::uuid());
        $complianceId = Str::upper(Str::uuid());
        $consumerFinancial =  Str::upper(Str::uuid());
        $riskConsumerId = Str::upper(Str::uuid());
        $kycId = Str::upper(Str::uuid());
        $identityId = Str::upper(Str::uuid());
        $DeclarationId = Str::upper(Str::uuid());


        $request->session()->put('ficaId', $ficaId);
        $request->session()->put('consumerId', $consumerId);


        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        // $NotificationLink = $request->session()->get('NotificationLink');

        // app('debugbar')->info($NotificationLink);

        //Consumer
        $consumer = Consumer::create([
            'Consumerid' => $consumerId,
            'CustomerUSERID' => $customerUserId,
            'IDNUMBER' => $client->IDNumber,
            'FirstName' => $client->FirstName,
            'SecondName' => NULL,
            'ThirdName' => NULL,
            'Surname' => $client->LastName,
            'BirthDate' => NULL,
            'TitleCode' => NULL,
            'GenderInd' => NULL,
            'Marital_status' => NULL,
            'Passport' => NULL,
            'Reason_no_id_doc' => NULL,
            'Marriage_date' => NULL,
            'Married_under' => NULL,
            'Anc_no' => NULL,
            'CreatedOnDate' => date("Y-m-d H:i:s"),
            'LastUpdatedDate' => date("Y-m-d H:i:s"),
            'Email' => $client->Email,
            'Customerid' => $Customerid,
            'ClientUniqueRef' => NULL,
            'CustHolderID' => NULL,
            'ReFICADate' => NULL,
            'FICAFLAG' => NULL,
            'Employmentstatus' => NULL,
            'Nameofemployer' => NULL,
            'Industryofoccupation' => NULL,
            'NOYearsAtEmployer' => NULL,
            'Employmenttype' => NULL,
        ]);

        //FICA
        $fica = FICA::create([
            'FICA_id' => $ficaId,
            'Consumerid' => $consumerId,
            'CreatedOnDate' => date("Y-m-d H:i:s"),
            'LastUpdatedDate' => date("Y-m-d H:i:s"),
            'CompletedDate',
            'RejectedDate',
            'FICAProgress',
            'FICAStatus' => 'In progress',
            'IDAS_Status',
            'ID_Status',
            'KYC_Status',
            'AVS_Status',
            'DOVS_Status',
            'Compliance_Status',
            'Personal_Status',
            'Financial_status',
            'Screening_status',
            'Declaration_status',
            'TandC_Status',
            'Signed_Status',
            'Signed_Place',
            'Signed_Date',
            'FICA_Active' => 1,
            'FailedDate',
            'Risk_Status',
            'Risk_Score',
            'Validation_Status',
            'Correction_Status',
            'Extracted'
        ]);

        //CONSUMER IDENTITY
        $consumerIdentity = ConsumerIdentity::create([
            'Identity_ID' => $identityId,
            'FICA_id' =>  $ficaId,
            'Identity_Documentname',
            'Identity_File_Path',
            'Identity_Document_ID' => $client->IDNumber,
            'Identity_Document_TYPE',
            'CreatedonDate',
            'Identity_status',
            'ID_DateofIssue',
            'ID_CountryResidence',
            'DOB',
            'TITLE',
            'INITIALS',
            'FIRSTNAME',
            'SURNAME',
            'SECONDNAME',
            'OTHER_NAMES',
            'SPOUSE_NAME',
            'SPOUSE_SURNAME',
            'PROFILE_GENDER',
            'PROFILE_AGE_GROUP',
            'PROFILE_MARITAL_STATUS',
            'LSM',
            'PROFILE_CONTACT_ABILITY',
            'INCOME',
            'PROFILE_HOMEOWNERSHIP',
            'NUM_PROPERTIES',
            'PROPERTYVALUE',
            'PROFILE_DIRECTORSHIP',
            'NUM_DIRECTORSHIPS',
            'ADVERSE_INDICATOR',
            'DECEASED_IND',
            'DATEOFDEATH',
            'PLACEOFDEATH',
            'OCCUPATION',
            'X_EMPLOYMENT_1',
            'EMPLOYMENT_1_DATE',
            'X_EMPLOYMENT_2',
            'EMPLOYMENT_2_DATE',
            'X_EMPLOYMENT_3',
            'EMPLOYMENT_3_DATE',
            'X_EMPLOYMENT_4',
            'EMPLOYMENT_4_DATE',
            'X_EMPLOYMENT_5',
            'EMPLOYMENT_5_DATE',
            'X_EMAIL',
            'HOME_ADDRESS1_LINE_1',
            'HOME_ADDRESS1_LINE_2',
            'HOME_ADDRESS1_TOWNSHIP',
            'HOME_ADDRESS1_REGION',
            'HOME_ADDRESS1_PROVINCE',
            'HOME_ADDRESS1_POSTAL_CODE',
            'HOME_ADDRESS1_DATE',
            'HOME_ADDRESS2_LINE_1',
            'HOME_ADDRESS2_LINE_2',
            'HOME_ADDRESS2_TOWNSHIP',
            'HOME_ADDRESS2_REGION',
            'HOME_ADDRESS2_PROVINCE',
            'HOME_ADDRESS2_POSTAL_CODE',
            'HOME_ADDRESS2_DATE',
            'HOME_ADDRESS3_LINE_1',
            'HOME_ADDRESS3_LINE_2',
            'HOME_ADDRESS3_TOWNSHIP',
            'HOME_ADDRESS3_REGION',
            'HOME_ADDRESS3_PROVINCE',
            'HOME_ADDRESS3_POSTAL_CODE',
            'HOME_ADDRESS3_DATE',
            'POSTAL_ADDRESS1_LINE_1',
            'POSTAL_ADDRESS1_LINE_2',
            'POSTAL_ADDRESS1_TOWNSHIP',
            'POSTAL_ADDRESS1_REGION',
            'POSTAL_ADDRESS1_PROVINCE',
            'POSTAL_ADDRESS1_POSTAL_CODE',
            'POSTAL_ADDRESS1_DATE',
            'POSTAL_ADDRESS2_LINE_1',
            'POSTAL_ADDRESS2_LINE_2',
            'POSTAL_ADDRESS2_TOWNSHIP',
            'POSTAL_ADDRESS2_REGION',
            'POSTAL_ADDRESS2_PROVINCE',
            'POSTAL_ADDRESS2_POSTAL_CODE',
            'POSTAL_ADDRESS2_DATE',
            'POSTAL_ADDRESS3_LINE_1',
            'POSTAL_ADDRESS3_LINE_2',
            'POSTAL_ADDRESS3_TOWNSHIP',
            'POSTAL_ADDRESS3_REGION',
            'POSTAL_ADDRESS3_PROVINCE',
            'POSTAL_ADDRESS3_POSTAL_CODE',
            'POSTAL_ADDRESS3_DATE',
            'HOME_1_PHONE_NUMBER',
            'HOME_1_DATE',
            'WORK_1_PHONE_NUMBER',
            'WORK_1_DATE',
            'CELL_1_PHONE_NUMBER',
            'CELL_1_DATE',
            'HOME_2_PHONE_NUMBER',
            'HOME_2_DATE',
            'WORK_2_PHONE_NUMBER',
            'WORK_2_DATE',
            'CELL_2_PHONE_NUMBER',
            'CELL_2_DATE',
            'HOME_3_PHONE_NUMBER',
            'HOME_3_DATE',
            'WORK_3_PHONE_NUMBER',
            'WORK_3_DATE',
            'CELL_3_PHONE_NUMBER',
            'CELL_3_DATE',
            'HOME_4_PHONE_NUMBER',
            'HOME_4_DATE',
            'WORK_4_PHONE_NUMBER',
            'WORK_4_DATE',
            'CELL_4_PHONE_NUMBER',
            'CELL_4_DATE',
            'HOME_5_PHONE_NUMBER',
            'HOME_5_DATE',
            'WORK_5_PHONE_NUMBER',
            'WORK_5_DATE',
            'CELL_5_PHONE_NUMBER',
            'CELL_5_DATE',
        ]);

        //KYC
        $kyc = KYC::create([
            'KYC_id' => $kycId,
            'FICA_id' => $ficaId,
            'Readonly' => NULL,
            'CreatedOnDate' => NULL,
            'LastUpdatedDate' => NULL,
            'KYC_Status' => NULL,
            'Address_Documentname' => NULL,
            'Address_File_Path' => NULL,
            'Address_Document_ID' => NULL,
            'DateonDocument' => NULL,
            'KYCStatusInd' => NULL,
            'FirstName' => NULL,
            'SecondName' => NULL,
            'Surname' => NULL,
            'IDNo' => NULL,
            'BirthDate' => NULL,
            'Gender' => NULL,
            'TitleDesc' => NULL,
            'MaritalStatusDesc' => NULL,
            'Age' => NULL,
            'PrivacyStatus' => NULL,
            'ResidentialAddress' => NULL,
            'PostalAddress' => NULL,
            'HomeTelephoneNo' => NULL,
            'WorkTelephoneNo' => NULL,
            'CellularNo' => NULL,
            'EmailAddress' => NULL,
            'EmployerDetail' => NULL,
            'ReferenceNo' => NULL,
            'ExternalReference' => NULL,
            'Nationality' => NULL,
            'Sources' => NULL,
            'TotalSourcesUsed' => NULL,
            'EnquiryInput' => NULL,
            'SubscriberName' => NULL,
            'SubscriberUserName' => NULL,
            'KYCStatusDesc' => NULL,
            'EnquiryStatus' => NULL,
            'XDsRefNo' => NULL,
            'ExternalRef' => NULL,
            'ERRORCONDITIONNUMBER' => NULL,
            'ErrorMessage'
        ]);

        //AVS
        $avs = AVS::create([
            'Bank_id' => $bankId,
            'FICA_id' => $ficaId,
            'Bank_name' => NULL,
            'Account_no' => NULL,
            'Account_name' => NULL,
            'Branch' => NULL,
            'Branch_code' => NULL,
            'Income_taxno' => NULL,
            'Readonly' => NULL,
            'CreatedOnDate' => NULL,
            'LastUpdatedDate' => NULL,
            'AVS_Status' => NULL,
            'Bank_Documentname' => NULL,
            'Bank_File_Path' => NULL,
            'Bank_Document_ID' => NULL,
            'ERRORCONDITIONNUMBER' => NULL,
            'ACCOUNTFOUND' => NULL,
            'IDNUMBERMATCH' => NULL,
            'INITIALSMATCH' => NULL,
            'SURNAMEMATCH' => NULL,
            'ACCOUNT_OPEN' => NULL,
            'ACCOUNTDORMANT' => NULL,
            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => NULL,
            'ACCOUNTACCEPTSDEBITS' => NULL,
            'ACCOUNTACCEPTSCREDITS' => NULL,
            'EMAILMATCH' => NULL,
            'PHONEMATCH' => NULL,
            'TAXREFERENCEMATCH' => NULL,
            'EnquiryDate' => NULL,
            'EnquiryType' => NULL,
            'SubscriberName' => NULL,
            'SubscriberUserName' => NULL,
            'EnquiryInput' => NULL,
            'EnquiryStatus' => NULL,
            'XDsRefNo' => NULL,
            'ExternalRef' => NULL
        ]);

        //DOVS
        $dovs = DOVS::create([
            'DOVS_id' => $dovs,
            'FICA_id' => $ficaId,
            'Readonly' => NULL,
            'CreatedOnDate' => NULL,
            'LastUpdatedDate' => NULL,
            'DOVS_Status',
            'DOVS_Documentname' => NULL,
            'DOVS_File_Path' => NULL,
            'DOVS_Document_ID' => NULL,
            'EnquiryDate' => NULL,
            'DOVSStatusInd' => NULL,
            'SubscriberName' => NULL,
            'SubscriberUserName' => NULL,
            'EnquiryInput' => NULL,
            'DeceasedStatus' => NULL,
            'ConsumerIDPhotoMatch' => NULL,
            'MatchResponseCode' => NULL,
            'LivenessDetectionResult' => NULL,
            'AgeEstimationOfLiveness' => NULL,
            'ConsumerIDPhoto' => NULL,
            'ConsumerCapturedPhoto' => NULL,
            'StreetNumber' => NULL,
            'Route' => NULL,
            'Locality' => NULL,
            'Country' => NULL,
            'PostalCode' => NULL,
            'Latitude' => NULL,
            'Longitude' => NULL,
            'ERRORCONDITIONNUMBER' => NULL
        ]);

        //COMPLIANCE
        $compliance = Compliance::create([
            'Compliance_id' => $complianceId,
            'FICA_id' => $ficaId,
            'CreatedOnDate' => NULL,
            'LastUpdatedDate' => NULL,
            'Compliance_Status' => NULL,
            'EnquiryDate' => NULL,
            'EnquiryInput' => NULL,
            'HA_IDNO' => NULL,
            'HA_IDNOMatchStatus' => NULL,
            'HA_Names' => NULL,
            'HA_Surname' => NULL,
            'HA_DateOfBirth' => NULL,
            'HA_DeceasedStatus' => NULL,
            'HA_DeceasedDate' => NULL,
            'HA_IDBookIssuedDate' => NULL,
            'HA_ErrorDescription' => NULL,
            'ErrorMessage' => NULL
        ]);

        //ADDRESS
        $address = Address::create([
            'ConsumerID' => $consumerId,
            'AddressTypeInd' => NULL,
            'OriginalAddress1' => NULL,
            'OriginalAddress2' => NULL,
            'OriginalAddress3' => NULL,
            'OriginalAddress4' => NULL,
            'OriginalPostalCode' => NULL,
            'OccupantTypeInd' => NULL,
            'RecordStatusInd' => NULL,
            'LastUpdatedDate' => NULL,
            'CreatedOnDate' => NULL,
            'Province' => NULL,
        ]);

        //TELEPHONES
        // $telephones = Telephones::create([
        //     'ConsumerID' => $consumerId,
        //     'TelephoneTypeInd' => NULL,
        //     'InternationalDialingCode' => NULL,
        //     'TelephoneCode' => NULL,
        //     'TelephoneNo' => NULL,
        //     'RecordStatusInd' => NULL,
        //     'CreatedonDate' => NULL,
        //     'ChangedonDate' => NULL,
        //     'LastUpdatedDate' => NULL
        // ]);

        //FINANCIAL
        $financial = Financial::create([
            'ConsumerFinancial' => $consumerFinancial,
            'FICA_id' => $ficaId,
            'Tax_Number' => NULL,
            'Tax_Oblig_outside_SA' => NULL,
            'Foreign_Tax_Number' => NULL,
            'Sources_Funds' => NULL,
            'Public_official' => NULL,
            'Public_official_type_DPIP' => NULL,
            'Public_official_type_FPPO' => NULL,
            'Public_official_Family' => NULL,
            'Public_official_type_family_DPIP' => NULL,
            'Public_official_type_family_FPPO' => NULL,
            'SanctionList' => NULL,
            'AdverseMedia' => NULL,
            'NonResidentOther' => NULL,
        ]);

        $declaration = Declaration::create([
            'Declaration_ID' => $DeclarationId,
            'FICA_ID' => $ficaId,
            'ConsumerID' => $consumerId,
            'ClientDueDiligence' => NULL,
            'NomineeDeclaration' => NULL,
            'IssuerCommunication' => NULL,
            'CustodyService' => NULL,
            'SegregatedDeposit' => NULL,
            'DividendTax' => NULL,
            'BeeShareholder' => NULL,
            'StampDuty' => NULL,
            'StockBrokerName' => NULL,
            'StockBrokerContact' => NULL,
        ]);

        //TELEPHONES
        $cellphoneNumber = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 12)->get();

        $cellNumber =  $client->PhoneNumber;
        //Adding New Cell Number 
        $telLength = strlen($cellNumber);
        //Check the length of the Cell number
        if ($telLength == 10) {
            // if (Count($cellphoneNumber) > 0) {
            //     foreach ($cellphoneNumber as $number) {
            //         //dd($number);
            //         Telephones::where("ConsumerID", $consumer->Consumerid)->where("TelephoneTypeInd", 12)->update(['RecordStatusInd' => 0]);
            //     }
            // }
            app('debugbar')->info($telLength);
            // if ($telLength == 10) {
            $extension = substr($cellNumber, 0, 3);
            $telno = substr($cellNumber, 3, 10);
            Telephones::create([
                'ConsumerID' => $consumer->Consumerid,
                'TelephoneTypeInd' => 12, //use lookup table
                'InternationalDialingCode',
                'TelephoneCode' => $extension,
                'TelephoneNo' =>  $telno,
                'RecordStatusInd' => 1,
                'CreatedonDate' => date("Y-m-d H:i:s"),
                'ChangedonDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
            ]);
        }

        // $riskAnswer = RiskAnswer::create([
        //     'Risk_CONSUMER_id' =>  $riskConsumerId,
        //     'Fica_id' => $ficaId,
        //     'question_id' => NULL,
        //     'Question_Name' => NULL,
        //     'RiskLevel_id' => NULL,
        //     'ConsumerRisk_Score' => NULL,
        //     'CreatedOnDate' => NULL,
        //     'LastUpdatedDate' => NULL
        // ]);

        $consumer->save();
        $fica->save();
        $avs->save();
        $dovs->save();
        $address->save();
        $compliance->save();
        //$telephones->save();
        $financial->save();
        $kyc->save();
        $consumerIdentity->save();
        $declaration->save();

        //$riskAnswer->save();


        return redirect('fica');
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }
        // return view('start-fica-process', ['article' =>
        // 'Passing Data to View']);
    }
}
