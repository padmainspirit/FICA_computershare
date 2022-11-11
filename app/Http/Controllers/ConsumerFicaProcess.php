<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Consumer;
use App\Models\CustomerUser;
use App\Models\FICA;
use App\Models\Address;
use App\Models\ConsumerIdentity;
use App\Models\LookupDatas;
use App\Models\BankAccountType;
use App\Models\AVS;
use App\Models\Customer;
use App\Models\Financial;
use App\Models\Declaration;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\IndustryOccupation;
use App\Models\Nationality;
use App\Models\Telephones;


class ConsumerFicaProcess extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function PersonalDetails(Request $request)
    {

        $this->validate($request, [
            'street-address-line1' => 'required',
            'street-address-line2' => 'required',
            'city-physical' => 'required',
            'province-physical' => 'required',
            'zip-physical' => 'required',
            'country-input' => 'required',
            'employee-status-input' => 'required',
            'industry-of-occupation-input' => 'required',
            // 'id-issuedate-input' => 'required',
            'titleId' => 'required'
        ]);

        // dd($request);
        $occupation = [];
        $countries = [];
        $Telephones = [];

        //dd($request);
        //app('debugbar')->info($request);
        //ADDRESS CONSTANTS
        $homeAddressIDType = '4AA3F8D1-0DF0-45C7-A772-869ECD88AB4D'; //HOME:16 
        $PostalAddressIDType = '41B4799E-B1CC-44D1-B067-F963B17694EA'; //POSTAL:15
        $WorkAddressIDType = 'C3E57D4F-3100-4973-A717-E17355321983'; //WORK:14

        // try {
        app('debugbar')->info($request);
        $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
        $customerUser = CustomerUser::where('Id', '=',  session()->get('LoggedUser'))->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        $consumerIdentity = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $bankTpye = BankAccountType::all();

        $DOB =  date('Y-m-d', strtotime($consumerIdentity->DOB));
        $selectedIndustryofoccupation =  $consumer->Industryofoccupation;

        $industryOccupation = IndustryOccupation::all();
        foreach ($industryOccupation as $industry) {
            array_push($occupation, $industry->Industry_occupation);
        }

        //Get Nationality
        $nationality = Nationality::all();
        foreach ($nationality as $country) {
            array_push($countries, strtoupper($country->Nationality));
        }
        sort($countries);

        // app('debugbar')->info($occupation);

        $addressLookUpHomeValue = LookupDatas::where('ID', '=',  $homeAddressIDType)->first();
        $addressLookUpPostalValue = LookupDatas::where('ID', '=',  $PostalAddressIDType)->first();
        $addressLookUpWorkValue = LookupDatas::where('ID', '=',  $WorkAddressIDType)->first();

        $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', $addressLookUpHomeValue->Value)->first();
        $postalAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', $addressLookUpPostalValue->Value)->first();
        $workAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', $addressLookUpWorkValue->Value)->first();

        $telephoneNumber = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 11)->get();
        $workTelephonNumber = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 10)->get();

        // $telephone1 = Telephones::select('*')
        //     ->where('ConsumerID', '=',  $consumer->Consumerid)
        //     ->where('RecordStatusInd', '=', 1)
        //     ->get();
        // dd(Count($telephoneNumber));


        $lookupdata = LookupDatas::all();

        //Telephones on LookUpData Table
        foreach ($lookupdata as  $telephone) {
            if ($telephone->Type == 'Telephone Type Indicator') {
                array_push($Telephones, [$telephone->Value => $telephone->Text]);
            }
        }

        //Check if addresses exist
        $homeAddressExist =  $homeAddress != null ? true : false;
        $postalAddressExist =  $postalAddress != null ? true : false;
        $workAddressExist =  $workAddress != null ? true : false;
        $telephoneExist =  $telephone  != null ? true : false;


        $ficaProgress = ($fica->Personal_Status == null) ? $fica->FICAProgress + 1 : $fica->FICAProgress;
        // app('debugbar')->info($ficaProgress);

        //get user input
        //Field(s) in TBL_Consumer table
        $surname = $request->input('surname-input');
        $name = $request->input('name-input');
        $idnumber = $request->input('idnumber-input');
        $dob = $request->input('dob-input');
        $title = $request->input('titleId');
        // $idIssuedDate = $request->input('id-issuedate-input');

        // $taxNumber = $request->input('tax-number-input');

        $employeeStatus = $request->input('employee-status-input');
        $employeerName = $request->input('employeer-name-input');
        $industryOfOccupation = $request->input('industry-of-occupation-input');

        // $old = [
        //     'idissue' => $idIssuedDate != '' ? $idIssuedDate : null,
        // ];


        //Field(s) in TBL_Consumer_IDENTITY table
        $country2 = $request->input('country-input');
        app('debugbar')->info($country2);

        // dd($country2);
        //Field(s) in TBL_Consumer_Addresses table
        //Home Address
        $streetAddressLine1 = $request->input('street-address-line1');
        $streetAddressLine2 = $request->input('street-address-line2');
        $cityPhysical = $request->input('city-physical');
        $provincePhysical = $request->input('province-physical');
        $zipPhysical = $request->input('zip-physical');

        //Postal Address
        $postalAddressLine1 = $request->input('postal-address-line1');
        $postalAddressLine2 = $request->input('postal-address-line2');
        $cityPostal = $request->input('city-postal');
        $provincePostal = $request->input('province-postal');
        $zipPostal = $request->input('zip-postal');

        //Work Addrees
        $employeerStreetAddressLine1 = $request->input('employeer-street-address-line1-input');
        $employeerStreetAddressLine2 = $request->input('employeer-street-address-line2-input');
        $employeerCity = $request->input('employeer-city-input');
        $employeerProvince = $request->input('employeer-province-input');
        $employeerPostalCode = $request->input('employeer-postal-code-input');

        //Field(s) in TBL_Consumer_Telephones table
        $telephoneHome = $request->input('telephone-home-input');
        $workNumber = $request->input('work-number-input');

        $mobile = $request->input('mobile-input');

        //Field(s) in TBL_Consumer and CustomerUsers table
        $email = $request->input('email-input');


        //-----------------------------------------------------ADDRESS ----------------------------------------------
        // HOME ADDRESS
        if ($homeAddressExist == true) {
            if (
                $homeAddress->OriginalAddress1 ==  $streetAddressLine1 && $homeAddress->OriginalAddress2 == $streetAddressLine2 &&
                $homeAddress->OriginalAddress3 == $cityPhysical &&  $homeAddress->OriginalAddress4 == $provincePhysical &&  $homeAddress->OriginalPostalCode == $zipPhysical
            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Home Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $homeAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $HomeAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpHomeValue->Value,
                    'OriginalAddress1' => $streetAddressLine1,
                    'OriginalAddress2' => $streetAddressLine2,
                    'OriginalAddress3' => $cityPhysical,
                    'OriginalAddress4' => $provincePhysical,
                    'OriginalPostalCode' => $zipPhysical,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($streetAddressLine1) && isset($streetAddressLine2) && isset($cityPhysical) && isset($provincePhysical) && isset($zipPhysical)) {
                $HomeAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpHomeValue->Value,
                    'OriginalAddress1' => $streetAddressLine1,
                    'OriginalAddress2' => $streetAddressLine2,
                    'OriginalAddress3' => $cityPhysical,
                    'OriginalAddress4' => $provincePhysical,
                    'OriginalPostalCode' => $zipPhysical,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // POSTAL ADDRESS
        if ($postalAddressExist == true) {
            if (
                $postalAddress->OriginalAddress1 ==  $postalAddressLine1 && $postalAddress->OriginalAddress2 == $postalAddressLine2 &&
                $postalAddress->OriginalAddress3 == $cityPostal  &&  $postalAddress->OriginalAddress4 == $provincePostal &&  $postalAddress->OriginalPostalCode == $zipPostal
            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Postal Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $postalAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $PostalAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpPostalValue->Value,
                    'OriginalAddress1' => $postalAddressLine1,
                    'OriginalAddress2' => $postalAddressLine2,
                    'OriginalAddress3' => $cityPostal,
                    'OriginalAddress4' => $provincePostal,
                    'OriginalPostalCode' => $zipPostal,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($postalAddressLine1) && isset($postalAddressLine2) && isset($cityPostal) &&  isset($provincePostal) && isset($zipPostal)) {
                $PostalAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpPostalValue->Value,
                    'OriginalAddress1' => $postalAddressLine1,
                    'OriginalAddress2' => $postalAddressLine2,
                    'OriginalAddress3' => $cityPostal,
                    'OriginalAddress4' => $provincePostal,
                    'OriginalPostalCode' => $zipPostal,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // WORK ADDRESS
        if ($workAddressExist == true) {
            if (
                $workAddress->OriginalAddress1 ==  $employeerStreetAddressLine1  && $workAddress->OriginalAddress2 == $employeerStreetAddressLine2 &&
                $workAddress->OriginalAddress3 == $employeerCity  &&  $workAddress->OriginalAddress4 == $employeerProvince &&  $workAddress->OriginalPostalCode == $employeerPostalCode
            ) {
            } else {
                app('debugbar')->info('Address testing');
                //If Work Address Exist change the RecordStatusInd to 0
                Address::where("ConsumerAddressID", $workAddress->ConsumerAddressID)->update(['RecordStatusInd' => 0]);
                $WorkAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpWorkValue->Value,
                    'OriginalAddress1' => $employeerStreetAddressLine1,
                    'OriginalAddress2' => $employeerStreetAddressLine2,
                    'OriginalAddress3' => $employeerCity,
                    'OriginalAddress4' => $employeerProvince,
                    'OriginalPostalCode' => $employeerPostalCode,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        } else {
            if (isset($employeerStreetAddressLine1) && isset($employeerStreetAddressLine2) && isset($employeerCity) &&  isset($employeerProvince) && isset($employeerPostalCode)) {
                $WorkAddress = Address::create([
                    'ConsumerID' => $consumer->Consumerid,
                    'AddressTypeInd' => $addressLookUpWorkValue->Value,
                    'OriginalAddress1' => $employeerStreetAddressLine1,
                    'OriginalAddress2' => $employeerStreetAddressLine2,
                    'OriginalAddress3' => $employeerCity,
                    'OriginalAddress4' => $employeerProvince,
                    'OriginalPostalCode' => $employeerPostalCode,
                    'RecordStatusInd' => 1,
                    'CreatedOnDate' => date("Y-m-d H:i:s"),
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                ]);
            }
        }

        // dd($request);

        //-----------------------------------------------------END ADDRESS ----------------------------------------------



        //update Consumer detalis
        Consumer::where('Consumerid', $consumer->Consumerid)->update(
            array(
                'Industryofoccupation' => $industryOfOccupation,
                'TitleCode' => (int)$title,
                'Nameofemployer' => $employeerName,
                'Employmentstatus' => $employeeStatus,
                'Nameofemployer' => $employeerName
                // $title
            )
        );

        //update ConsumerIdentity detalis
        ConsumerIdentity::where('FICA_id', $fica->FICA_id)->update(
            array(
                'ID_CountryResidence' => $country2,
                // 'ID_DateofIssue' => $idIssuedDate
            )
        );

        // app('debugbar')->info($workAddress);


        FICA::where('Consumerid', $consumer->Consumerid)->update(
            array(
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAProgress' =>  $ficaProgress,
                'Personal_Status' => date("Y-m-d H:i:s")
            )
        );
        // array_push($Telephones, [$telephone->Value => $telephone->Text]);
        //Telephone


        //Adding New Home Telephone Number 
        $telLength = strlen($telephoneHome);
        //Check the length of the telephone number
        if ($telLength == 10) {
            if (Count($telephoneNumber) > 0) {
                foreach ($telephoneNumber as $number) {
                    //dd($number);
                    Telephones::where("ConsumerID", $consumer->Consumerid)->where("TelephoneTypeInd", 11)->update(['RecordStatusInd' => 0]);
                }
            }
            app('debugbar')->info($telLength);
            // if ($telLength == 10) {
            $extension = substr($telephoneHome, 0, 3);
            $telno = substr($telephoneHome, 3, 10);
            Telephones::create([
                'ConsumerID' => $consumer->Consumerid,
                'TelephoneTypeInd' => 11, //use lookup table
                'InternationalDialingCode',
                'TelephoneCode' => $extension,
                'TelephoneNo' =>  $telno,
                'RecordStatusInd' => 1,
                'CreatedonDate' => date("Y-m-d H:i:s"),
                'ChangedonDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
            ]);
        }

        //Adding New Home Work Telephone Number 
        $telLength = strlen($workNumber);
        //Check the length of the telephone number
        if ($telLength == 10) {
            if (Count($workTelephonNumber) > 0) {
                foreach ($workTelephonNumber as $number) {
                    //dd($number);
                    Telephones::where("ConsumerID", $consumer->Consumerid)->where("TelephoneTypeInd", 10)->update(['RecordStatusInd' => 0]);
                }
            }
            app('debugbar')->info($telLength);
            // if ($telLength == 10) {
            $extension = substr($workNumber, 0, 3);
            $telno = substr($workNumber, 3, 10);
            Telephones::create([
                'ConsumerID' => $consumer->Consumerid,
                'TelephoneTypeInd' => 10, //use lookup table
                'InternationalDialingCode',
                'TelephoneCode' => $extension,
                'TelephoneNo' =>  $telno,
                'RecordStatusInd' => 1,
                'CreatedonDate' => date("Y-m-d H:i:s"),
                'ChangedonDate' => date("Y-m-d H:i:s"),
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
            ]);
        }


        //storing fica status on the session
        $request->session()->put('FICAProgress', $fica->FICAProgress);
        $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;
        $request->session()->put('stepState', $stepState);
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        // app('debugbar')->info($request);

        return back()->withSuccess('successfully')
        // ->with($old)
        ->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function FinancialDetails(Request $request)
    {
        $this->validate($request, [
            'funds-input' => 'required',
        ]);
        
        // dd($request);

        // dd($request);

        try {
            $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();

            $ficaProgress = ($fica->Financial_status == null) ? $fica->FICAProgress + 1 : $fica->FICAProgress;

            $request->session()->put('FICAProgress', $fica->FICAProgress);

            $taxNumber = $request->input('tax-number-input');
            $taxObligations  = $request->input('Tax_Oblig_outside_SA');
            $foreignTaxNmber = $request->input('foreign-tax-number-input');
            $countryOfTaxCode = $request->input('country-of-tax-code-input');
            $noForeignTaxNumberReason = $request->input('no-foreign-tax-number-reason-input');

            $sourceOfFunds = $request->input('funds-input');


            Financial::where('FICA_id',  $fica->FICA_id)->update(
                array(
                    'Tax_Number' => $taxNumber,
                    'Tax_Oblig_outside_SA' => (int)$taxObligations,
                    'Foreign_Tax_Number' =>  $foreignTaxNmber,
                    'Sources_Funds' => $sourceOfFunds,
                )
            );

            FICA::where('FICA_id',  $fica->FICA_id)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAProgress' =>  $ficaProgress,
                    'Financial_status' => date("Y-m-d H:i:s")
                )
            );
            //update stepState
            $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;
            $request->session()->put('stepState', $stepState);
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        return back()->withSuccess('successfully')->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function Screening(Request $request)
    {

        try {
            $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $request->session()->put('FICAProgress', $fica->FICAProgress);

            //Update Fica Progress
            $ficaProgress = ($fica->Screening_status == null) ? $fica->FICAProgress + 1 : $fica->FICAProgress;


            $publicOfficia = $request->input('public-officia-dropdown');
            $publicOfficiaDomesticProminent = $request->input('public-offical-domestic-prominent-checkbox');
            $publicOfficiaEPPO = $request->input('public-offical-eppo-checkbox');

            $publicOfficiaFamily = $request->input('public-officia-family-dropdwon');
            $publicOfficiaFamilyDomesticProminent = $request->input('public-offical-family-domestic-prominent-checkbox');
            $publicOfficiaFamilyEPPO = $request->input('public-offical-family-eppo-checkbox');

            $sanctionsList = $request->input('sanctions-list-dropdown');
            $adverseMedai = $request->input('adverse-medai-dropdown');
            $nonResident = $request->input('non-resident-dropdown');


            //checking
            $publicofficia = $publicOfficia != -1 ? (int)$publicOfficia : NULL;
            $publicofficiadomesticprominent = isset($publicOfficiaDomesticProminent) ? $publicOfficiaDomesticProminent : '';
            $publicofficiaEPPO = isset($publicOfficiaEPPO) ? $publicOfficiaEPPO : '';

            $publicofficiafamily = $publicOfficiaFamily != -1 ? (int)$publicOfficiaFamily : NULL;
            $publicofficiafamilydomesticprominent = isset($publicOfficiaFamilyDomesticProminent) ?   $publicOfficiaFamilyDomesticProminent : '';
            $publicofficiafamilyeppo = isset($publicOfficiaFamilyEPPO) ?   $publicOfficiaFamilyEPPO : '';

            $sanctionslist = $sanctionsList != -1 ? (int)$sanctionsList : NULL;
            $adversemedai = $adverseMedai != -1 ? (int)$adverseMedai : NULL;
            $nonresident = $nonResident != -1 ? (int)$nonResident : NULL;


            app('debugbar')->info($request);

            Financial::where('FICA_id',  $fica->FICA_id)->update(
                array(
                    'Public_official' => $publicofficia,
                    'Public_official_type_DPIP' =>  $publicofficiadomesticprominent,
                    'Public_official_type_FPPO' => $publicofficiaEPPO,
                    'Public_official_Family' => $publicofficiafamily,
                    'Public_official_type_family_DPIP' => $publicofficiafamilydomesticprominent,
                    'Public_official_type_family_FPPO' => $publicofficiafamilyeppo,
                    'SanctionList' => $sanctionslist,
                    'AdverseMedia' => $adversemedai,
                    'NonResidentOther' => $nonresident
                )
            );

            FICA::where('Consumerid', $consumer->Consumerid)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAProgress' =>  $ficaProgress,
                    'Screening_status' => date("Y-m-d H:i:s")
                )
            );

            //update stepState
            $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;
            $request->session()->put('stepState', $stepState);
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }

        $Customerid = session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();

        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return back()->withSuccess('successfully')->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function Declarations(Request $request)
    {
        $this->validate($request, [
            'client-due-diligence-dropdown' => 'required',
            // 'nominee-declaration-dropdown' => 'required',
            'issuer-communication-selection-dropdown' => 'required',
            'custody-service-selection-dropdown' => 'required',
            'segregated-depository-acounts-dropdown' => 'required',
            'communication-type-selection-dropdown' => 'required',
            // 'dividends-tax-dropdown' => 'required',
            // 'bee-shareholders-dropdown' => 'required',
            // 'stamp-duty-reserve-tax-checkbox' => 'required'
        ]);

        // app('debugbar')->info($request);
        try {
            $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
            $request->session()->put('FICAProgress', $fica->FICAProgress);

            //Update Fica Progress
            $ficaProgress = ($fica->Declaration_status == null) ? $fica->FICAProgress + 1 : $fica->FICAProgress;


            // app('debugbar')->info($request);

            $clientDueDiligence = $request->input('client-due-diligence-dropdown');
            $nomineeDeclaration = $request->input('nominee-declaration-dropdown');
            $issuerCommunicationSelection = $request->input('issuer-communication-selection-dropdown');

            $communicationTypeSelect = $request->input('communication-type-selection-dropdown');
            $brokerNameInput = $request->input('broker-name-input');
            $brokerContactInput = $request->input('broker-contact-input');

            $custodyServiceSelection = $request->input('custody-service-selection-dropdown');
            $segregatedDepositoryAcounts = $request->input('segregated-depository-acounts-dropdown');
            $dividendsTax = $request->input('dividends-tax-dropdown');
            $beeShareholders = $request->input('bee-shareholders-dropdown');
            $stampDutyReserveTax = $request->input('stamp-duty-reserve-tax-checkbox');

            $clientdue = $clientDueDiligence != -1 ? $clientDueDiligence : NULL;
            $nominee = $nomineeDeclaration  != -1 ? $nomineeDeclaration : NULL;
            $issuercommunication = $issuerCommunicationSelection  != -1 ? $issuerCommunicationSelection : NULL;

            $communicationType = $communicationTypeSelect  != -1 ? $communicationTypeSelect : NULL;
            $brokerName = $brokerNameInput  != -1 ? $brokerNameInput : NULL;
            $brokerContact = $brokerContactInput  != -1 ? $brokerContactInput : NULL;

            $custodyservice = $custodyServiceSelection  != -1 ? $custodyServiceSelection : NULL;
            $segregateddepository = $segregatedDepositoryAcounts  != -1 ? $segregatedDepositoryAcounts : NULL;
            $dividendstax = $dividendsTax  != -1 ? $dividendsTax : NULL;
            $beeshareholders = $beeShareholders  != -1 ? $beeShareholders : NULL;
            $stampdutyreservetax = isset($stampDutyReserveTax) ? $stampDutyReserveTax : NULL;

            $test = ([
                'ClientDueDiligence' => $clientdue,
                'NomineeDeclaration' =>   $nominee,
                'IssuerCommunication' => $issuercommunication,

                'BrokerContact' => $brokerContact,
                'CommunicationType' => $communicationType,
                'Broker' => $brokerName,

                'CustodyService' => $custodyservice,
                'SegregatedDeposit' => $segregateddepository,
                'DividendTax' => (int)$dividendstax,
                'BeeShareholder' => (bool) $beeshareholders,
                'StampDuty' =>  (int)$stampdutyreservetax
            ]);

            app('debugbar')->info($test);

            Declaration::where('FICA_id',  $fica->FICA_id)->update(
                array(
                    'ClientDueDiligence' => $clientdue,
                    'NomineeDeclaration' =>   $nominee,
                    'IssuerCommunication' => $issuercommunication,

                    'BrokerContact' => $brokerContact,
                    'CommunicationType' => $communicationType,
                    'Broker' => $brokerName,
                    
                    'CustodyService' => $custodyservice,
                    'SegregatedDeposit' => $segregateddepository,
                    'DividendTax' => (int)$dividendstax,
                    'BeeShareholder' => (bool) $beeshareholders,
                    'StampDuty' =>  (int)$stampdutyreservetax
                )
            );


            FICA::where('Consumerid', $consumer->Consumerid)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAProgress' =>  $ficaProgress,
                    'Declaration_status' => date("Y-m-d H:i:s")
                )
            );

            //update stepState
            $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;
            $request->session()->put('stepState', $stepState);
        } catch (\Exception $e) {
            app('debugbar')->info($e);
        }

        $Customerid = session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();

        $Logo = $customer['Client_Logo'];
        $Icon = $customer['Client_Icon'];
        $customerName = $customer['RegistrationName'];

        return back()->withSuccess('successfully')->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }

    public function Acknowledgement(Request $request)
    {
        $this->validate($request, [
            'terms-and-conditions-checkbox' => 'required',
            'signed-place-input' => 'required'
        ]);


        try {
            $consumer = Consumer::where('CustomerUSERID', '=',  session()->get('LoggedUser'))->first();
            $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            $request->session()->put('FICAProgress', $fica->FICAProgress);



            app('debugbar')->info($request);

            $termsAndConditions = $request->input('terms-and-conditions-checkbox');
            $fullName = $request->input('fullname-input');
            $signedPlace = $request->input('signed-place-input');

            // $old = [

            //     'sign' => $signedPlace != '' ? $signedPlace : null,

            // ];

            $termsandconditions = isset($termsAndConditions) ? $termsAndConditions : NULL;

            if ($termsandconditions) {
                //Update Fica Progress
                $ficaProgress = ($fica->Signed_Date == null) ? $fica->FICAProgress + 1 : $fica->FICAProgress;
                //   $ficaProgress = $fica->FICAProgress + 1;

                FICA::where('Consumerid', $consumer->Consumerid)->update(
                    array(
                        'LastUpdatedDate' => date("Y-m-d H:i:s"),
                        'FICAProgress' =>  $ficaProgress,
                        'TandC_Status' => date("Y-m-d H:i:s"),
                        'Signed_Status' => date("Y-m-d H:i:s"),
                        'Signed_Place' => $signedPlace,
                        'Signed_Date' => date("Y-m-d H:i:s")
                    )
                );
            }
            $ficaCheck = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
            app('debugbar')->info($ficaCheck->ficaProgress);
            

            if ($ficaCheck->FICAProgress == 10) {
                FICA::where('Consumerid', $consumer->Consumerid)->update(
                    array(
                        'CompletedDate' => date("Y-m-d H:i:s"),
                        'FICAStatus' => 'Completed',
                        'FICA_Active' => 0
                    )
                );
            }
            //update stepState, Progress bar
            $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;
            $request->session()->put('stepState', $stepState);
        } catch (\Exception $e) {
            $request->session()->put($e);
        }

        $Customerid = $request->session()->get('Customerid');
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        return back()->withSuccess('successfully')->with('customerName', $customerName)
        ->with('Icon', $Icon)
        ->with('Logo', $Logo);
    }
}
