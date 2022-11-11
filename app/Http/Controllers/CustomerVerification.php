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

        if (session()->has('LoggedUser')) {
            session()->pull('exception');
        }
        // dd($request->input('idnumberResult'));

        $idnumber = '';

        if (session()->get('idnumber') == null) {
            $idnumber = $request->input('idnumberResult');
            $request->session()->put('idnumber', $idnumber);
        } else {
            $idnumber = session()->get('idnumber');
        }

        // dd($idnumber);

        // $idnumber = session()->has('idnumber') ? $request->input('idnumberResult'):session()->get('idnumber');
        // $idnumber = $request->input('idnumberResult');


        $LoggedUser = $request->session()->get('LoggedUser');

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

        $useridentitynum = Consumer::where('IDNUMBER', '=', $idnumber)->first();
        $SearchConsumerID = $useridentitynum['Consumerid'];
        $request->session()->put('SearchConsumerID', $SearchConsumerID);

        $userfica = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        $SearchFica = $userfica['FICA_id'];
        $request->session()->put('SearchFica', $SearchFica);

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
        $consumerIDDoc = ConsumerIdentity::where('Identity_File_Path', '=', $userfica->Identity_File_Path)->first();
        $getconsumerIDDoc = ['Identity_File_Path' => $consumerIDDoc->Identity_File_Path];
        $IDDoc = $getconsumerIDDoc['Identity_File_Path'];


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

        // $getConsumerCapturedPhoto = DOVS::where('FICA_id', '=', $SearchFica)->first();
        $ConsumerCapturedPhoto = $getPhoto['ConsumerCapturedPhoto'];

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
            'BirthDate' => $testing != '' ? $testing[0]->BirthDate : null,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            'ID_DateofIssue' => $testing != '' ? $testing[0]->ID_DateofIssue : null,

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
            // 'BirthDate' => $testing[0]->BirthDate,
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


        $getWorkNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 10)->where('RecordStatusInd', '=', 1)->first();
        $getHomeNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 11)->where('RecordStatusInd', '=', 1)->first();
        $getCellNumber = Telephones::where('ConsumerID', '=',  $SearchConsumerID)->where('TelephoneTypeInd', '=', 12)->where('RecordStatusInd', '=', 1)->first();

        $ContactNumbers = [

            'WorkNumberCode' => $getWorkNumber != null ? $getWorkNumber['TelephoneCode'] : null,
            'WorkNumber' => $getWorkNumber != null ? $getWorkNumber['TelephoneNo'] : null,
            'HomeNumberCode' => $getHomeNumber != null ? $getHomeNumber['TelephoneCode'] : null,
            'HomeNumber' => $getHomeNumber != null ? $getHomeNumber['TelephoneNo'] : null,
            'CellNumberCode' => $getCellNumber != null ? $getCellNumber['TelephoneCode'] : null,
            'CellNumber' => $getCellNumber != null ? $getCellNumber['TelephoneNo'] : null

        ];

        // app('debugbar')->info($getWorkNumber);
        // app('debugbar')->info($getHomeNumber);
        // app('debugbar')->info($getCellNumber);
        // app('debugbar')->info($ContactNumbers);

        $request->session()->put('ContactNumbers', $ContactNumbers);

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

        $Customerid = $request->session()->get('Customerid');
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

            ->with($ContactNumbers)
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
            'BirthDate' => $testing != '' ? $testing[0]->BirthDate : null,
            'ID_CountryResidence' => $testing != '' ? $testing[0]->ID_CountryResidence : null,
            'ID_DateofIssue' => $testing != '' ? $testing[0]->ID_DateofIssue : null,

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

        $idnumber = $request->session()->get('idnumber');
        $SearchConsumerID = $request->session()->get('SearchConsumerID');
        $SearchFica = $request->session()->get('SearchFica');

        // $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        $userfica = AVS::where('FICA_id', '=', $SearchFica)->first();
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
        //             // 'BirthDate' => date(Y-m-d, strtotime($request->BirthDate)),
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

        //             // 'BirthDate' => date(Y-m-d, strtotime($request->BirthDate)),
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

        KYC::where('FICA_id', '=',  $SearchFica)->update(
            array(

                'Gender' => $request->Gender,

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
                'SecondName' => $request->SecondName,
                // 'GenderInd' => $request->GenderInd,
                'Email' => $request->Email,
                // 'BirthDate' => date(Y-m-d, strtotime($request->BirthDate)),
                'Married_under' => $request->Married_under,
                'Marriage_date' => date("Y-m-d", strtotime($request->Marriage_date)),

                // 'FaxNumber' => $request->FaxNumber,

                'Employmentstatus' => $request->Employmentstatus,
                'Nameofemployer' => $request->Nameofemployer,
                // 'EmpPostalCode' => $request->EmpPostalCode,
                // 'EmployerAddress' => $request->EmployerAddress,
                'Industryofoccupation' => $request->Industryofoccupation,

                // 'OriginalPostalCode' => $request->OriginalPostalCode,

            )

        );

        // app('debugbar')->info($request->SecondName);

        // if (request()->filled('Married_under')) {
        //     $update['Married_under'] = date("Y-m-d", strtotime($request->Married_under));
        // } else {
        //     $update['Married_under'] = null;
        // }

        KYC::where('FICA_id', '=',  $SearchFica)->update(
            array(

                // 'ID_DateofIssue' => $request->ID_DateofIssue,
                // 'ID_CountryResidence' => $request->ID_CountryResidence,
                // 'ID_CountryResidence' => $request->ID_CountryResidence,
                'MaritalStatusDesc' => $request->MaritalStatusDesc,
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
                $HomeNumber->TelephoneCode == substr($request->WorkTelephoneNo, 0, 3) &&
                $HomeNumber->TelephoneNo == substr($request->WorkTelephoneNo, 3, 10)
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


        ConsumerIdentity::where('FICA_id', '=',  $userfica)->update(
            array(

                'ID_CountryResidence' => $request->ID_CountryResidence,
                // 'ID_DateofIssue' => $request->input(testing),
                // 'ID_CountryResidence' => $request->ID_CountryResidence,
                // 'INITIALS' => $request->INITIALS,

            )
        );

        if (request()->filled('ID_DateofIssue')) {
            $update1['ID_DateofIssue'] = date("Y-m-d", strtotime($request->ID_DateofIssue));
        } else {
            $update1['ID_DateofIssue'] = null;
        }

        $insidedata = $this->StoredProc($SearchConsumerID);

        // app('debugbar')->info($request);

        // $NotificationLink = $request->session()->get('NotificationLink');

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

        $Customerid = $request->session()->get('Customerid');
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
        $idnumber = $request->session()->get('idnumber');

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

        $Customerid = $request->session()->get('Customerid');
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
        // dd($request);

        $idnumber = $request->session()->get('idnumber');
        // $SearchConsumerID = $request->session()->get('SearchConsumerID');
        $SearchFica = $request->session()->get('SearchFica');

        // $Consumerid = $request->session()->get('LoggedUser');
        // $NotificationLink = SendEmail::where('Consumerid', '=',  $Consumerid)->where('IsRead', '=', '1')->get();

        // $useridentitynum = ConsumerIdentity::where('Identity_Document_ID', '=', $idnumber)->first();
        // $userfica = ConsumerAVS::where('FICA_id', '=', $useridentitynum->FICA_id)->first();
        // $userconsumerid = ConsumerFinancials::where('ConsumerFinancial', '=', $userfica->ConsumerFinancial)->first();

        $getBankIdbyFICA = AVS::where('FICA_id', '=', $SearchFica)->first();
        $getConFinanbyFICA = Financial::where('FICA_id', '=', $SearchFica)->first();

        app('debugbar')->info($getConFinanbyFICA);

        // $ConFinanbyFICA = ConsumerFinancials::where('ConsumerFinancial', '=', $getConFinanbyFICA->ConsumerFinancial)->first();
        // $BankIdbyFICA = ConsumerAVS::where('Bank_id', '=', $getBankIdbyFICA->Bank_id)->get();


        AVS::where('Bank_id', '=', $getBankIdbyFICA->Bank_id)->update(
            array(

                'Bank_name' => $request->Bank_name,
                'Branch' => $request->Branch,
                'Branch_code' => $request->Branch_code,
                // 'AccountType' => $request->AccountType,
                // 'BankTypeid' => $request->input("test5"),
                'Account_name' => $request->AccountName,
                'Account_no' => $request->Account_no,
                'BankTypeid' => $request->BankTypeid,

                // 'Income_taxno' => $request->Tax_Number,

            )
        );

        // app('debugbar')->info($request->BankTypeid);

        // if (request()->filled('Foreign_Tax_Number')) {
        //     $update['Foreign_Tax_Number'] = $request->Foreign_Tax_Number;
        // }else{
        //     $update['Foreign_Tax_Number'] = null;
        // }

        ConsumerIdentity::where('Identity_Document_ID', '=',  $idnumber)->update(
            array(

                'INITIALS' => $request->INITIALS,

            )
        );


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

                'Public_official' => $publicOfficia,
                'Public_official_type_DPIP' =>  $publicOfficiaDomesticProminent,
                'Public_official_type_FPPO' => $publicOfficiaEPPO,
                'Public_official_Family' => $publicOfficiaFamily,
                'Public_official_type_family_DPIP' => $publicOfficiaFamilyDomesticProminent,
                'Public_official_type_family_FPPO' => $publicOfficiaFamilyEPPO,
                'SanctionList' => $sanctionsList,
                'AdverseMedia' => $adverseMedai,
                'NonResidentOther' => $nonResident,

                'Public_official' => $publicofficia,
                'Public_official_type_DPIP' =>  $publicofficiadomesticprominent,
                'Public_official_type_FPPO' => $publicofficiaEPPO,
                'Public_official_Family' => $publicofficiafamily,
                'Public_official_type_family_DPIP' => $publicofficiafamilydomesticprominent,
                'Public_official_type_family_FPPO' => $publicofficiafamilyeppo,
                'SanctionList' => $sanctionslist,
                'AdverseMedia' => $adversemedai,
                'NonResidentOther' => $nonresident,

                'Tax_Number' => $request->Tax_Number,

                'Tax_Oblig_outside_SA' => $request->Tax_Oblig_outside_SA,

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

        $Customerid = $request->session()->get('Customerid');
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
        $idnumber = $request->session()->get('idnumber');
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

        $Customerid = $request->session()->get('Customerid');
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

        // $Consumerid = $request->session()->get('LoggedUser');
        $SearchConsumerID = $request->session()->get('SearchConsumerID');

        $Customerid = session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();

        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

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

        $idnumber = $request->session()->get('idnumber');

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

        $Customerid = $request->session()->get('Customerid');
        $getCustomerid = Customer::where('Id', '=',  $Customerid)->first();
        $CustomerEmail = $getCustomerid['Customer_Email'];
        $request->session()->put('CustomerEmail', $CustomerEmail);

        app('debugbar')->info($CustomerEmail);

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

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];
        
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
        $SearchConsumerID = $request->session()->get('SearchConsumerID');
        $SearchFica = $request->session()->get('SearchFica');

        $Consumerid = $request->session()->get('LoggedUser');

        $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        $LogUserName = $getLogUser['FirstName'];
        $LogUserSurname = $getLogUser['LastName'];

        $sentemails = SendEmail::where('Consumerid', '=', $SearchConsumerID)->get();

        $getPhoto = DOVS::where('FICA_id', '=', $SearchFica)->first();
        $ConsumerCapturedPhoto = $getPhoto['ConsumerCapturedPhoto'];

        $FICAStatusbyFICA = $request->session()->get('FICAStatusbyFICA');
        $RiskStatusbyFICA = $request->session()->get('RiskStatusbyFICA');
        $ProgressbyFICA = $request->session()->get('ProgressbyFICA');

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

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];
        

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
        //dd($request);

        // try{
        $idnumber = $request->session()->get('idnumber');
        $ficaId = $request->session()->get('SearchFica');
        $count = 0;
        //$identityId = Str::upper(Str::uuid());

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