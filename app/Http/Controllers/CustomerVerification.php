<?php

namespace App\Http\Controllers;

use App\Models\BankAccountType;
use App\Models\Actions;
use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Address;
use App\Models\AVS;
use App\Models\Financial;
use App\Models\ConsumerIdentity;
use App\Models\KYC;
use App\Models\Declaration;
use App\Models\LookupDatas;
use App\Models\CustomerUser;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\SendEmail;
use App\Models\Compliance;
use App\Models\ConsumerComplianceEntityAdditional;
use App\Models\Telephones;
use App\Models\ConsumerComplianceSanction;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use PDF;
use Barryvdh\Debugbar\ServiceProvider;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\DB::connection

class CustomerVerification extends Controller
{

    // public function __construct(Request $request)
    // {

    //     $this->GetAllData($request);

    // }

    public function AdminVertical()
    {

        app('debugbar')->info('Testing');


        return view('admin-vertical');
    }

    public function AdminReports()
    {
        // $data = DB::connection(sqlsrv2)->select('EXEC sp_consumerExtract ?,?', ['2D12F5FB-BE59-4A50-BD6A-3896720D8F89', '0000000000001']);
        // $data = DB::connection(sqlsrv2)->select('EXEC sp_ProfileValidation ?,?', ['2D12F5FB-BE59-4A50-BD6A-3896720D8F89', '0000000000001']);
        // app('debugbar')->info($data);

        app('debugbar')->info('Testing');


        return view('admin-reports');
    }

    public function TestResult(Request $request)
    {


        // if (session()->has('LoggedUser')) {
        //     session()->pull('exception');
        // }
        // dd($request->input('idnumberResult'));

        // $client = Auth::user();


        // if (session()->get('idnumber') == null) {
        //     $idnumber = $request->input('idnumberResult');
        //     $request->session()->put('idnumber', $idnumber);
        // } else {
        //     $idnumber = session()->get('idnumber');
        // }

        // session()->put('idnumber', $idnumber);


        // $idnumber = session()->has('idnumber') ? $request->input('idnumberResult'):session()->get('idnumber');
        // $idnumber = $request->input('idnumberResult');

        $client = Auth::user();
        $LoggedUser = $client->Id;

        if ($LoggedUser != null) {
            session()->pull('exception');
        }
        $idnumber = $request->idnumberResult;
        // $LoggedUser = $request->session()->get('LoggedUser');
        $Customerid = $client->CustomerId;

        // dd($Customerid);

        $getLogUser = CustomerUser::where('Id', '=', $LoggedUser)->first();

        $LogUserName = $getLogUser['FirstName'];
        $LogUserSurname = $getLogUser['LastName'];

        $request->session()->put('LogUserName', $LogUserName);
        $request->session()->put('LogUserSurname', $LogUserSurname);

        // $LogUserName = $request->session()->get('LogUserName');
        // $LogUserSurname = $request->session()->get('LogUserSurname');

        //$consumerid = 2D12F5FB-BE59-4A50-BD6A-3896720D8F89;
        // $consumer = Consumer::where('IDNUMBER', '=',  $idnumber)->first();

        // //$newconsumerid = DB::connection(sqlsrv2)->select('TBL_Consumer');

        // if(isset( $contactDetails)){ $contactDetails= DB::connection(sqlsrv2)->select('EXEC sp_ContactDetails ?,?', [$consumer->Consumerid, $idnumber]);}
        // $contactDetails= DB::connection(sqlsrv2)->select('EXEC sp_ContactDetails ?,?', [$consumer->Consumerid, $idnumber]);
        // $facialRecognition = DB::connection(sqlsrv2)->select('EXEC sp_FacialRecognition ?,?', [$consumer->Consumerid, $idnumber]);
        // $financialDetails = DB::connection(sqlsrv2)->select('EXEC sp_Financials_AVS ?,?', [$consumer->Consumerid, $idnumber]);
        // $identityDetails = DB::connection(sqlsrv2)->select('EXEC sp_IdentityDetails ?,?', [$consumer->Consumerid, $idnumber]);
        // $kycDetails = DB::connection(sqlsrv2)->select('EXEC sp_KYC_Details ?,?', [$consumer->Consumerid, $idnumber]);

        // app('debugbar')->info($identityDetails);

        // $output_data1 = ['response' => true, 'message' => 'Contact request is successful.', 'data' =>   $contactDetails];
        // $output_data2 = ['response' => true, 'message' => 'Facial request is successful.', 'data' =>   $facialRecognition];
        // $output_data3 = ['response' => true, 'message' => 'Financial request is successful.', 'data' =>   $financialDetails];
        // $output_data4 = ['response' => true, 'message' => 'Identity request is successful.', 'data' =>   $identityDetails];
        // $output_data5 = ['response' => true, 'message' => 'KYC request is successful.', 'data' =>   $kycDetails];
        // $output_data6 = ['response' => true, 'message' => 'KYC request is successful.', 'data' =>   $kycDetails];

        // $SearchConsumerID = session()->get('SearchConsumerID');
        // $SearchFica = session()->get('SearchFica');

        // Get ID Number, then get CustomerUSERID to get ConsumerID, Tables created from Get-started should allow a pre-created FicaID. 
        $useridentitynum = CustomerUser::where('IDNumber', '=', $idnumber)->where('CustomerId', '=', $Customerid)->first();
        $SearchCustomerUSERID = $useridentitynum['Id'];

        $getSearchConsumerID = Consumer::where('CustomerUSERID', '=', $SearchCustomerUSERID)->first();
        $SearchConsumerID = $getSearchConsumerID['Consumerid'];


        $getSearchFica = Declaration::where('ConsumerID', '=', $SearchConsumerID)->first();
        $SearchFica = $getSearchFica['FICA_ID'];

        // dd($SearchFica);

        session()->put('SearchConsumerID', $SearchConsumerID);
        session()->put('SearchFica', $SearchFica);

        // app('debugbar')->info($idnumber);
        app('debugbar')->info($SearchConsumerID);
        app('debugbar')->info($SearchFica);

        // $NotificationLink = SendEmail::where('Consumerid', '=',  $SearchConsumerID)->where('IsRead', '=', '1')->get();

        // $getConFinanbyFICA = ConsumerFinancials::where('FICA_id', '=', $SearchFica)->first();
        // $ConFinanbyFICA = ConsumerFinancials::where('ConsumerFinancial', '=', $getConFinanbyFICA->ConsumerFinancial)->first();
        // app('debugbar')->info($ConFinanbyFICA);


        // $getBankIdbyFICA = ConsumerAVS::where('FICA_id', '=', $SearchFica)->first();
        // $BankIdbyFICA = ConsumerAVS::where('Bank_id', '=', $getBankIdbyFICA->Bank_id)->get();

        // $getConsFinanByFICA = ConsumerFinancials::where('FICA_id', '=', $SearchFica)->first();
        // $BankIdbyFICA = ConsumerAVS::where('Bank_id', '=', $getBankIdbyFICA->Bank_id)->get();


        // $getbanking = ConsumerAVS::where('FICA_id', '=', $SearchFica)->first();
        // $getbanking = ConsumerAVS::where('FICA_id', '=', $useridentitynum->FICA_id)->first();
        // app('debugbar')->info($getConsFinanByFICA);

        // $userfica = ConsumerIdentity::where('FICA_id', '=', $idnumber)->first();

        // $SearchFica = $userfica['FICA_id'];
        // $SearchConsumerID = $getConsumerId['Consumerid'];


        // $checkfica = FICA::where('FICA_id', '=', $userfica->FICA_id)->first();

        // User Search ID Document
        $getconsumerIDDoc = ConsumerIdentity::where('FICA_id', '=', $SearchFica)->first();
        $IDDoc = $getconsumerIDDoc['Identity_File_Path'];

        // dd($IDDoc);

        $IDDoc != '' ? $getconsumerIDDoc['Identity_File_Path'] : null;
        $request->session()->put('IDDoc', $IDDoc);

        // $IDDoc != '' ? $getconsumerIDDoc['Identity_File_Path']-> $getconsumerIDDoc['Identity_File_Path'] : null;

        // app('debugbar')->info($consumerIDDoc);

        // User Search Proof of Address Document
        $consumerAddressDoc = KYC::where('FICA_id', '=', $SearchFica)->first();
        // $getconsumerAddressDoc = ['Address_File_Path' => $consumerAddressDoc->Address_File_Path];
        $AddressDoc = $consumerAddressDoc['Address_File_Path'];

        $AddressDoc != '' ? $consumerAddressDoc['Address_File_Path'] : null;
        $request->session()->put('AddressDoc', $AddressDoc);

        // $AddressDoc != '' ? $getconsumerAddressDoc['Address_File_Path']-> $getconsumerAddressDoc['Address_File_Path'] : null;

        // app('debugbar')->info($AddressDoc);

        // User Search Proof of Bank Document
        $consumerBankDoc = AVS::where('FICA_id', '=', $SearchFica)->first();
        // $getconsumerBankDoc = ['Bank_File_Path' => $consumerBankDoc->Bank_File_Path];
        $BankDoc = $consumerBankDoc['Bank_File_Path'];


        $SNameMatch = $consumerBankDoc['SURNAMEMATCH'];
        $IDMatch = $consumerBankDoc['IDNUMBERMATCH'];
        $EmailMatch = $consumerBankDoc['EMAILMATCH'];
        $TaxNumMatch = $consumerBankDoc['TAXREFERENCEMATCH'];

        // app('debugbar')->info($SNameMatch);

        $BankDoc != '' ? $consumerBankDoc['Bank_File_Path'] : null;
        $request->session()->put('BankDoc', $BankDoc);
        $request->session()->put('SNameMatch', $SNameMatch);
        $request->session()->put('IDMatch', $IDMatch);
        $request->session()->put('EmailMatch', $EmailMatch);
        $request->session()->put('TaxNumMatch', $TaxNumMatch);


        // $BankDoc != '' ? $getconsumerBankDoc['Bank_File_Path']-> $getconsumerBankDoc['Bank_File_Path'] : null;

        // app('debugbar')->info($BankDoc);

        $testing  = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Consumerresults :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );


        app('debugbar')->info($testing);

        // $lookup = Lookup::all()->toArray();
        // $getgender = Consumer::where('IDNUMBER', '=', $idnumber)->first();

        $getPhoto = DOVS::where('FICA_id', '=', $SearchFica)->first();
        $ConsumerIDPhoto = $getPhoto['ConsumerIDPhoto'];
        $ConsumerCapturedPhoto = $getPhoto['ConsumerCapturedPhoto'];

        // dd($ConsumerIDPhoto);

        // Check if corrupted or Incomplete
        $ConsumerIDPhoto = $ConsumerIDPhoto != null ? $ConsumerIDPhoto : null;
        $ConsumerCapturedPhoto = $ConsumerCapturedPhoto != null ? $ConsumerCapturedPhoto : null;

        if ($ConsumerIDPhoto == null || "" || '') {
            DOVS::where('FICA_id', '=', $SearchFica)->update(
                array(

                    'ConsumerIDPhoto' => NULL,

                )
            );
            $ConsumerIDPhoto = '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';
        }

        if ($ConsumerCapturedPhoto == null || "" || '') {
            DOVS::where('FICA_id', '=', $SearchFica)->update(
                array(

                    'ConsumerCapturedPhoto' => NULL,

                )
            );
            $ConsumerCapturedPhoto = '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';
        }

        $request->session()->put('ConsumerIDPhoto', $ConsumerIDPhoto);
        $request->session()->put('ConsumerCapturedPhoto', $ConsumerCapturedPhoto);


        // app('debugbar')->info($ConsumerIDPhoto);
        // app('debugbar')->info($ConsumerCapturedPhoto);


        // Individual Value GET
        // $gender = ['GenderInd' => $getgender->GenderInd];


        // $male = ['Text' => $lookup[12]->Text];
        // $female = ['Text' => $lookup[14]->Text];

        $lookup = LookupDatas::all();

        $maleval = ['Value' => $lookup[12]->Value];
        $femaleval = ['Value' => $lookup[14]->Value];

        // app('debugbar')->info($lookup);

        // $gethome = ['Value' => $lookup[10]->Value];
        // $getwork = ['Value' => $lookup[16]->Value];
        // $getpostal = ['Value' => $lookup[17]->Value];

        $Searchfirstname = ['FirstName' => $useridentitynum->FirstName];
        $Searchsurname = ['Surname' => $useridentitynum->Surname];

        $firstnam = $Searchfirstname['FirstName'];
        $secondnam = $Searchsurname['Surname'];

        $getSearchUserTitle = KYC::where('FICA_id', '=', $SearchFica)->first();

        $TitleDesc = $getSearchUserTitle['TitleDesc'];

        // $Searchfirstname = Consumer::where('FirstName', '=', $useridentitynum->FirstName)->first();
        // $Searchsurname = Consumer::where('Surname', '=', $useridentitynum->Surname)->first();


        // app('debugbar')->info($TitleDesc);
        // app('debugbar')->info($femaleval);
        // app('debugbar')->info($Searchsurname);

        $request->session()->put('FirstName', $firstnam);
        $request->session()->put('Surname', $secondnam);
        $request->session()->put('TitleDesc', $TitleDesc);

        // $home = ['Value' => $gethome[0]->Value];
        // $work = ['Value' => $getwork[0]->Value];
        // $postal = ['Value' => $getpostal[0]->Value];

        // app('debugbar')->info($home);
        // app('debugbar')->info($getwork);
        // app('debugbar')->info($getpostal);


        // app('debugbar')->info($maleval);
        // app('debugbar')->info($femaleval);
        // app('debugbar')->info($gender);
        // app('debugbar')->info($male);
        // app('debugbar')->info($female);


        // $cid = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $iddateissue = ['ID_DateofIssue' => $cid->ID_DateofIssue];



        // $nationality = AccountType::all();
        // foreach ($nationality as $country) {
        //     array_push($countries, strtoupper($country->Nationality));
        // }



        // $GetAccountType = AccountType::all();
        // foreach ($GetAccountType as $Type) {
        //     array_push($account, strtoupper($Type->bankname));
        // }

        $accounttype = BankAccountType::all();

        $chequeaccVal = ['BankTypeid' => $accounttype[0]->BankTypeid];
        $savingsaccVal = ['BankTypeid' => $accounttype[1]->BankTypeid];
        $transmissionVal = ['BankTypeid' => $accounttype[2]->BankTypeid];
        $bondVal = ['BankTypeid' => $accounttype[3]->BankTypeid];
        $subscrVal = ['BankTypeid' => $accounttype[4]->BankTypeid];

