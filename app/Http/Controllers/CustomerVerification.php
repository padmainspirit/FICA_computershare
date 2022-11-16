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

        session()->put('idnumber', $idnumber);

        // dd($idnumber);

        // $idnumber = session()->has('idnumber') ? $request->input('idnumberResult'):session()->get('idnumber');
        // $idnumber = $request->input('idnumberResult');


        $LoggedUser = $request->session()->get('LoggedUser');
        $Customerid = $request->session()->get('Customerid');

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

        if($ConsumerIDPhoto == null || "" || ''){
            DOVS::where('FICA_id', '=', $SearchFica)->update(
                array(
    
                    'ConsumerIDPhoto' => NULL,
    
                )
            );
            $ConsumerIDPhoto = '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mPADuAdU9O79+1p47oQfzhnP3sEhK8Df/xWeVBdtwmGB6zoSyMnJFb57/y40PS3Nr7i4GC8yshH7+vi+CQjwj7KxsYFGsY484XYgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAgEUTYNEdfVx8QmBUVGT9ly9f1o6Ojq4eG/s2JCMj3V4slvAlBXlcYaMBRWyBLQ9pNB9cI3zU189/jfxjrLT//eG/qVlcPpI9vaASyrOtgitWiqtXr15Ep44ddlSvXv2ejY2Ngm5WTJSXnZ1tf//Bg5avXr0Ox/kJxX+qpKenuUgkhfy8nEwucglQOoR3UqoVcs4//pWWGxWLx0eSJ+dY7JwEK5G9o8rR0UFWrpxfQkhIyLMKFSo8wkzvVKta5S7mqmQiTrrLzMnJsbt0+XLvS5cu93jy5HGd92/fuiid/JQC9wApir5mFxAUklkrPPxGu3Zt9zRs0OC8o6OjhG4fdSkvNzdXePPWrfbnzp0f+PjRowbvYqNdUYWmhUXpcXxebjw3IDAop0aNmndbtWp5sGWLFkednJzydbHP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';
        }

        if($ConsumerCapturedPhoto == null || "" || ''){
            DOVS::where('FICA_id', '=', $SearchFica)->update(
                array(
    
                    'ConsumerCapturedPhoto' => NULL,
    
                )
            );
            $ConsumerCapturedPhoto = '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mPADuAdU9O79+1p47oQfzhnP3sEhK8Df/xWeVBdtwmGB6zoSyMnJFb57/y40PS3Nr7i4GC8yshH7+vi+CQjwj7KxsYFGsY484XYgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAABAAAkAACAABIAAEgAAQAAJAAAgAASAABIAAEAACQAAIAAEgAASAgEUTYNEdfVx8QmBUVGT9ly9f1o6Ojq4eG/s2JCMj3V4slvAlBXlcYaMBRWyBLQ9pNB9cI3zU189/jfxjrLT//eG/qVlcPpI9vaASyrOtgitWiqtXr15Ep44ddlSvXv2ejY2Ngm5WTJSXnZ1tf//Bg5avXr0Ox/kJxX+qpKenuUgkhfy8nEwucglQOoR3UqoVcs4//pWWGxWLx0eSJ+dY7JwEK5G9o8rR0UFWrpxfQkhIyLMKFSo8wkzvVKta5S7mqmQiTrrLzMnJsbt0+XLvS5cu93jy5HGd92/fuiid/JQC9wApir5mFxAUklkrPPxGu3Zt9zRs0OC8o6OjhG4fdSkvNzdXePPWrfbnzp0f+PjRowbvYqNdUYWmhUXpcXxebjw3IDAop0aNmndbtWp5sGWLFkednJzydbHP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';
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
            'BirthDate' => $testing != '' ? $testing[0]->BirthDate : null,
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
            'BirthDate' => $testing != '' ? $testing[0]->BirthDate : null,
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
                // 'BirthDate' => date(Y-m-d, strtotime($request->BirthDate)),
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

        $idnumber = $request->session()->get('idnumber');
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

        $idnumber = $request->session()->get('idnumber');

        $useridentitynum = CustomerUser::where('IDNumber', '=', $idnumber)->first();
        $SearchCustomerUSERID = $useridentitynum['Id'];

        $getSearchConsumerID = Consumer::where('CustomerUSERID', '=', $SearchCustomerUSERID)->first();
        $SearchConsumerID = $getSearchConsumerID['Consumerid'];        

        $getSearchFica = Declaration::where('ConsumerID', '=', $SearchConsumerID)->first();
        $SearchFica = $getSearchFica['FICA_ID'];

        $Consumerid = $request->session()->get('LoggedUser');
        $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        // dd($SearchConsumerID);

        $LogUserName = $getLogUser['FirstName'];
        $LogUserSurname = $getLogUser['LastName'];

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