        // $chequeaccTxt = ['AccountType' => $accounttype[0]->AccountType];
        // $savingsaccTxt = ['AccountType' => $accounttype[1]->AccountType];
        // $transmissionTxt = ['AccountType' => $accounttype[2]->AccountType];
        // $bondTxt = ['AccountType' => $accounttype[3]->AccountType];
        // $subscrTxt = ['AccountType' => $accounttype[4]->AccountType];

        // $accountdata = [$chequeaccTxt, $savingsaccTxt, $transmissionTxt, $bondTxt, $subscrTxt];

        // app('debugbar')->info($chequeaccVal);
        // app('debugbar')->info($savingsaccVal);
        // app('debugbar')->info($transmissionVal);
        // app('debugbar')->info($bondVal);
        // app('debugbar')->info($subscrVal);


        // app('debugbar')->info($chequeaccTxt);
        // app('debugbar')->info($savingsaccTxt);
        // app('debugbar')->info($transmissionTxt);
        // app('debugbar')->info($bondTxt);
        // app('debugbar')->info($subscrTxt);


        $account = [];

        $accounttype = BankAccountType::get('AccountType');
        foreach ($accounttype as $type) {
            array_push($account, $type->AccountType);
        }

        // app('debugbar')->info($account);


        // $accounttype = AccountType::all();
        // foreach ($accounttype as $country) {
        //     array_push($countries, strtoupper($country->AccountType));
        // }
        // sort($countries);

        // $GetIDPhotoLoc = ConsumerIdentity::where('FICA_id', '=', 'A8A1550B-7B40-44E9-9E8A-11F564523B38')->first();

        // app('debugbar')->info($accounttype);


        $insidedata = [

            //Contacts

            'Male' => $lookup[12]->Text,
            'Female' => $lookup[14]->Text,

            // 'FirstName' => $testing!=null? $testing[0]->FirstName:'',
            // 'SURNAME' => $testing!=null? $testing[0]->SURNAME:'',
            // 'SecondName' => $testing!=null? $testing[0]->SecondName:'',

            // 'FirstName' => $testing[0]->FirstName,
            // 'SURNAME' => $testing[0]->SURNAME,
            // 'SecondName' => $testing[0]->SecondName,

            'FirstName' => $testing != '' ? $testing[0]->FirstName : null,
            'SURNAME' => $testing != '' ? $testing[0]->SURNAME : null,
            'SecondName' => $testing != '' ? $testing[0]->SecondName : null,
            // 'SecondName' => $testing = null || '' ? $testing[0]->SecondName : $testing[0]->SecondName,

            // 'GenderInd' => $testing != '' ? $testing[0]->GenderInd : null,
            'Gender' => $testing != '' ? $testing[0]->Gender : null,

            // 'OriginalAddress1' => $testing!=null? $testing[0]->OriginalAddress1:'',
            // 'OriginalAddress2' => $testing!=null? $testing[0]->OriginalAddress2:'',
            // 'OriginalAddress3' => $testing!=null? $testing[0]->OriginalAddress3:'',
            // 'OriginalPostalCode' => $testing!=null? $testing[0]->OriginalPostalCode:'',

            // Residence Address
            'Res_OriginalAdd1' => $testing != '' ? $testing[0]->Res_OriginalAdd1 : null,
            'Res_OriginalAdd2' => $testing != '' ? $testing[0]->Res_OriginalAdd2 : null,
            'Res_OriginalAdd3' => $testing != '' ? $testing[0]->Res_OriginalAdd3 : null,
            'Res_Pcode' => $testing != '' ? $testing[0]->Res_Pcode : null,
            'ResProvince' => $testing != '' ? $testing[0]->ResProvince : null,

            // Postal Address
            'Post_OriginalAdd1' => $testing != '' ? $testing[0]->Post_OriginalAdd1 : null,
            'Post_OriginalAdd2' => $testing != '' ? $testing[0]->Post_OriginalAdd2 : null,
            'Post_OriginalAdd3' => $testing != '' ? $testing[0]->Post_OriginalAdd3 : null,
            'Post_Pcode' => $testing != '' ? $testing[0]->Post_Pcode : null,
            'PostProvince' => $testing != '' ? $testing[0]->PostProvince : null,

            // Work Address
            'Work_OriginalAdd1' => $testing != '' ? $testing[0]->Work_OriginalAdd1 : null,
            'Work_OriginalAdd2' => $testing != '' ? $testing[0]->Work_OriginalAdd2 : null,
            'Work_OriginalAdd3' => $testing != '' ? $testing[0]->Work_OriginalAdd3 : null,
            'Work_Pcode' => $testing != '' ? $testing[0]->Work_Pcode : null,
            'WorkProvince' => $testing != '' ? $testing[0]->WorkProvince : null,


            // 'Province' => $testing!=null? $testing[0]->Province:'',
            'Nameofemployer' => $testing != '' ? $testing[0]->Nameofemployer : null,
            'Employmentstatus' => $testing != '' ? $testing[0]->Employmentstatus : null,
            'Industryofoccupation' => $testing != '' ? $testing[0]->Industryofoccupation : null,
            'Marriage_date' => $testing != '' ? $testing[0]->Marriage_date : null,
            'Married_under' => $testing != '' ? $testing[0]->Married_under : null,
            'IDNUMBER' => $testing != '' ? $testing[0]->IDNUMBER : null,
            'Email' => $testing != '' ? $testing[0]->Email : null,

            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'DOB' => $testing != '' ? $testing[0]->DOB : null,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            'ID_DateofIssue' => $testing != '' ? $testing[0]->ID_DateofIssue : null,

            'CellCode' => $testing != '' ? $testing[0]->CellCode : null,
            'CellNo' => $testing != '' ? $testing[0]->CellNo : null,
            'HomeTelCode' => $testing != '' ? $testing[0]->HomeTelCode : null,
            'HomeTelNo' => $testing != '' ? $testing[0]->HomeTelNo : null,
            'WorkTelCode' => $testing != '' ? $testing[0]->WorkTelCode : null,
            'WorkTelNo' => $testing != '' ? $testing[0]->WorkTelNo : null,

            // //Contact Work
            // 'TelephoneCodeWork' => $contactDetails[1]->TelephoneCode,
            // 'TelephoneNoWork' => $contactDetails[1]->TelephoneNo,

            // //Contact Home
            // 'TelephoneCodeHome' => $contactDetails[2]->TelephoneCode,
            // 'TelephoneNoHome' => $contactDetails[2]->TelephoneNo,

            // //Contact Cell
            // 'TelephoneCodeCell' => $contactDetails[3]->TelephoneCode,
            // 'TelephoneNoCell' => $contactDetails[3]->TelephoneNo,

            // 'WorkTelephoneNo' => $testing != '' ? $testing[0]->WorkTelephoneNo : null,
            // 'HomeTelephoneNo' => $testing != '' ? $testing[0]->HomeTelephoneNo : null,
            // 'CellularNo' => $testing != '' ? $testing[0]->CellularNo : null,

            //KYC

            'MaritalStatusDesc' => $testing != '' ? $testing[0]->MaritalStatusDesc : null,
            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,
            'Sources' => $testing != '' ? $testing[0]->Sources : null,
            'TotalSourcesUsed' => $testing != '' ? $testing[0]->TotalSourcesUsed : null,
            //Indicate ID success (If 1 then yes, if 0 then No)
            'Identity_status' => $testing != '' ? $testing[0]->Identity_status : null,
            //Indicate KYC success (If 1 then yes, if 0 then No)
            //'KYC_Status' => $testing!=null? $testing[0]->KYC_Status,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            // 'INITIALS' => $testing != '' ? $testing[0]->INITIALS : null,
            'Identity_Document_TYPE' => $testing != '' ? $testing[0]->Identity_Document_TYPE : null,

            //Bank Account Details
            'Bank_name' => $testing != '' ? $testing[0]->Bank_name : null,
            'Branch' => $testing != '' ? $testing[0]->Branch : null,
            'Branch_code' => $testing != '' ? $testing[0]->Branch_code : null,
            'Account_no' => $testing != '' ? $testing[0]->Account_no : null,
            'Account_name' => $testing != '' ? $testing[0]->Account_name : null,
            'Tax_Oblig_outside_SA' => $testing != '' ? $testing[0]->Tax_Oblig_outside_SA : null,
            'BankTypeid' => $testing != '' ? $testing[0]->BankTypeid : null,
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $testing != '' ? $testing[0]->ACCOUNTOPENFORATLEASTTHREEMONTHS : null,
            'ACCOUNTACCEPTSDEBITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSDEBITS : null,
            'ACCOUNTACCEPTSCREDITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSCREDITS : null,

            //Screening

            'Tax_Number' => $testing != '' ? $testing[0]->Tax_Number : null,
            'Foreign_Tax_Number' => $testing != '' ? $testing[0]->Foreign_Tax_Number : null,

            'Public_official' => $testing != '' ? $testing[0]->Public_official : null,
            // 'Public_official_type' => $testing != null ? $testing[0]->Public_official_type : null,
            'Public_official_Family' => $testing != '' ? $testing[0]->Public_official_Family : null,
            // 'Public_official_type_Family' => $testing != null ? $testing[0]->Public_official_type_Family : null,

            'Public_official_type_DPIP' => $testing != '' ? $testing[0]->Public_official_type_DPIP : null,
            'Public_official_type_FPPO' => $testing != '' ? $testing[0]->Public_official_type_FPPO : null,
            'Public_official_type_family_DPIP' => $testing != '' ? $testing[0]->Public_official_type_family_DPIP : null,
            'Public_official_type_family_FPPO' => $testing != '' ? $testing[0]->Public_official_type_family_FPPO : null,

            'SanctionList' => $testing != '' ? $testing[0]->SanctionList : null,
            'AdverseMedia' => $testing != '' ? $testing[0]->AdverseMedia : null,
            'NonResidentOther' => $testing != '' ? $testing[0]->NonResidentOther : null,

            'ClientDueDiligence' => $testing != '' ? $testing[0]->ClientDueDiligence : null,
            'NomineeDeclaration' => $testing != '' ? $testing[0]->NomineeDeclaration : null,
            'IssuerCommunication' => $testing != '' ? $testing[0]->IssuerCommunication : null,
            'CustodyService' => $testing != '' ? $testing[0]->CustodyService : null,
            'SegregatedDeposit' => $testing != '' ? $testing[0]->SegregatedDeposit : null,
            'DividendTax' => $testing != '' ? $testing[0]->DividendTax : null,
            'BeeShareholder' => $testing != '' ? $testing[0]->BeeShareholder : null,
            'StampDuty' => $testing != '' ? $testing[0]->StampDuty : null,
            'Broker' => $testing != '' ? $testing[0]->Broker : null,
            'CommunicationType' => $testing != '' ? $testing[0]->CommunicationType : null,
            'BrokerContact' => $testing != '' ? $testing[0]->BrokerContact : null,
            'EMAILMATCH' => $testing != '' ? $testing[0]->EMAILMATCH : null,

            // //Contacts
            // 'FirstName' => $testing[0]->FirstName,
            // 'Surname' => $testing[0]->Surname,
            // 'TelephoneNo' => $testing[0]->TelephoneNo,
            // 'Nationality' => $testing[0]->Nationality,
            // 'DOB' => $testing[0]->DOB,
            // 'ID_CountryResidence' => $testing[0]->ID_CountryResidence,
            // 'ID_DateofIssue' => $testing[0]->ID_DateofIssue,

            //KYC
            // 'IDNUMBER' => $testing[0]->IDNUMBER,
            'MaritalStatusDesc' => $testing != '' ? $testing[0]->MaritalStatusDesc : null,
            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,
            'Sources' => $testing != '' ? $testing[0]->Sources : null,
            'TotalSourcesUsed' => $testing != '' ? $testing[0]->TotalSourcesUsed : null,
            //Indicate ID success (If 1 then yes, if 0 then No)
            // 'Identity_status' => $testing != '' ? $testing[0]->Identity_status : null,
            //Indicate KYC success (If 1 then yes, if 0 then No)
            'KYCStatusInd' => $testing != '' ? $testing[0]->KYCStatusInd : null,
            'KYCStatusDesc' => $testing != '' ? $testing[0]->KYCStatusDesc : null,
            'IDStatus' => $testing != '' ? $testing[0]->IDStatus : null,
            'IDStatusInd' => $testing != '' ? $testing[0]->IDStatusInd : null,
            'IDStatusDesc' => $testing != '' ? $testing[0]->IDStatusDesc : null,

            //Bank Account Details
            'Account_no' => $testing != '' ? $testing[0]->Account_no : null,
            'Branch_code' => $testing != '' ? $testing[0]->Branch_code : null,
            'Bank_name' => $testing != '' ? $testing[0]->Bank_name : null,
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTDORMANT' => $testing != '' ? $testing[0]->ACCOUNTDORMANT : null,
            'AccountType' => $testing != '' ? $testing[0]->AccountType : null,
            'BankTypeid' => $testing != '' ? $testing[0]->BankTypeid : null,
            'Identity_Document_TYPE' => $testing != '' ? $testing[0]->Identity_Document_TYPE : null,
            'INITIALS' => $testing != '' ? $testing[0]->INITIALS : null,
            'Email' => $testing != '' ? $testing[0]->Email : null,
            'AVS_Status' => $testing != null ? $testing[0]->AVS_Status : '',
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $testing != '' ? $testing[0]->ACCOUNTOPENFORATLEASTTHREEMONTHS : null,
            'ACCOUNTACCEPTSDEBITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSDEBITS : null,
            'ACCOUNTACCEPTSCREDITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSCREDITS : null,
            'DeceasedStatus' => $testing != '' ? $testing[0]->DeceasedStatus : null,
            'EmployerDetail' => $testing != '' ? $testing[0]->EmployerDetail : null,

            //Facial Recognition
            'ConsumerIDPhotoMatch' => $testing != '' ? $testing[0]->ConsumerIDPhotoMatch : null,
            'MatchResponseCode' => $testing != '' ? $testing[0]->MatchResponseCode : null,
            'LivenessDetectionResult' => $testing != '' ? $testing[0]->LivenessDetectionResult : null,
            'Latitude' => $testing != '' ? $testing[0]->Latitude : null,
            'Longitude' => $testing != '' ? $testing[0]->Longitude : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,

            //Compliance
            'DATEOFDEATH' => $testing != '' ? $testing[0]->DATEOFDEATH : null,

            'KYC_Status' => $testing != '' ? $testing[0]->KYC_Status : null,
            'Compliance_Status' => $testing != '' ? $testing[0]->Compliance_Status : null,
            'DOVS_Status' => $testing != '' ? $testing[0]->DOVS_Status : null,
            'AVS_Status' => $testing != '' ? $testing[0]->AVS_Status : null,
        ];

        // $request->session()->put('insidedata', $insidedata);

        // app('debugbar')->info($insidedata);


        // $compliance = Compliance::where('HA_IDNO', '=', $idnumber)->first();
        // $getficabyCompliance = $compliance['FICA_id'];



        // app('debugbar')->info($ficaByCompliance);

        // $getcompliance = $useridentitynum['Consumerid'];

        // $fetchcompliance = DB::connection("sqlsrv2")->select('EXEC sp_ComplainceExtract ?', [$getcompliance]);



        // $fetchcompliance = DB::connection("sqlsrv2")->select(
        //     DB::raw("SET NOCOUNT ON; exec sp_ComplainceExtract :ConsumerId"),
        //     [
        //         ':ConsumerId' => '9D7BD1F9-DA38-4EB7-B49C-6AA0B109B2ED'
        //     ]
        // );

        // $LogicTest = DB::connection("sqlsrv2")->select(
        //     DB::raw("SET NOCOUNT ON; exec SP_Consumerresults :ConsumerId"),
        //     [
        //         ':ConsumerId' => $SearchConsumerID
        //     ]
        // );


        // app('debugbar')->info($fetchcompliance);


        // $getWorkNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 10)->where('RecordStatusInd', '=', 1)->first();
        // $getHomeNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 11)->where('RecordStatusInd', '=', 1)->first();
        // $getCellNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 12)->where('RecordStatusInd', '=', 1)->first();

        // $ContactNumbers = [

        //     'WorkNumberCode' => $getWorkNumber != null ? $getWorkNumber['TelephoneCode'] : null,
        //     'WorkNumber' => $getWorkNumber != null ? $getWorkNumber['TelephoneNo'] : null,
        //     'HomeNumberCode' => $getHomeNumber != null ? $getHomeNumber['TelephoneCode'] : null,
        //     'HomeNumber' => $getHomeNumber != null ? $getHomeNumber['TelephoneNo'] : null,
        //     'CellNumberCode' => $getCellNumber != null ? $getCellNumber['TelephoneCode'] : null,
        //     'CellNumber' => $getCellNumber != null ? $getCellNumber['TelephoneNo'] : null

        // ];

        // app('debugbar')->info($getWorkNumber);
        // app('debugbar')->info($getHomeNumber);
        // app('debugbar')->info($getCellNumber);
        // app('debugbar')->info($ContactNumbers);

        // $request->session()->put('ContactNumbers', $ContactNumbers);

        // $WorkNumberCode = $getWorkNumber['TelephoneCode'];
        // $WorkNumber = $getWorkNumber['TelephoneNo'];

        // $HomeNumberCode = $getHomeNumber['TelephoneCode'];
        // $HomeNumber = $getHomeNumber['TelephoneNo'];

        // $CellNumberCode = $getCellNumber['TelephoneCode'];
        // $CellNumber = $getCellNumber['TelephoneNo'];

        $FetchCompliance = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec sp_ComplianceExtract :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );

        $ComplianceData = [
            'EnquiryDate' => $FetchCompliance != null ? $FetchCompliance[0]->EnquiryDate : '',
            'EnquiryInput' => $FetchCompliance != null ? $FetchCompliance[0]->EnquiryInput : '',

            'VerifFirstName' => $FetchCompliance != null ? $FetchCompliance[0]->HA_Names : '',
            'VerifSurname' => $FetchCompliance != null ? $FetchCompliance[0]->HA_Surname : '',
            'VerifDeseaStat' => $FetchCompliance != null ? $FetchCompliance[0]->HA_DeceasedStatus : '',
            'VerifDeseaDate' => $FetchCompliance != null ? $FetchCompliance[0]->HA_DeceasedDate : '',
            'VerifDeathCause' => $FetchCompliance != null ? $FetchCompliance[0]->HA_Causeofdeath : '',
        ];

        $request->session()->put('ComplianceData', $ComplianceData);

        $FetchComplianceSanct = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec sp_ComplianceExtract_Sanction :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );

        $FetchComplianceAdd = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec sp_ComplianceExtract_sanctionentity :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );

        // $Additional_type_output = array_map(function ($FetchComplianceAdd) { return $FetchComplianceAdd->Additional_type; }, $FetchComplianceAdd);
        // $Additional_value_output = array_map(function ($FetchComplianceAdd) { return $FetchComplianceAdd->Additional_value; }, $FetchComplianceAdd);
        // $Additional_comment_output = array_map(function ($FetchComplianceAdd) { return $FetchComplianceAdd->Additional_comment; }, $FetchComplianceAdd);

        // $request->session()->put('Additional_type_output', $Additional_type_output);
        // $request->session()->put('Additional_value_output', $Additional_value_output);
        // $request->session()->put('Additional_comment_output', $Additional_comment_output);

        // app('debugbar')->info($FetchComplianceSanct);
        // app('debugbar')->info($Additional_type_output);
        // app('debugbar')->info($Additional_value_output);
        // app('debugbar')->info($Additional_comment_output);

        $request->session()->put('FetchComplianceSanct', $FetchComplianceSanct);
        $request->session()->put('FetchComplianceAdd', $FetchComplianceAdd);

        // app('debugbar')->info($FetchCompliance);
        // app('debugbar')->info($FetchComplianceSanct);
        // app('debugbar')->info($FetchComplianceAdd);


        $getRiskStatusbyFICA = FICA::where('FICA_id', '=', $SearchFica)->first();
        $FICAStatusbyFICA = $getRiskStatusbyFICA['FICAStatus'];
        $RiskStatusbyFICA = $getRiskStatusbyFICA['Risk_Status'];
        $ProgressbyFICA = $getRiskStatusbyFICA['FICAProgress'];

        // app('debugbar')->info($RiskStatusbyFICA);

        $ProgressbyFICA = $ProgressbyFICA * 10;

        $request->session()->put('FICAStatusbyFICA', $FICAStatusbyFICA);
        $request->session()->put('RiskStatusbyFICA', $RiskStatusbyFICA);
        $request->session()->put('ProgressbyFICA', $ProgressbyFICA);

        // $getRiskStatusbyConsumerID = FICA::where('Consumerid', '=', $SearchConsumerID)->first();
        // $FICAStatusbyConsumerID = $getRiskStatusbyConsumerID['FICAStatus'];
        // $RiskStatusbyConsumerID = $getRiskStatusbyConsumerID['Risk_Status'];
        // $RiskStatusbyConsumerID = $getRiskStatusbyConsumerID['KYC_Status'];


        // app('debugbar')->info($ProgressbyFICA);
        // app('debugbar')->info($FICAStatusbyFICA);
        // app('debugbar')->info($RiskStatusbyFICA);
        // app('debugbar')->info($FICAStatusbyConsumerID);
        // app('debugbar')->info($RiskStatusbyConsumerID);
        // app('debugbar')->info($getRiskStatusbyConsumerID);




        // $EnqDate = $ficaByCompliance['EnquiryDate'];
        // $EnqInput = $ficaByCompliance['EnquiryInput'];

        // $VerifFirstName = $ficaByCompliance['HA_Names'];
        // $VerifSurname = $ficaByCompliance['HA_Surname'];
        // $VerifDeseaStat = $ficaByCompliance['HA_DeceasedStatus'];
        // $VerifDeseaDate = $ficaByCompliance['HA_DeceasedDate'];
        // $VerifDeathCause = $ficaByCompliance['HA_Causeofdeath'];


        // $testuser1 = ConsumerComplianceSanction::where('ID', '=', '7711025013082')->first();
        // $testuser2 = Compliance::where('FICA_id', '=', 'A8A1550B-7B40-44E9-9E8A-11F564523B38')->first();


        // app('debugbar')->info($testuser1);
        // app('debugbar')->info($testuser2);


        // $getficaByCompliance = Compliance::where('FICA_id', '=', $SearchFica)->first();
        // $ficaByCompliance = $getficaByCompliance['Compliance_id'];

        // app('debugbar')->info($getficaByCompliance);

        // $sanctions = ConsumerComplianceSanction::where('Compliance_id', '=', $ficaByCompliance)->first();
        // $getCompliancebyID = $sanctions['Compliance_id'];

        // app('debugbar')->info($sanctions);

        // $CompliancebyID = ConsumerComplianceSanction::where('Compliance_id', '=', $getCompliancebyID)->first();
        // $setCompliancebyID = $CompliancebyID['Compliance_id'];

        // app('debugbar')->info($getCompliancebyID);
        // app('debugbar')->info($CompliancebyID);

        // $res = ConsumerComplianceSanction::join('Entity_type','Gender','Entityname','BestNameScore','Comments', '=', 'ReasonListed')
        // ->where('Compliance_id', '=', $sanctions->Compliance_id)
        // ->groupBy('ReasonListed')
        // ->get();

        // $getSancComp = ConsumerComplianceSanction::where('Compliance_id', '=', $sanctions->Compliance_id)->select('ReasonListed')->get();

        // $getSancComp = ConsumerComplianceSanction::where('Compliance_id', '=', $sanctions->Compliance_id)->where('ReasonListed', '=', $sanctions->ReasonListed)->get();

        // $distinct = ConsumerComplianceSanction::distinct('ReasonListed')->count('ReasonListed')->get();



        // $distinct = ConsumerComplianceSanction::distinct('ReasonListed')->where('Compliance_id', '=', $sanctions->Compliance_id)->get();


        // $getSancComp = ConsumerComplianceSanction::where('Compliance_id', '=', $sanctions->Compliance_id)->select('ReasonListed')->distinct()->get();

        // $distinct = ConsumerComplianceSanction::where('Compliance_id', '=', $getCompliancebyID)
        // ->select('Date_Listed', 'ReasonListed', 'Entity_type', 'Gender', 'Entityname', 'BestNameScore', 'Comments')
        // ->distinct('ReasonListed')
        // ->get();

        // app('debugbar')->info($distinct);



        // $EntID = $sanctions['ID'];
        // $DateListed = $sanctions['Date_Listed'];
        // $EntType = $sanctions['Entity_type'];
        // $EntGender = $sanctions['Gender'];
        // $EntName = $sanctions['Entityname'];
        // $EntScore = $sanctions['BestNameScore'];
        // $EntUniID = $sanctions['EntityUniqueID'];
        // $ReasonListed = $sanctions['ReasonListed'];
        // $ResultDate = $sanctions['ResultDate'];
        // $ListRefNum = $sanctions['ListReferenceNumber'];
        // $Comments = $sanctions['Comments'];



        $getEntbyFICA = Compliance::where('FICA_id', '=', $SearchFica)->first();
        $EntbyFICA = $getEntbyFICA['Compliance_id'];

        $getEntAddInfo = ConsumerComplianceEntityAdditional::where('Compliance_id', '=', $EntbyFICA)->get();



        // $getEntFICA = Compliance::where('HA_IDNO', '=', $idnumber)->where('IsRead', '=', '1')->get();


        //Get string length for if-statement

        $strA = $testing != null ? $testing[0]->ResidentialAddress : '';
        $residential = "";
        $arrA = explode("|", $strA);


        if (strlen($arrA[0]) == 10) {

            $residential = 'Confirmed';
        } else {
            $residential = 'Not Confirmed';
        }

        $request->session()->put('residential', $residential);

        // app('debugbar')->info($residential);

        // KYC PDF REPORT
        $request->session()->put('maritialstatus', $testing != null ? $testing[0]->MaritalStatusDesc : '');
        $request->session()->put('nationality', $testing != null ? $testing[0]->Nationality : '');
        $request->session()->put('ResidentialAddress', $testing != null ? $testing[0]->ResidentialAddress : '');
        $request->session()->put('Sources', $testing != null ? $testing[0]->Sources : '');
        $request->session()->put('TotalSourcesUsed', $testing != null ? $testing[0]->TotalSourcesUsed : '');
        $request->session()->put('IDStatus', $testing != null ? $testing[0]->IDStatus : '');
        $request->session()->put('KYCStatusInd', $testing != null ? $testing[0]->KYCStatusInd : '');

        //BANKING PDF REPORT
        $request->session()->put('Account_no', $testing != null ? $testing[0]->Account_no : '');
        $request->session()->put('Branch_code', $testing != null ? $testing[0]->Branch_code : '');
        $request->session()->put('AccountType', $testing != null ? $testing[0]->AccountType : '');
        $request->session()->put('Bank_name', $testing != null ? $testing[0]->Bank_name : '');
        $request->session()->put('ACCOUNT_OPEN', $testing != null ? $testing[0]->ACCOUNT_OPEN : '');
        $request->session()->put('Identity_Document_TYPE', $testing != null ? $testing[0]->Identity_Document_TYPE : '');
        $request->session()->put('INITIALS', $testing != null ? $testing[0]->INITIALS : '');
        $request->session()->put('SURNAME', $testing != null ? $testing[0]->SURNAME : '');
        $request->session()->put('IDNUMBER', $testing != null ? $testing[0]->IDNUMBER : '');
        $request->session()->put('Email', $testing != null ? $testing[0]->Email : '');
        $request->session()->put('Tax_Number', $testing != null ? $testing[0]->Tax_Number : '');
        $request->session()->put('ACCOUNT_OPEN', $testing != null ? $testing[0]->ACCOUNT_OPEN : '');
        $request->session()->put('ACCOUNTDORMANT', $testing != null ? $testing[0]->ACCOUNTDORMANT : '');
        $request->session()->put('ACCOUNTOPENFORATLEASTTHREEMONTHS', $testing != null ? $testing[0]->ACCOUNTOPENFORATLEASTTHREEMONTHS : '');
        $request->session()->put('ACCOUNTACCEPTSDEBITS', $testing != null ? $testing[0]->ACCOUNTACCEPTSDEBITS : '');
        $request->session()->put('ACCOUNTACCEPTSCREDITS', $testing != null ? $testing[0]->ACCOUNTACCEPTSCREDITS : '');
        $request->session()->put('Bank_name', $testing != null ? $testing[0]->Bank_name : '');
        $request->session()->put('BankTypeid', $testing != null ? $testing[0]->BankTypeid : '');

        //Facial Recognition

        $request->session()->put('ConsumerIDPhotoMatch', $testing != null ? $testing[0]->ConsumerIDPhotoMatch : '');
        $request->session()->put('DeceasedStatus', $testing != null ? $testing[0]->DeceasedStatus : '');
        $request->session()->put('MatchResponseCode', $testing != null ? $testing[0]->MatchResponseCode : '');
        $request->session()->put('LivenessDetectionResult', $testing != null ? $testing[0]->LivenessDetectionResult : '');
        $request->session()->put('Latitude', $testing != null ? $testing[0]->Latitude : '');
        $request->session()->put('Longitude', $testing != null ? $testing[0]->Longitude : '');

        // app('debugbar')->info($insidedata);

        // app('debugbar')->info($output_data1);
        // app('debugbar')->info($output_data2);
        // app('debugbar')->info($output_data3);
        // app('debugbar')->info($output_data4);
        // app('debugbar')->info($output_data5);
        // app('debugbar')->info($output_data6);

        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');


        // $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return view('admin-tabs', [])

            ->with($insidedata)
            // ->with($ComplianceData)

            ->with('residential', $residential)
            ->with('maleval', $maleval)
            ->with('femaleval', $femaleval)
            ->with('TitleDesc', $TitleDesc)
            // ->with('NotificationLink', $NotificationLink)
            ->with('IDDoc', $IDDoc)
            ->with('AddressDoc', $AddressDoc)
            ->with('BankDoc', $BankDoc)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with('SNameMatch', $SNameMatch)
            ->with('IDMatch', $IDMatch)
            ->with('EmailMatch', $EmailMatch)
            ->with('TaxNumMatch', $TaxNumMatch)


            // ->with('chequeaccTxt', $chequeaccTxt)
            // ->with('chequeaccTxt', $savingsaccTxt)
            // ->with('transmissionTxt', $transmissionTxt)
            // ->with('bondTxt', $bondTxt)
            // ->with('subscrTxt', $subscrTxt)

            ->with('chequeaccVal', $chequeaccVal)
            ->with('savingsaccVal', $savingsaccVal)
            ->with('transmissionVal', $transmissionVal)
            ->with('bondVal', $bondVal)
            ->with('subscrVal', $subscrVal)

            // ->with('Additional_type_output', $Additional_type_output)
            // ->with('Additional_value_output', $Additional_value_output)
            // ->with('Additional_comment_output', $Additional_comment_output)

            // ->with('EnqDate', $EnqDate)
            // ->with('EnqInput', $EnqInput)

            // ->with('VerifFirstName', $VerifFirstName)
            // ->with('VerifSurname', $VerifSurname)
            // ->with('VerifDeseaStat', $VerifDeseaStat)
            // ->with('VerifDeseaDate', $VerifDeseaDate)
            // ->with('VerifDeathCause', $VerifDeathCause)

            // ->with('EntID', $EntID)
            // ->with('DateListed', $DateListed)
            // ->with('EntType', $EntType)
            // ->with('EntGender', $EntGender)
            // ->with('EntName', $EntName)
            // ->with('EntScore', $EntScore)
            // ->with('EntUniID', $EntUniID)
            // ->with('ReasonListed', $ReasonListed)
            // ->with('ResultDate', $ResultDate)
            // ->with('ListRefNum', $ListRefNum)
            // ->with('Comments', $Comments)

            // ->with('WorkNumberCode', $WorkNumberCode)
            // ->with('WorkNumber', $WorkNumber)
            // ->with('HomeNumberCode', $HomeNumberCode)
            // ->with('HomeNumber', $HomeNumber)
            // ->with('CellNumberCode', $CellNumberCode)
            // ->with('CellNumber', $CellNumber)

            // ->with($ContactNumbers)
            ->with($ComplianceData)

            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)

            ->with('ConsumerIDPhoto', $ConsumerIDPhoto)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)

            ->with('accounttype', $accounttype)

            ->with('FetchComplianceSanct', $FetchComplianceSanct)
            ->with('FetchComplianceAdd', $FetchComplianceAdd)

            ->with('getEntAddInfo', $getEntAddInfo)
            // ->with('distinct', $distinct)

            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname);
    }

    public function StoredProc($SearchConsumerID)
    {

        $testing  = DB::connection("sqlsrv2")->select(
            DB::raw("SET NOCOUNT ON; exec SP_Consumerresults :ConsumerId"),
            [
                ':ConsumerId' => $SearchConsumerID
            ]
        );

        $insidedata = [

            'FirstName' => $testing != '' ? $testing[0]->FirstName : null,
            'SURNAME' => $testing != '' ? $testing[0]->SURNAME : null,
            'SecondName' => $testing != '' ? $testing[0]->SecondName : null,

            'Gender' => $testing != '' ? $testing[0]->Gender : null,

            // Residence Address
            'Res_OriginalAdd1' => $testing != '' ? $testing[0]->Res_OriginalAdd1 : null,
            'Res_OriginalAdd2' => $testing != '' ? $testing[0]->Res_OriginalAdd2 : null,
            'Res_OriginalAdd3' => $testing != '' ? $testing[0]->Res_OriginalAdd3 : null,
            'Res_Pcode' => $testing != '' ? $testing[0]->Res_Pcode : null,
            'ResProvince' => $testing != '' ? $testing[0]->ResProvince : null,

            // Postal Address
            'Post_OriginalAdd1' => $testing != '' ? $testing[0]->Post_OriginalAdd1 : null,
            'Post_OriginalAdd2' => $testing != '' ? $testing[0]->Post_OriginalAdd2 : null,
            'Post_OriginalAdd3' => $testing != '' ? $testing[0]->Post_OriginalAdd3 : null,
            'Post_Pcode' => $testing != '' ? $testing[0]->Post_Pcode : null,
            'PostProvince' => $testing != '' ? $testing[0]->PostProvince : null,

            // Work Address
            'Work_OriginalAdd1' => $testing != '' ? $testing[0]->Work_OriginalAdd1 : null,
            'Work_OriginalAdd2' => $testing != '' ? $testing[0]->Work_OriginalAdd2 : null,
            'Work_OriginalAdd3' => $testing != '' ? $testing[0]->Work_OriginalAdd3 : null,
            'Work_Pcode' => $testing != '' ? $testing[0]->Work_Pcode : null,
            'WorkProvince' => $testing != '' ? $testing[0]->WorkProvince : null,

            'Nameofemployer' => $testing != '' ? $testing[0]->Nameofemployer : null,
            'Employmentstatus' => $testing != '' ? $testing[0]->Employmentstatus : null,
            'Industryofoccupation' => $testing != '' ? $testing[0]->Industryofoccupation : null,
            'Marriage_date' => $testing != '' ? $testing[0]->Marriage_date : null,
            'Married_under' => $testing != '' ? $testing[0]->Married_under : null,
            'IDNUMBER' => $testing != '' ? $testing[0]->IDNUMBER : null,
            'Email' => $testing != '' ? $testing[0]->Email : null,

            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'DOB' => $testing != '' ? $testing[0]->DOB : null,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            'ID_DateofIssue' => $testing != '' ? $testing[0]->ID_DateofIssue : null,

            'CellCode' => $testing != '' ? $testing[0]->CellCode : null,
            'CellNo' => $testing != '' ? $testing[0]->CellNo : null,
            'HomeTelCode' => $testing != '' ? $testing[0]->HomeTelCode : null,
            'HomeTelNo' => $testing != '' ? $testing[0]->HomeTelNo : null,
            'WorkTelCode' => $testing != '' ? $testing[0]->WorkTelCode : null,
            'WorkTelNo' => $testing != '' ? $testing[0]->WorkTelNo : null,

            //KYC

            'MaritalStatusDesc' => $testing != '' ? $testing[0]->MaritalStatusDesc : null,
            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,
            'Sources' => $testing != '' ? $testing[0]->Sources : null,
            'TotalSourcesUsed' => $testing != '' ? $testing[0]->TotalSourcesUsed : null,
            'Identity_status' => $testing != '' ? $testing[0]->Identity_status : null,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            'Identity_Document_TYPE' => $testing != '' ? $testing[0]->Identity_Document_TYPE : null,

            //Bank Account Details
            'Bank_name' => $testing != '' ? $testing[0]->Bank_name : null,
            'Branch' => $testing != '' ? $testing[0]->Branch : null,
            'Branch_code' => $testing != '' ? $testing[0]->Branch_code : null,
            'Account_no' => $testing != '' ? $testing[0]->Account_no : null,
            'Account_name' => $testing != '' ? $testing[0]->Account_name : null,
            'Tax_Oblig_outside_SA' => $testing != '' ? $testing[0]->Tax_Oblig_outside_SA : null,
            'BankTypeid' => $testing != '' ? $testing[0]->BankTypeid : null,
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $testing != '' ? $testing[0]->ACCOUNTOPENFORATLEASTTHREEMONTHS : null,
            'ACCOUNTACCEPTSDEBITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSDEBITS : null,
            'ACCOUNTACCEPTSCREDITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSCREDITS : null,

            //Screening

            'Tax_Number' => $testing != '' ? $testing[0]->Tax_Number : null,
            'Foreign_Tax_Number' => $testing != '' ? $testing[0]->Foreign_Tax_Number : null,

            'Public_official' => $testing != '' ? $testing[0]->Public_official : null,
            'Public_official_Family' => $testing != '' ? $testing[0]->Public_official_Family : null,

            'Public_official_type_DPIP' => $testing != '' ? $testing[0]->Public_official_type_DPIP : null,
            'Public_official_type_FPPO' => $testing != '' ? $testing[0]->Public_official_type_FPPO : null,
            'Public_official_type_family_DPIP' => $testing != '' ? $testing[0]->Public_official_type_family_DPIP : null,
            'Public_official_type_family_FPPO' => $testing != '' ? $testing[0]->Public_official_type_family_FPPO : null,

            'SanctionList' => $testing != '' ? $testing[0]->SanctionList : null,
            'AdverseMedia' => $testing != '' ? $testing[0]->AdverseMedia : null,
            'NonResidentOther' => $testing != '' ? $testing[0]->NonResidentOther : null,

            'ClientDueDiligence' => $testing != '' ? $testing[0]->ClientDueDiligence : null,
            'NomineeDeclaration' => $testing != '' ? $testing[0]->NomineeDeclaration : null,
            'IssuerCommunication' => $testing != '' ? $testing[0]->IssuerCommunication : null,
            'CustodyService' => $testing != '' ? $testing[0]->CustodyService : null,
            'SegregatedDeposit' => $testing != '' ? $testing[0]->SegregatedDeposit : null,
            'DividendTax' => $testing != '' ? $testing[0]->DividendTax : null,
            'BeeShareholder' => $testing != '' ? $testing[0]->BeeShareholder : null,
            'StampDuty' => $testing != '' ? $testing[0]->StampDuty : null,
            'Broker' => $testing != '' ? $testing[0]->Broker : null,
            'CommunicationType' => $testing != '' ? $testing[0]->CommunicationType : null,
            'BrokerContact' => $testing != '' ? $testing[0]->BrokerContact : null,
            'EMAILMATCH' => $testing != '' ? $testing[0]->EMAILMATCH : null,

            //KYC
            // 'IDNUMBER' => $testing[0]->IDNUMBER,
            'MaritalStatusDesc' => $testing != '' ? $testing[0]->MaritalStatusDesc : null,
            'Nationality' => $testing != '' ? $testing[0]->Nationality : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,
            'Sources' => $testing != '' ? $testing[0]->Sources : null,
            'TotalSourcesUsed' => $testing != '' ? $testing[0]->TotalSourcesUsed : null,
            'KYCStatusInd' => $testing != '' ? $testing[0]->KYCStatusInd : null,
            'KYCStatusDesc' => $testing != '' ? $testing[0]->KYCStatusDesc : null,
            'IDStatus' => $testing != '' ? $testing[0]->IDStatus : null,
            'IDStatusInd' => $testing != '' ? $testing[0]->IDStatusInd : null,
            'IDStatusDesc' => $testing != '' ? $testing[0]->IDStatusDesc : null,

            //Bank Account Details
            'Account_no' => $testing != '' ? $testing[0]->Account_no : null,
            'Branch_code' => $testing != '' ? $testing[0]->Branch_code : null,
            'Bank_name' => $testing != '' ? $testing[0]->Bank_name : null,
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTDORMANT' => $testing != '' ? $testing[0]->ACCOUNTDORMANT : null,
            'AccountType' => $testing != '' ? $testing[0]->AccountType : null,
            'BankTypeid' => $testing != '' ? $testing[0]->BankTypeid : null,
            'Identity_Document_TYPE' => $testing != '' ? $testing[0]->Identity_Document_TYPE : null,
            'INITIALS' => $testing != '' ? $testing[0]->INITIALS : null,
            'Email' => $testing != '' ? $testing[0]->Email : null,
            'AVS_Status' => $testing != null ? $testing[0]->AVS_Status : '',
            'ACCOUNT_OPEN' => $testing != '' ? $testing[0]->ACCOUNT_OPEN : null,
            'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $testing != '' ? $testing[0]->ACCOUNTOPENFORATLEASTTHREEMONTHS : null,
            'ACCOUNTACCEPTSDEBITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSDEBITS : null,
            'ACCOUNTACCEPTSCREDITS' => $testing != '' ? $testing[0]->ACCOUNTACCEPTSCREDITS : null,
            'DeceasedStatus' => $testing != '' ? $testing[0]->DeceasedStatus : null,
            'EmployerDetail' => $testing != '' ? $testing[0]->EmployerDetail : null,

            //Facial Recognition
            'ConsumerIDPhotoMatch' => $testing != '' ? $testing[0]->ConsumerIDPhotoMatch : null,
            'MatchResponseCode' => $testing != '' ? $testing[0]->MatchResponseCode : null,
            'LivenessDetectionResult' => $testing != '' ? $testing[0]->LivenessDetectionResult : null,
            'Latitude' => $testing != '' ? $testing[0]->Latitude : null,
            'Longitude' => $testing != '' ? $testing[0]->Longitude : null,
            'ResidentialAddress' => $testing != '' ? $testing[0]->ResidentialAddress : null,

            //Compliance
            'DATEOFDEATH' => $testing != '' ? $testing[0]->DATEOFDEATH : null,

            'KYC_Status' => $testing != '' ? $testing[0]->KYC_Status : null,
            'Compliance_Status' => $testing != '' ? $testing[0]->Compliance_Status : null,
            'DOVS_Status' => $testing != '' ? $testing[0]->DOVS_Status : null,
            'AVS_Status' => $testing != '' ? $testing[0]->AVS_Status : null,
        ];

        return $insidedata;
    }

    public function PersonalDetailsUpdate(Request $request)
    {



        // $Consumerid = $request->session()->get('LoggedUser');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $Consumerid)->where('IsRead', '=', '1')->get();

        // $idnumber = $request->input('idnumberResult');
        // //$consumerid = 2D12F5FB-BE59-4A50-BD6A-3896720D8F89;
        // $consumer = Consumer::where('IDNUMBER', '=',  $idnumber)->first();

        // $personal2 = DB::connection(sqlsrv2)->select('TBL_Consumer')->where('IDNUMBER', '=',  $idnumber)->first()->update('FirstName', $request->FirstName);

        // $personal = Consumer::where('IDNUMBER', '=',  $idnumber)->first()->update(['FirstName' => $FirstName['FirstName']]);

        // $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $userfica = AVS::where('FICA_id', '=', $SearchFica)->first();
        // $userconsumerid = Address::where('Consumerid', '=', $SearchConsumerID)->first();

        // $userid = Consumer::where('IDNUMBER', '=', $idnumber)->first();

        // $userdateissue = ['ID_DateofIssue' => $useridentitynum->ID_DateofIssue]; 



        //----------------------------------------------------- PERSONAL ----------------------------------------------

        // $personalDetails = Consumer::where('Consumerid', '=',  $userconsumerid->Consumerid)->where('Readonly', '=', 0)->first();


        // // app('debugbar')->info($homeAddress);

        // //Check if addresses exist
        // $homeAddressExist =  $personalDetails != null ? true : false;


        // // HOME ADDRESS
        // if ($homeAddressExist == true) {
        //     if (
        //         $personalDetails->FirstName == $request->FirstName && $personalDetails->SURNAME == $request->SURNAME &&
        //         $personalDetails->SecondName == $request->SecondName && $personalDetails->GenderInd == $request->GenderInd &&
        //         $personalDetails->Email == $request->Email && $personalDetails->Married_under == $request->Married_under &&
        //         $personalDetails->Marriage_date == $request->Marriage_date && $personalDetails->Employmentstatus == $request->Employmentstatus &&
        //         $personalDetails->Nameofemployer == $request->Nameofemployer && $personalDetails->Industryofoccupation == $request->Industryofoccupation
        //     ) {
        //     } else {
        //         // app('debugbar')->info('Address testing');
        //         //If Home Address Exist change the RecordStatusInd to 0
        //         Consumer::where("ConsumerUSERID", $personalDetails->USERID)->update(['Readonly' => 0]);
        //         $HomeAddress = Consumer::create([
        //             'Consumerid' => $userconsumerid->Consumerid,
        //             'FirstName' => $request->FirstName,
        //             'SURNAME' => $request->SURNAME,
        //             'SecondName' => $request->SecondName,
        //             'GenderInd' => $request->GenderInd,
        //             'Email' => $request->Email,
        //             // 'DOB' => date(Y-m-d, strtotime($request->DOB)),
        //             'Married_under' => $request->Married_under,
        //             'Marriage_date' => date("Y-m-d", strtotime($request->Marriage_date)),

        //             // 'FaxNumber' => $request->FaxNumber,

        //             'Employmentstatus' => $request->Employmentstatus,
        //             'Nameofemployer' => $request->Nameofemployer,
        //             // 'EmpPostalCode' => $request->EmpPostalCode,
        //             // 'EmployerAddress' => $request->EmployerAddress,
        //             'Industryofoccupation' => $request->Industryofoccupation,

        //             'Readonly' => 1,
        //             'CreatedOnDate' => date("Y-m-d H:i:s"),
        //             'LastUpdatedDate' => date("Y-m-d H:i:s"),
        //         ]);
        //     }
        // } else {
        //     if (isset($request->FirstName) && isset($request->SURNAME) && isset($request->GenderInd) && isset($request->Email) && isset($request->Married_under) &&
        //     (date("Y-m-d", strtotime($request->Marriage_date))) && isset($request->Employmentstatus) && isset($request->Nameofemployer) && isset($request->Industryofoccupation)) {
        //         $PersonalDetail = Consumer::create([
        //             'Consumerid' => $userconsumerid->Consumerid,
        //             'FirstName' => $request->FirstName,
        //             'SURNAME' => $request->SURNAME,
        //             'SecondName' => $request->SecondName,
        //             'GenderInd' => $request->GenderInd,
        //             'Email' => $request->Email,

        //             // 'DOB' => date(Y-m-d, strtotime($request->DOB)),
        //             'Married_under' => $request->Married_under,
        //             'Marriage_date' => date("Y-m-d", strtotime($request->Marriage_date)),

        //             // 'FaxNumber' => $request->FaxNumber,

        //             'Employmentstatus' => $request->Employmentstatus,
        //             'Nameofemployer' => $request->Nameofemployer,
        //             // 'EmpPostalCode' => $request->EmpPostalCode,
        //             // 'EmployerAddress' => $request->EmployerAddress,
        //             'Industryofoccupation' => $request->Industryofoccupation,

        //             'Readonly' => 1,
        //             'CreatedOnDate' => date("Y-m-d H:i:s"),
        //             'LastUpdatedDate' => date("Y-m-d H:i:s"),
        //         ]);
        //     }
        // }

        //-----------------------------------------------------END PERSONAL ----------------------------------------------


        // $testthething = ConsumerIdentity::where('FICA_id', '=',  $SearchFica)->first();

        // dd($request);

        $idnumber = $request->session()->get('idnumber');
        $SearchConsumerID = $request->session()->get('SearchConsumerID');
        $SearchFica = $request->session()->get('SearchFica');

        KYC::where('FICA_id', '=',  $SearchFica)->update(
            array(

                'Gender' => $request->Gender,
                // 'MaritalStatusDesc' => $request->MaritalStatusDesc,

            )
        );

        ConsumerIdentity::where('FICA_id', '=',  $SearchFica)->update(
            array(

                'ID_CountryResidence' => $request->ID_CountryResidence,

            )
        );

        Consumer::where('Consumerid', '=',  $SearchConsumerID)->update(
            array(

                'FirstName' => $request->FirstName,
                'SURNAME' => $request->SURNAME,
                // 'SecondName' => $request->SecondName,
                // 'GenderInd' => $request->GenderInd,
                'Email' => $request->Email,
                // 'DOB' => date(Y-m-d, strtotime($request->DOB)),
                // 'Married_under' => $request->Married_under,
                // 'Marriage_date' => date("Y-m-d", strtotime($request->Marriage_date)),

                // 'FaxNumber' => $request->FaxNumber,

                'Employmentstatus' => $request->Employmentstatus,
                'Nameofemployer' => $request->Nameofemployer,
                'Industryofoccupation' => $request->Industryofoccupation,

            )

        );

        $WorkNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 10)->first();
        $HomeNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 11)->first();
        $CellNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 12)->first();

        $WorkNumberExist =  $WorkNumber != null ? true : false;
        $HomeNumberExist =  $HomeNumber != null ? true : false;
        $CellNumberExist =  $CellNumber != null ? true : false;

        // WORK NUMBER
        if ($WorkNumberExist == true) {
            if (
                $WorkNumber->TelephoneCode == substr($request->WorkTelephoneNo, 0, 3) &&
                $WorkNumber->TelephoneNo == substr($request->WorkTelephoneNo, 3, 10)
            ) {
            } else {
                // app('debugbar')->info('Work number testing');
                //If Work Number exists change the RecordStatusInd to 0
                Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 10)->update(['RecordStatusInd' => 0]);
                $WorkNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 10,
                    'TelephoneCode' => substr($request->WorkTelephoneNo, 0, 3),
                    'TelephoneNo' => substr($request->WorkTelephoneNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->WorkTelephoneNo)) {
                $WorkNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 10,
                    'TelephoneCode' => substr($request->WorkTelephoneNo, 0, 3),
                    'TelephoneNo' => substr($request->WorkTelephoneNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // HOME NUMBER
        if ($HomeNumberExist == true) {
            if (
                $HomeNumber->TelephoneCode == substr($request->HomeTelephoneNo, 0, 3) &&
                $HomeNumber->TelephoneNo == substr($request->HomeTelephoneNo, 3, 10)
            ) {
            } else {
                // app('debugbar')->info('Work number testing');
                //If Work Number exists change the RecordStatusInd to 0
                Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 11)->update(['RecordStatusInd' => 0]);
                $HomeNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 11,
                    'TelephoneCode' => substr($request->HomeTelephoneNo, 0, 3),
                    'TelephoneNo' => substr($request->HomeTelephoneNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->HomeTelephoneNo)) {
                $HomeNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 11,
                    'TelephoneCode' => substr($request->HomeTelephoneNo, 0, 3),
                    'TelephoneNo' => substr($request->HomeTelephoneNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // CELL NUMBER
        if ($CellNumberExist == true) {
            if (
                $CellNumber->TelephoneCode == substr($request->CellularNo, 0, 3) &&
                $CellNumber->TelephoneNo == substr($request->CellularNo, 3, 10)
            ) {
            } else {
                // app('debugbar')->info('Work number testing');
                //If Work Number exists change the RecordStatusInd to 0
                Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 12)->update(['RecordStatusInd' => 0]);
                $HomeNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 12,
                    'TelephoneCode' => substr($request->CellularNo, 0, 3),
                    'TelephoneNo' => substr($request->CellularNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->CellularNo)) {
                $HomeNumber = Telephones::create([
                    'ConsumerID' => $SearchConsumerID,
                    'TelephoneTypeInd' => 12,
                    'TelephoneCode' => substr($request->CellularNo, 0, 3),
                    'TelephoneNo' => substr($request->CellularNo, 3, 10),
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'ChangedonDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 10)->where('RecordStatusInd', '=', 1)->update(
        //     array(

        //     'TelephoneCode' => substr($request->WorkTelephoneNo, 0, 3),
        //     'TelephoneNo' => substr($request->WorkTelephoneNo, 3, 10),
        //     // 'HomeTelephoneNo' => $request->HomeTelephoneNo,
        //     // 'CellularNo' => $request->CellularNo,

        //     )
        // );

        // Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 11)->where('RecordStatusInd', '=', 1)->update(
        //     array(

        //     'TelephoneCode' => substr($request->HomeTelephoneNo, 0, 3),
        //     'TelephoneNo' => substr($request->HomeTelephoneNo, 3, 10),

        //     )
        // );

        // Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 12)->where('RecordStatusInd', '=', 1)->update(
        //     array(

        //     'TelephoneCode' => substr($request->CellularNo, 0, 3),
        //     'TelephoneNo' => substr($request->CellularNo, 3, 10),

        //     )
        // );

        // app('debugbar')->info($contact);

        // if (request()->filled('ID_DateofIssue')) {
        //     $update1['ID_DateofIssue'] = date("Y-m-d", strtotime($request->ID_DateofIssue));
        // } else {
        //     $update1['ID_DateofIssue'] = null;
        // }

        $insidedata = $this->StoredProc($SearchConsumerID);

        $ContactNumbers = $request->session()->get('ContactNumbers');
        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');

        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');

        $LogUserSurname = $request->session()->get('LogUserSurname');

        // $insidedata = $request->session()->get('insidedata');
        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');
        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');

        $kycstatus = $request->session()->get('kycstatus');
        $bankstatus = $request->session()->get('bankstatus');
        $facialrecognitionstatus = $request->session()->get('facialrecognitionstatus');
        $compliancestatus = $request->session()->get('compliancestatus');
        $residential = $request->session()->get('residential');
        $ConsumerIDPhoto = $request->session()->get('ConsumerIDPhoto');
        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');
        $ComplianceData = $request->session()->get('ComplianceData');
        $FetchComplianceSanct = $request->session()->get('FetchComplianceSanct');
        $FetchComplianceAdd = $request->session()->get('FetchComplianceAdd');
        $AddressDoc = $request->session()->get('AddressDoc');
        $BankDoc = $request->session()->get('BankDoc');
        $IDDoc = $request->session()->get('IDDoc');

        $SNameMatch = $request->session()->get('SNameMatch');
        $IDMatch = $request->session()->get('IDMatch');
        $EmailMatch = $request->session()->get('EmailMatch');
        $TaxNumMatch = $request->session()->get('TaxNumMatch');


        $TitleDesc = $request->session()->get('TitleDesc');

        // $this->TestResult($request);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // $Customerid = $request->session()->get('Customerid');
        $client = Auth::user();
        $Customerid = $client->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return view('admin-tabs')

            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)

            // ->with('NotificationLink', $NotificationLink)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with($insidedata)
            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)
            ->with('TitleDesc', $TitleDesc)

            ->with('SNameMatch', $SNameMatch)
            ->with('IDMatch', $IDMatch)
            ->with('EmailMatch', $EmailMatch)
            ->with('TaxNumMatch', $TaxNumMatch)

            ->with('kycstatus', $kycstatus)
            ->with('bankstatus', $bankstatus)
            ->with('facialrecognitionstatus', $facialrecognitionstatus)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('ConsumerIDPhoto', $ConsumerIDPhoto)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)
            ->with($ContactNumbers)
            ->with($ComplianceData)
            ->with('FetchComplianceSanct', $FetchComplianceSanct)
            ->with('FetchComplianceAdd', $FetchComplianceAdd)
            ->with('AddressDoc', $AddressDoc)
            ->with('BankDoc', $BankDoc)
            ->with('IDDoc', $IDDoc);
    }

    public function AddressDetailsUpdate(Request $request)
    {
        $idnumber = $request->session()->get('IDNUMBER');

        // $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $userconsumerid = Consumer::where('Consumerid', '=', $idnumber)->distinct()->first();
        // $userconsumerid = Consumer::select('Consumerid')->where('Consumerid', '=', $idnumber)->get();

        // $userconsumerid = Consumer::select(DB::raw('Consumerid'))
        //             ->where('Consumerid', '=', $idnumber)
        //             ->distinct()
        //             ->get();

        // $userconsumerid = Consumer::select(DB::raw('Consumerid'))
        //             ->where('Consumerid', '=', $idnumber)
        //             ->groupBy('Consumerid')
        //             ->get();

        // $Consumerid = $request->session()->get('LoggedUser');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $Consumerid)->where('IsRead', '=', '1')->get();

        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();
        $userconsumerid = Address::where('ConsumerID', '=', $useridentitynum->Consumerid)->first();

        // $consumerid = $request->input('ConsumerID');

        // $userfica = ConsumerAVS::where('FICA_id', '=', $useridentitynum->FICA_id)->first();

        // app('debugbar')->info($request->input(test));


        // ConsumerAddress::where('ConsumerID', '=',  $userconsumerid->ConsumerID)->update(
        //     array(

        //         // 'OriginalAddress1' => $request->OriginalAddress1,
        //         // 'OriginalAddress2' => $request->OriginalAddress2,
        //         // 'OriginalAddress3' => $request->OriginalAddress3,
        //         // 'OriginalPostalCode' => $request->OriginalPostalCode,
        //         // 'Province' => $request->input("test"),

        //         // Residence Address
        //         'OriginalAddress1' => $request->OriginalAddress1,
        //         'OriginalAddress2' => $request->OriginalAddress2,
        //         'OriginalAddress3' => $request->OriginalAddress3,
        //         'OriginalPostalCode' => $request->OriginalPostalCode,
        //         'Province' => $request->input("test1"),


        //         // Postal Address
        //         'OriginalAddress1' => $request->PostOriginalAddress1,
        //         'OriginalAddress2' => $request->PostOriginalAddress2,
        //         'OriginalAddress3' => $request->PostOriginalAddress3,
        //         'OriginalPostalCode' => $request->PostOriginalPostalCode,
        //         'Province' => $request->input("test2"),

        //         // Work Address
        //         'OriginalAddress1' => $request->WorkOriginalAddress1,
        //         'OriginalAddress2' => $request->WorkOriginalAddress2,
        //         'OriginalAddress3' => $request->WorkOriginalAddress3,
        //         'OriginalPostalCode' => $request->WorkOriginalPostalCode,
        //         'Province' => $request->input("test3"),

        //     )

        // );

        //----------------------------------------------------- ADDRESS ----------------------------------------------

        $homeAddress = Address::where('ConsumerID', '=',  $userconsumerid->ConsumerID)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
        $postalAddress = Address::where('ConsumerID', '=',  $userconsumerid->ConsumerID)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 15)->first();
        $workAddress = Address::where('ConsumerID', '=',  $userconsumerid->ConsumerID)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 14)->first();

        // app('debugbar')->info($homeAddress);

        //Check if addresses exist
        $homeAddressExist =  $homeAddress != null ? true : false;
        $postalAddressExist =  $postalAddress != null ? true : false;
        $workAddressExist =  $workAddress != null ? true : false;

        // HOME ADDRESS
        if ($homeAddressExist == true) {
            if (
                $homeAddress->OriginalAddress1 == $request->OriginalAddress1 && $homeAddress->OriginalAddress2 == $request->OriginalAddress2 &&
                $homeAddress->OriginalAddress3 == $request->OriginalAddress3 && $homeAddress->OriginalPostalCode == $request->OriginalPostalCode &&
                $homeAddress->Province == $request->ResProvince

            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Home Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $homeAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $HomeAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    // 'AddressTypeInd' => $addressLookUpHomeValue->Value,
                    'AddressTypeInd' => 16,
                    'OriginalAddress1' => $request->OriginalAddress1,
                    'OriginalAddress2' => $request->OriginalAddress2,
                    'OriginalAddress3' => $request->OriginalAddress3,
                    'Province' => $request->ResProvince,
                    'OriginalPostalCode' => $request->OriginalPostalCode,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->OriginalAddress1) && isset($request->OriginalAddress2) && isset($request->OriginalAddress3) && isset($request->ResProvince) && isset($request->OriginalPostalCode)) {
                $HomeAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    // 'AddressTypeInd' => $addressLookUpHomeValue->Value,
                    'AddressTypeInd' => 16,
                    'OriginalAddress1' => $request->OriginalAddress1,
                    'OriginalAddress2' => $request->OriginalAddress2,
                    'OriginalAddress3' => $request->OriginalAddress3,
                    'Province' => $request->ResProvince,
                    'OriginalPostalCode' => $request->OriginalPostalCode,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // POSTAL ADDRESS
        if ($postalAddressExist == true) {
            if (
                $postalAddress->OriginalAddress1 ==  $request->PostOriginalAddress1 && $postalAddress->OriginalAddress2 == $request->PostOriginalAddress2 &&
                $postalAddress->OriginalAddress3 == $request->PostOriginalAddress3  &&  $postalAddress->OriginalAddress4 == $request->PostOriginalPostalCode &&
                $postalAddress->OriginalPostalCode == $request->PostProvince
            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Postal Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $postalAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $PostalAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    'AddressTypeInd' => 15,
                    'OriginalAddress1' => $request->PostOriginalAddress1,
                    'OriginalAddress2' => $request->PostOriginalAddress2,
                    'OriginalAddress3' => $request->PostOriginalAddress3,
                    'OriginalPostalCode' => $request->PostOriginalPostalCode,
                    'Province' => $request->PostProvince,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->PostOriginalAddress1) && isset($request->PostOriginalAddress2) && isset($request->PostOriginalAddress3) &&  isset($request->PostOriginalPostalCode) && isset($request->PostProvince)) {
                $PostalAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    'AddressTypeInd' => 15,
                    'OriginalAddress1' => $request->PostOriginalAddress1,
                    'OriginalAddress2' => $request->PostOriginalAddress2,
                    'OriginalAddress3' => $request->PostOriginalAddress3,
                    'OriginalPostalCode' => $request->PostOriginalPostalCode,
                    'Province' => $request->PostProvince,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // WORK ADDRESS
        if ($workAddressExist == true) {
            if (
                $workAddress->OriginalAddress1 == $request->WorkOriginalAddress1 && $workAddress->OriginalAddress2 == $request->WorkOriginalAddress2 &&
                $workAddress->OriginalAddress3 == $request->WorkOriginalAddress3 && $workAddress->OriginalPostalCode == $request->WorkOriginalPostalCode &&
                $workAddress->OriginalAddress4 == $request->WorkProvince
            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Work Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $workAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $WorkAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    'AddressTypeInd' => 14,
                    'OriginalAddress1' => $request->WorkOriginalAddress1,
                    'OriginalAddress2' => $request->WorkOriginalAddress2,
                    'OriginalAddress3' => $request->WorkOriginalAddress3,
                    'OriginalPostalCode' => $request->WorkOriginalPostalCode,
                    'Province' => $request->WorkProvince,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($request->WorkOriginalAddress1) && isset($request->WorkOriginalAddress2) && isset($request->WorkOriginalAddress3) &&  isset($request->WorkOriginalPostalCode) && isset($request->WorkProvince)) {
                $WorkAddress = Address::create([
                    'ConsumerID' => $userconsumerid->ConsumerID,
                    'AddressTypeInd' => 14,
                    'OriginalAddress1' => $request->WorkOriginalAddress1,
                    'OriginalAddress2' => $request->WorkOriginalAddress2,
                    'OriginalAddress3' => $request->WorkOriginalAddress3,
                    'OriginalPostalCode' => $request->WorkOriginalPostalCode,
                    'Province' => $request->WorkProvince,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        //----------------------------------------------------- END ADDRESS ----------------------------------------------


        // $NotificationLink = $request->session()->get('NotificationLink');
        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');
        $Email = $request->session()->get('Email');

        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');

        $LogUserSurname = $request->session()->get('LogUserSurname');

        // $insidedata = $request->session()->get('insidedata');
        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');
        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');
        $TitleDesc = $request->session()->get('TitleDesc');

        $kycstatus = $request->session()->get('kycstatus');
        $bankstatus = $request->session()->get('bankstatus');
        $facialrecognitionstatus = $request->session()->get('facialrecognitionstatus');
        $compliancestatus = $request->session()->get('compliancestatus');
        $residential = $request->session()->get('residential');
        $ConsumerIDPhoto = $request->session()->get('ConsumerIDPhoto');
        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');
        $ComplianceData = $request->session()->get('ComplianceData');
        $FetchComplianceSanct = $request->session()->get('FetchComplianceSanct');
        $FetchComplianceAdd = $request->session()->get('FetchComplianceAdd');
        $AddressDoc = $request->session()->get('AddressDoc');
        $BankDoc = $request->session()->get('BankDoc');
        $IDDoc = $request->session()->get('IDDoc');

        $SNameMatch = $request->session()->get('SNameMatch');
        $IDMatch = $request->session()->get('IDMatch');
        $EmailMatch = $request->session()->get('EmailMatch');
        $TaxNumMatch = $request->session()->get('TaxNumMatch');


        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();
        $SearchConsumerID = $useridentitynum['Consumerid'];
        $ContactNumbers = $request->session()->get('ContactNumbers');

        $insidedata = $this->StoredProc($SearchConsumerID);


        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return view('admin-tabs')

            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)

            // ->with('NotificationLink', $NotificationLink)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with($insidedata)
            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)
            ->with('TitleDesc', $TitleDesc)

            ->with('SNameMatch', $SNameMatch)
            ->with('IDMatch', $IDMatch)
            ->with('EmailMatch', $EmailMatch)
            ->with('TaxNumMatch', $TaxNumMatch)


            ->with('kycstatus', $kycstatus)
            ->with('bankstatus', $bankstatus)
            ->with('facialrecognitionstatus', $facialrecognitionstatus)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('ConsumerIDPhoto', $ConsumerIDPhoto)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)
            ->with($ContactNumbers)
            ->with($ComplianceData)
            ->with('FetchComplianceSanct', $FetchComplianceSanct)
            ->with('FetchComplianceAdd', $FetchComplianceAdd)
            ->with('AddressDoc', $AddressDoc)
            ->with('BankDoc', $BankDoc)
            ->with('IDDoc', $IDDoc);
    }

    public function ScreeningDetailsCreate(Request $request)
    {


        $idnumber = $request->session()->get('IDNUMBER');
        $SearchFica = $request->session()->get('SearchFica');


        // $SearchConsumerID = $request->session()->get('SearchConsumerID');



        // $Consumerid = $request->session()->get('LoggedUser');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $Consumerid)->where('IsRead', '=', '1')->get();

        // $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $userfica = ConsumerAVS::where('FICA_id', '=', $useridentitynum->FICA_id)->first();
        // $userconsumerid = ConsumerFinancials::where('ConsumerFinancial', '=', $userfica->ConsumerFinancial)->first();

        // $getBankIdbyFICA = AVS::where('FICA_id', '=', $SearchFica)->first();
        // $getConFinanbyFICA = Financial::where('FICA_id', '=', $SearchFica)->first();

        // app('debugbar')->info($getConFinanbyFICA);

        // $ConFinanbyFICA = ConsumerFinancials::where('ConsumerFinancial', '=', $getConFinanbyFICA->ConsumerFinancial)->first();
        // $BankIdbyFICA = ConsumerAVS::where('Bank_id', '=', $getBankIdbyFICA->Bank_id)->get();

        // $request->validate($request, [
        //     'Account_no' => 'numeric',
        // ]);

        AVS::where('FICA_id', '=', $SearchFica)->update(
            array(

                'Bank_name' => $request->Bank_name,
                'BankTypeid' => $request->BankTypeid,
                'Branch_code' => $request->Branch_code,
                'Account_name' => $request->AccountName,
                'Account_no' => $request->Account_no,

                // 'Branch' => $request->Branch,
                // 'AccountType' => $request->AccountType,
                // 'BankTypeid' => $request->input("test5"),
                // 'Income_taxno' => $request->Tax_Number,

            )
        );

        ConsumerIdentity::where('FICA_id', '=', $SearchFica)->update(
            array(

                'INITIALS' => $request->INITIALS,

            )
        );

        // app('debugbar')->info($request->BankTypeid);

        // if (request()->filled('Foreign_Tax_Number')) {
        //     $update['Foreign_Tax_Number'] = $request->Foreign_Tax_Number;
        // }else{
        //     $update['Foreign_Tax_Number'] = null;
        // }

        $publicOfficia = $request->input('Public_official');
        $publicOfficiaDomesticProminent = $request->input('public-offical-domestic-prominent-checkbox');
        $publicOfficiaEPPO = $request->input('public-offical-eppo-checkbox');

        $publicOfficiaFamily = $request->input('Public_official_Family');
        $publicOfficiaFamilyDomesticProminent = $request->input('public-offica-family-domestic-prominent-checkbox');
        $publicOfficiaFamilyEPPO = $request->input('public-offica-family-eppo-checkbox');

        $sanctionsList = $request->input('SanctionList');
        $adverseMedai = $request->input('AdverseMedia');
        $nonResident = $request->input('NonResidentOther');

        //checking
        $publicofficia = $publicOfficia != -1 ? (int)$publicOfficia : NULL;
        $publicofficiadomesticprominent = isset($publicOfficiaDomesticProminent) ? $publicOfficiaDomesticProminent : NULL;
        $publicofficiaEPPO = isset($publicOfficiaEPPO) ? $publicOfficiaEPPO : NULL;

        $publicofficiafamily = $publicOfficiaFamily != -1 ? (int)$publicOfficiaFamily : NULL;
        $publicofficiafamilydomesticprominent = isset($publicOfficiaFamilyDomesticProminent) ?   $publicOfficiaFamilyDomesticProminent : NULL;
        $publicofficiafamilyeppo = isset($publicOfficiaFamilyEPPO) ?   $publicOfficiaFamilyEPPO : NULL;

        $sanctionslist = $sanctionsList != -1 ? (int)$sanctionsList : NULL;
        $adversemedai = $adverseMedai != -1 ? (int)$adverseMedai : NULL;
        $nonresident = $nonResident != -1 ? (int)$nonResident : NULL;

        Financial::where('FICA_id', '=', $SearchFica)->update(
            array(

                // 'Public_official' => $request->input('Public_official'),
                // 'Public_official_type_DPIP' =>  $request->input('public-offical-domestic-prominent-checkbox'),
                // 'Public_official_type_FPPO' => $request->input('public-offical-eppo-checkbox'),

                // 'Public_official_Family' => $request->input('Public_official_Family'),
                // 'Public_official_type_family_DPIP' => $request->input('public-offical-family-domestic-prominent-checkbox'),
                // 'Public_official_type_family_FPPO' => $request->input('public-offical-family-eppo-checkbox'),

                // 'SanctionList' => $request->input('SanctionList'),
                // 'AdverseMedia' => $request->input('AdverseMedia'),
                // 'NonResidentOther' => $request->input('NonResidentOther'),

                // 'Public_official' => $publicOfficia,
                // 'Public_official_type_DPIP' =>  $publicOfficiaDomesticProminent,
                // 'Public_official_type_FPPO' => $publicOfficiaEPPO,
                // 'Public_official_Family' => $publicOfficiaFamily,
                // 'Public_official_type_family_DPIP' => $publicOfficiaFamilyDomesticProminent,
                // 'Public_official_type_family_FPPO' => $publicOfficiaFamilyEPPO,
                // 'SanctionList' => $sanctionsList,
                // 'AdverseMedia' => $adverseMedai,
                // 'NonResidentOther' => $nonResident,

                'Public_official' => $publicofficia,
                'Public_official_type_DPIP' =>  $publicofficiadomesticprominent,
                'Public_official_type_FPPO' => $publicofficiaEPPO,
                'Public_official_Family' => $publicofficiafamily,
                'Public_official_type_family_DPIP' => $publicofficiafamilydomesticprominent,
                'Public_official_type_family_FPPO' => $publicofficiafamilyeppo,
                'SanctionList' => $sanctionslist,
                'AdverseMedia' => $adversemedai,
                'NonResidentOther' => $nonresident,

                'Tax_Oblig_outside_SA' => $request->Tax_Oblig_outside_SA,
                'Tax_Number' => $request->Tax_Number,
                'Foreign_Tax_Number' => $request->Foreign_Tax_Number,

            )
        );

        // $NotificationLink = $request->session()->get('NotificationLink');
        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');

        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');

        // $insidedata = $request->session()->get('insidedata');
        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');
        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');
        $TitleDesc = $request->session()->get('TitleDesc');

        $SNameMatch = $request->session()->get('SNameMatch');
        $IDMatch = $request->session()->get('IDMatch');
        $EmailMatch = $request->session()->get('EmailMatch');
        $TaxNumMatch = $request->session()->get('TaxNumMatch');

        $kycstatus = $request->session()->get('kycstatus');
        $bankstatus = $request->session()->get('bankstatus');
        $facialrecognitionstatus = $request->session()->get('facialrecognitionstatus');
        $compliancestatus = $request->session()->get('compliancestatus');
        $residential = $request->session()->get('residential');
        $ConsumerIDPhoto = $request->session()->get('ConsumerIDPhoto');
        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');
        $ComplianceData = $request->session()->get('ComplianceData');
        $FetchComplianceSanct = $request->session()->get('FetchComplianceSanct');
        $FetchComplianceAdd = $request->session()->get('FetchComplianceAdd');
        $AddressDoc = $request->session()->get('AddressDoc');
        $BankDoc = $request->session()->get('BankDoc');
        $IDDoc = $request->session()->get('IDDoc');

        // $DataReturn = $this->GetAllData($request);
        // return $DataReturn;

        // return view('admin-tabs')->with('var', $var);
        // return view('admin-findusers')

        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();
        $SearchConsumerID = $useridentitynum['Consumerid'];
        $ContactNumbers = $request->session()->get('ContactNumbers');

        $insidedata = $this->StoredProc($SearchConsumerID);

        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');
        $client = Auth::user();
        $Customerid = $client->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return view('admin-tabs')

            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)

            // ->with('NotificationLink', $NotificationLink)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with($insidedata)
            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)
            ->with('TitleDesc', $TitleDesc)

            ->with('SNameMatch', $SNameMatch)
            ->with('IDMatch', $IDMatch)
            ->with('EmailMatch', $EmailMatch)
            ->with('TaxNumMatch', $TaxNumMatch)

            ->with('kycstatus', $kycstatus)
            ->with('bankstatus', $bankstatus)
            ->with('facialrecognitionstatus', $facialrecognitionstatus)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('ConsumerIDPhoto', $ConsumerIDPhoto)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)
            ->with($ContactNumbers)
            ->with($ComplianceData)
            ->with('FetchComplianceSanct', $FetchComplianceSanct)
            ->with('FetchComplianceAdd', $FetchComplianceAdd)
            ->with('AddressDoc', $AddressDoc)
            ->with('BankDoc', $BankDoc)
            ->with('IDDoc', $IDDoc);
    }

    public function OtherDetailsCreate(Request $request)
    {
        $idnumber = $request->session()->get('IDNUMBER');
        $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $userfica = ConsumerAVS::where('FICA_id', '=', $useridentitynum->FICA_id)->first();

        // $SearchConsumerID = $request->session()->get('SearchConsumerID');
        $SearchFica = $request->session()->get('SearchFica');

        // $Consumerid = $request->session()->get('LoggedUser');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $Consumerid)->where('IsRead', '=', '1')->get();

        // $fica = $useridentitynum[0]->FICA_id;

        $clientDueDiligence = $request->input('ClientDueDiligence');
        $nomineeDeclaration = $request->input('NomineeDeclaration');
        $issuerCommunicationSelection = $request->input('IssuerCommunication');

        $communicationType = $request->input('CommunicationType');
        $issueBroker = $request->input('Broker');
        $brokerCon = $request->input('BrokerContact');

        $custodyServiceSelection = $request->input('CustodyService');
        $segregatedDepositoryAcounts = $request->input('SegregatedDeposit');
        $dividendsTax = $request->input('DividendTax');
        $beeShareholders = $request->input('BeeShareholder');
        $stampDutyReserveTax = $request->input('StampDuty');

        $clientdue = $clientDueDiligence != -1 ? $clientDueDiligence : NULL;
        $nominee = $nomineeDeclaration  != -1 ? $nomineeDeclaration : NULL;
        $issuercommunication = $issuerCommunicationSelection  != -1 ? $issuerCommunicationSelection : NULL;

        $communication = $communicationType  != -1 ? $communicationType : NULL;
        $issue = $issueBroker  != -1 ? $issueBroker : NULL;
        $broker = $brokerCon  != -1 ? $brokerCon : NULL;

        $custodyservice = $custodyServiceSelection  != -1 ? $custodyServiceSelection : NULL;
        $segregateddepository = $segregatedDepositoryAcounts  != -1 ? $segregatedDepositoryAcounts : NULL;
        $dividendstax = $dividendsTax  != -1 ? $dividendsTax : NULL;
        $beeshareholders = $beeShareholders  != -1 ? $beeShareholders : NULL;
        $stampdutyreservetax = $stampDutyReserveTax  != -1 ? $stampDutyReserveTax : NULL;

        // dd($request);

        Declaration::where('FICA_ID', '=',  $SearchFica)->update([

            'ClientDueDiligence' => $clientdue,
            'NomineeDeclaration' => $nominee,
            'IssuerCommunication' => $issuercommunication,
            'CommunicationType' => $communication,
            'Broker' => $issue,
            'BrokerContact' => $broker,
            'CustodyService' => $custodyservice,
            'SegregatedDeposit' => $segregateddepository,
            'DividendTax' => (int) $dividendstax,
            'BeeShareholder' => (bool) $beeshareholders,
            'StampDuty' => (int) $stampdutyreservetax,

        ]);

        // $NotificationLink = $request->session()->get('NotificationLink');
        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');

        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');

        $LogUserSurname = $request->session()->get('LogUserSurname');

        // $insidedata = $request->session()->get('insidedata');
        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');
        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');
        $TitleDesc = $request->session()->get('TitleDesc');

        $kycstatus = $request->session()->get('kycstatus');
        $bankstatus = $request->session()->get('bankstatus');
        $facialrecognitionstatus = $request->session()->get('facialrecognitionstatus');
        $compliancestatus = $request->session()->get('compliancestatus');
        $residential = $request->session()->get('residential');
        $ConsumerIDPhoto = $request->session()->get('ConsumerIDPhoto');
        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');
        $ComplianceData = $request->session()->get('ComplianceData');
        $FetchComplianceSanct = $request->session()->get('FetchComplianceSanct');
        $FetchComplianceAdd = $request->session()->get('FetchComplianceAdd');
        $AddressDoc = $request->session()->get('AddressDoc');
        $BankDoc = $request->session()->get('BankDoc');
        $IDDoc = $request->session()->get('IDDoc');

        $SNameMatch = $request->session()->get('SNameMatch');
        $IDMatch = $request->session()->get('IDMatch');
        $EmailMatch = $request->session()->get('EmailMatch');
        $TaxNumMatch = $request->session()->get('TaxNumMatch');

        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();
        $SearchConsumerID = $useridentitynum['Consumerid'];
        $ContactNumbers = $request->session()->get('ContactNumbers');

        $insidedata = $this->StoredProc($SearchConsumerID);


        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return view('admin-tabs')

            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)

            // ->with('NotificationLink', $NotificationLink)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with($insidedata)
            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)
            ->with('TitleDesc', $TitleDesc)

            ->with('SNameMatch', $SNameMatch)
            ->with('IDMatch', $IDMatch)
            ->with('EmailMatch', $EmailMatch)
            ->with('TaxNumMatch', $TaxNumMatch)


            ->with('kycstatus', $kycstatus)
            ->with('bankstatus', $bankstatus)
            ->with('facialrecognitionstatus', $facialrecognitionstatus)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('compliancestatus', $compliancestatus)
            ->with('residential', $residential)
            ->with('ConsumerIDPhoto', $ConsumerIDPhoto)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)
            ->with($ContactNumbers)
            ->with($ComplianceData)
            ->with('FetchComplianceSanct', $FetchComplianceSanct)
            ->with('FetchComplianceAdd', $FetchComplianceAdd)
            ->with('AddressDoc', $AddressDoc)
            ->with('BankDoc', $BankDoc)
            ->with('IDDoc', $IDDoc);
    }

    public function SendMessage(Request $request)
    {

        $client = Auth::user();
        // $Consumerid = $request->session()->get('LoggedUser');
        $SearchConsumerID = $request->session()->get('SearchConsumerID');

        // $Customerid = session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();

        $Logo = $client['Client_Logo'];
        $Icon = $client['Client_Icon'];
        $customerName = $client['RegistrationName'];

        // $request->session()->put('Consumerid', $Consumerid);

        // $Customerid = $request->session()->get('Customerid');
        // $getCustomerid = Customer::where('Id', '=',  $Customerid)->first();



        $NotificationLink = SendEmail::where('Consumerid', '=',  $SearchConsumerID)->where('IsRead', '=', '1')->get();

        // app('debugbar')->info($SearchConsumerID);

        $FirstName = $request->session()->get('FirstName');
        $SURNAME = $request->session()->get('SURNAME');
        $IDNUMBER = $request->session()->get('IDNUMBER');

        // $NotificationLink = $request->session()->get('NotificationLink');
        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');
        $Email = $request->session()->get('Email');

        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');
        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');

        $Email = $request->session()->get('Email');

        $SetActions = Actions::where('Consumerid', '=', $SearchConsumerID)->get();
        // $SetActions = $request->session()->get('SetActions');

        $ConsumerCapturedPhoto = $request->session()->get('ConsumerCapturedPhoto');

        $idnumber = $request->session()->get('IDNUMBER');

        $YearNow = Carbon::now()->year;
        $TradingName = $request->session()->get('TradingName');

        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();


        // $consumerid = Consumer::where('Consumerid', '=', $useridentitynum->Consumerid)->first();
        // $recipientid = Consumer::where('Consumerid', '=', $request->Email)->first();

        // app('debugbar')->info($consumerid);


        // $request->session()->put('SetActions', $SetActions);



        // $sender = ['Email' => $useridentitynum->Email];
        // $token = ['_token' => $request->_token];
        // $email = ['Email' => $request->Email];
        // $subject = ['Subject' => $request->Subject];
        // $text = ['Message' => $request->Message];

        // $data = array('Email' => $request->Email, 'Subject' => $request->Subject, 'Sender' => $useridentitynum->Email, 'Message' => $request->Message);
        $data = array(
            'Email' => $request->Email, 'Subject' => $request->Subject,
            'Sender' => "ComputerShare.testsupport.com", 'EmailMessage' => $request->EmailMessage,
            'YearNow' => $YearNow, 'Logo' => $Logo, 'TradingName' => $TradingName
        );

        // $data = [

        //     'Email' => $request->Email,
        //     'Subject' => $request->Subject,

        // ];

        // Mail::send('auth.emailmessage', ['data' => $data], function ($message) use ($data) {

        //     $message->to($data['Email'], $data['Subject']);
        //     $message->subject($data['Subject']);

        //     // $message->subject('New Message from User');

        // });

        // // Get Single Array
        // $getconsumerid = ['Consumerid' => $useridentitynum->Consumerid];
        // // Get the Value for Single Array
        // $id = $getconsumerid['Consumerid'];

        // Get Single Array
        $getconsumerfirstname = ['FirstName' => $useridentitynum->FirstName];
        // Get the Value for Single Array
        $firstname = $getconsumerfirstname['FirstName'];

        // Get Single Array
        $getconsumersurname = ['Surname' => $useridentitynum->Surname];
        // Get the Value for Single Array
        $surname = $getconsumersurname['Surname'];

        // Get Single Array
        // $getconsumeremail = ['Email' => $useridentitynum->Email];
        // Get the Value for Single Array
        // $email = $getconsumeremail['Email'];

        // $request->session()->put('consumerid', $id);
        $request->session()->put('firstname', $firstname);
        $request->session()->put('surname', $surname);
        // $request->session()->put('email', $email);

        $Customerid = $client->CustomerId;
        $getCustomerid = Customer::where('Id', '=',  $Customerid)->first();
        $CustomerEmail = $getCustomerid['Customer_Email'];
        $request->session()->put('CustomerEmail', $CustomerEmail);

        app('debugbar')->info($CustomerEmail);

        // dd($CustomerEmail);

        // $getreceive = Consumer::all()->where('Email', '=', $request->Email);

        // // Get Single Array
        // $getreceiptconsumerid = ['Consumerid' => $getreceive->Consumerid];
        // // Get the Value for Single Array
        // $receiptid = $getreceiptconsumerid['Consumerid'];


        $usersend = SendEmail::create([

            $SearchConsumerID = $request->session()->get('SearchConsumerID'),
            $firstname = $request->session()->get('firstname'),
            $surname = $request->session()->get('surname'),
            $Email = $request->session()->get('Email'),

            // $Customerid = $request->session()->get('Customerid'),

            $LogUserName = $request->session()->get('LogUserName'),
            $LogUserSurname = $request->session()->get('LogUserSurname'),
            // $email = $request->session()->get('email'),

            // $CustomerEmail = $request->session()->get('CustomerEmail'),

            'EmailID' => Str::upper(Str::uuid()),
            'Consumerid' => $SearchConsumerID,
            'Consumer_Firstname' => $firstname,
            'Consumer_Surname' => $surname,
            'EMailType' => "Sent",
            'EmailMessage' => $request->EmailMessage,
            'CustomerAdminId' => 1,
            'Admin_Name' => $LogUserName,
            'Admin_Surname' => $LogUserSurname,
            'EmailDate' => Carbon::now(),
            'Send' =>  'hello@inspirit.co.za',
            'Receive' => $request->Email,
            'IsRead' => 1,
            'Subject' => $request->Subject,

        ]);

        $sentemails = SendEmail::where('Consumerid', '=', $SearchConsumerID)->get();
        // $getsentemails = SendEmail::all()->where('Consumerid', '=', $id);
        // $sentemails = SendEmail::all()->where('EMailType', '=', $getsentemails='Sent');

        // app('debugbar')->info($sentemails);


        Mail::send('auth.emailmessage', ['data' => $data], function ($message) use ($data) {

            $message->to(
                $data['Email'],
                $data['Sender'],
                $data['Subject'],
                $data['EmailMessage'],
                $data['YearNow'],
                $data['Logo'],
                $data['TradingName']
            );
            $message->subject($data['Subject']);

            // $message->subject('New Message from User');'YearNow' =>

        });

        // Mail::send('auth.emailmessage', ['data' => $data], function ($message) use ($request) {


        //     // $idnumber = $request->session()->get('idnumber');
        //     // $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();

        //     // $sender = ['Email' => $request->Email];
        //     // $subject = ['Subject' => $request->Subject];

        //     // app('debugbar')->info($sender);
        //     // app('debugbar')->info($subject);

        //     $message->to($data['Email'], $data['Subject']);
        //     $message->subject('New Message from User');

        // });


        // app('debugbar')->info($token);
        // app('debugbar')->info($email);
        // app('debugbar')->info($subject);
        // app('debugbar')->info($text);

        // app('debugbar')->info($request);


        // return view('admin-inbox', [])->with($usersend);

        // $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);

        // return view('admin-inbox')->with('sentemails', $sentemails);

        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $client['Client_Logo'];
        $Icon = $client['Client_Icon'];
        $customerName = $client['RegistrationName'];

        return view('admin-inbox', compact('sentemails'), [])
            ->with('NotificationLink', $NotificationLink)
            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto)
            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)
            ->with('FirstName', $FirstName)
            ->with('SURNAME', $SURNAME)
            ->with('IDNUMBER', $IDNUMBER)
            ->with('Email', $Email)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)

            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)
            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)

            ->with('SetActions', $SetActions);
    }

    public function UserInbox(Request $request)
    {


        $idnumber = $request->session()->get('IDNUMBER');

        $useridentitynum = CustomerUser::where('IDNumber', '=', $idnumber)->first();
        $SearchCustomerUSERID = $useridentitynum['Id'];

        $getSearchConsumerID = Consumer::where('CustomerUSERID', '=', $SearchCustomerUSERID)->first();
        $SearchConsumerID = $getSearchConsumerID['Consumerid'];

        $getSearchFica = Declaration::where('ConsumerID', '=', $SearchConsumerID)->first();
        $SearchFica = $getSearchFica['FICA_ID'];




        $client = Auth::user();
        $LogUserName = $client->FirstName;
        $LogUserSurname = $client->LastName;



        $useridentitynum = CustomerUser::where('IDNumber', '=', $idnumber)->first();

        $SearchCustomerUSERID = $useridentitynum['Id'];

        $getSearchConsumerID = Consumer::where('CustomerUSERID', '=', $SearchCustomerUSERID)->first();
        $SearchConsumerID = $getSearchConsumerID['Consumerid'];


        $getSearchFica = Declaration::where('ConsumerID', '=', $SearchConsumerID)->first();
        $SearchFica = $getSearchFica['FICA_ID'];

        // $Consumerid = $request->session()->get('LoggedUser');
        // $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        // dd($SearchConsumerID);



        $sentemails = SendEmail::where('Consumerid', '=', $SearchConsumerID)->get();

        $getPhoto = DOVS::where('FICA_id', '=', $SearchFica)->first();
        // $ConsumerCapturedPhoto = $getPhoto['ConsumerCapturedPhoto'];

        // dd($ConsumerCapturedPhoto);

        $ConsumerCapturedPhoto = $getPhoto->ConsumerCapturedPhoto == null ? null : $getPhoto->ConsumerCapturedPhoto;

        $getRiskStatusbyFICA = FICA::where('FICA_id', '=', $SearchFica)->first();
        $FICAStatusbyFICA = $getRiskStatusbyFICA['FICAStatus'];
        $RiskStatusbyFICA = $getRiskStatusbyFICA['Risk_Status'];
        $ProgressbyFICA = $getRiskStatusbyFICA['FICAProgress'];

        $ProgressbyFICA = $ProgressbyFICA * 10;

        $SetActions = Actions::where('Consumerid', '=', $SearchConsumerID)->get();

        $DisplayData = Consumer::where('Consumerid', '=', $SearchConsumerID)->first();

        $Email = $DisplayData['Email'];
        $FirstName = $DisplayData['FirstName'];
        $Surname = $DisplayData['Surname'];
        $IDNUMBER = $DisplayData['IDNUMBER'];

        // $DisplaySideData = [

        //     'Email' => $DisplayData != '' ? $DisplayData->Email : null,
        //     'FirstName' => $DisplayData != '' ? $DisplayData->FirstName : null,
        //     'Surname' => $DisplayData != '' ? $DisplayData->Surname : null,
        //     'IDNUMBER' => $DisplayData != '' ? $DisplayData->IDNUMBER : null,

        // ];

        // $Customerid = $request->session()->get('Customerid');
        // $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $client['Client_Logo'];
        $Icon = $client['Client_Icon'];
        $customerName = $client['RegistrationName'];
        $Icon = $client['Client_Icon'];


        // dd($DisplaySideData);


        return view('admin-inbox')

            ->with('sentemails', $sentemails)
            ->with('SetActions', $SetActions)

            ->with('Email', $Email)
            ->with('FirstName', $FirstName)
            ->with('SURNAME', $Surname)
            ->with('IDNUMBER', $IDNUMBER)

            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('FICAStatusbyFICA', $FICAStatusbyFICA)
            ->with('RiskStatusbyFICA', $RiskStatusbyFICA)
            ->with('ProgressbyFICA', $ProgressbyFICA)

            ->with('Logo', $Logo)
            ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)

            ->with('ConsumerCapturedPhoto', $ConsumerCapturedPhoto);
        // ->with('NotificationLink', $NotificationLink)
    }

    // public function UserComments()
    // {
    //     return view('admin-comments');
    // }

    public function AdminActions(Request $request)
    {
        // try{
        $idnumber = $request->session()->get('idnumber');
        $ficaId = $request->session()->get('SearchFica');
        $count = 0;
        //$identityId = Str::upper(Str::uuid());

        // dd($request);

        $fica = FICA::where('FICA_id', '=',  $ficaId)->first();
        $identityConsumer = ConsumerIdentity::where('FICA_id', '=',  $fica->FICA_id)->first();
        $kycConsumer = KYC::where('FICA_id', '=',  $fica->FICA_id)->first();
        $avsConsumer = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $dovsConsumer = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $complyConsumer = Compliance::where('FICA_id', '=',  $fica->FICA_id)->first();
        $consumerId =  session()->get('SearchConsumerID');
        $consumer = Consumer::where('Consumerid', '=',  $consumerId)->first();
        $conuserUserId = $consumer['CustomerUSERID'];

        $riskStatus = $request->input('RiskStatus');
        $ficaStatus = $request->input('FICAStatus');
        $idasAPI = $request->input('idas-api-status');
        $kycAPI = $request->input('kyc-api-status');
        $avsAPI = $request->input('avs-api-status');
        $dovsAPI = $request->input('dovs-api-status');
        $complianceAPI = $request->input('compliance-api-status');

        $APIsEnable = [];
        // dd($conuserUserId);

        $riskSTATUS = isset($riskStatus) ?  $riskStatus : $fica->Risk_Status;
        $ficaSTATUS = isset($ficaStatus) ?  $ficaStatus : $fica->FICAStatus;

        if (isset($idasAPI)) {
            $count++;
        }
        if (isset($kycAPI)) {
            $count++;
        }
        if (isset($avsAPI)) {
            $count++;
        }
        if (isset($dovsAPI)) {
            $count++;
        }

        $ficaProgress = $fica->FICAProgress - $count;
        // dd($ficaProgress);
        // $compliance = isset($complianceAPI) ?  $complianceAPI : null;
        //APIsEnable
        array_push($APIsEnable, isset($idasAPI) ? 'IDAS API' : null, isset($kycAPI) ? 'KYC API' : null, isset($avsAPI) ? 'AVS API' : null, isset($dovsAPI) ? 'DOVS API' : null, isset($complianceAPI) ? 'COMPLIANCE API' : null);
        $APIsEnable = array_filter($APIsEnable);
        //dd($APIsEnable);

        //set API to correction - 2
        isset($idasAPI) ? ConsumerIdentity::where('FICA_id', $ficaId)->update(['Identity_status' => (int)$idasAPI]) : $identityConsumer->Identity_status;
        isset($kycAPI) ? KYC::where('FICA_id', $ficaId)->update(['KYC_Status' => (int)$kycAPI]) : $kycConsumer->KYC_Status;
        isset($avsAPI) ? AVS::where('FICA_id', $ficaId)->update(['AVS_Status' => (int)$avsAPI]) : $avsConsumer->AVS_Status;
        isset($dovsAPI) ? DOVS::where('FICA_id', $ficaId)->update(['DOVS_Status' => (int)$dovsAPI]) : $dovsConsumer->DOVS_Status;
        isset($complianceAPI) ? Compliance::where('FICA_id', $ficaId)->update(['Compliance_Status' => (int)$complianceAPI]) : $complyConsumer->Compliance_Status;

        //update steps
        isset($idasAPI) ? FICA::where('FICA_id', $ficaId)->update(['ID_Status' => null]) : $fica->ID_Status;
        isset($kycAPI) ? FICA::where('FICA_id', $ficaId)->update(['KYC_Status' => null]) : $fica->KYC_Status;
        isset($avsAPI) ? FICA::where('FICA_id', $ficaId)->update(['AVS_Status' => null]) : $fica->AVS_Status;
        isset($dovsAPI) ? FICA::where('FICA_id', $ficaId)->update(['DOVS_Status' => null]) : $fica->DOVS_Status;
        // isset($complyConsumer) ? Compliance::where('FICA_id', $ficaId)->update(['Compliance_Status' => (int)$complianceAPI]) : $complyConsumer->Compliance_Status;

        //ActionType
        $actionType = '';
        $actionComment = '';

        if (isset($riskStatus)) {
            $actionType = 'RISK STATUS';
            $actionComment = 'UPDATE TO ' .  $riskStatus;
            Actions::create([
                'AdminID' => $consumer->Consumerid,
                'Consumerid' =>  $consumerId,
                'ActionDate' => date("Y-m-d H:i:s"),
                'ActionType' => $actionType,
                'Action_Comment' => $actionComment,
                'Admin_User' => $consumer->FirstName . ' ' . $consumer->Surname
            ]);
        }
        if (isset($ficaStatus)) {
            $actionType = 'FICA STATUS';
            $actionComment = 'UPDATE TO ' .  $ficaStatus;
            Actions::create([
                'AdminID' => $consumer->Consumerid,
                'Consumerid' =>  $consumerId,
                'ActionDate' => date("Y-m-d H:i:s"),
                'ActionType' => $actionType,
                'Action_Comment' => $actionComment,
                'Admin_User' => $consumer->FirstName . ' ' . $consumer->Surname
            ]);
        }
        if (isset($idasAPI) || isset($kycAPI) || isset($avsAPI) || isset($dovsAPI) ||  isset($complianceAPI)) {
            $actionType = 'API STATUS';
            foreach ($APIsEnable as $apiComment) {
                Actions::create([
                    'AdminID' => $consumer->Consumerid,
                    'Consumerid' =>  $consumerId,
                    'ActionDate' => date("Y-m-d H:i:s"),
                    'ActionType' => $actionType,
                    'Action_Comment' => 'UPDATE TO ' .  $apiComment,
                    'Admin_User' => $consumer->FirstName . ' ' . $consumer->Surname
                ]);
            }
        }

        //Action_Comment

        //Enable Validation
        $enableValidation  = isset($idasAPI) ||  isset($kycAPI) ||  isset($avsAPI)  ||  isset($dovsAPI)  ||  isset($complianceAPI) ? null : $fica->Validation_Status;

        if ($fica->CompletedDate == null) {
            FICA::where('FICA_id', '=',  $ficaId)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'Risk_Status' =>  $riskSTATUS,
                    'FICAStatus' =>  $ficaSTATUS,
                    'Validation_Status' => $enableValidation,
                    'FailedDate' => NULL,
                    'Correction_Status' => date("Y-m-d H:i:s"),
                    'FICAProgress' => $ficaProgress
                )
            );
        } else {
            FICA::where('FICA_id', '=',  $ficaId)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'Risk_Status' =>  $riskSTATUS,
                    'FICAStatus' =>  $ficaSTATUS,
                    'Validation_Status' => $enableValidation,
                    'FailedDate' => NULL,
                    'Correction_Status' => date("Y-m-d H:i:s"),
                    'FICAProgress' => $ficaProgress - 1,
                    'CompletedDate' => NULL,
                    'FICA_Active' => 1,
                )
            );
        }

        app('debugbar')->info($request);
        // $initials = $request->input('initials');

        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        // dd($customerName);

        return back()->withSuccess('successfully')
            ->with('customerName', $customerName)
            ->with('Icon', $Icon)
            ->with('Logo', $Logo);
    }
    // catch (\Exception $e) {
    //     app('debugbar')->info($e);



    // }
}
