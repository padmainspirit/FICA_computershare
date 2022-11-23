<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\PdfToImage\Pdf as PDF;
use Imagick;


use App\Http\Controllers\awsController;
use App\Models\Consumer;
use App\Models\CustomerUser;
use App\Models\FICA;
use App\Models\Address;
use App\Models\BankAccountType;
use App\Models\ConsumerIdentity;
use App\Models\AVS;
use App\Models\KYC;
use App\Models\IndustryOccupation;
use App\Models\Nationality;
use App\Models\SourceOfFunds;
use App\Models\Financial;
use App\Models\Customer;
use App\Models\Declaration;
use App\Models\DOVS;
use App\Models\Compliance;
use App\Models\SendEmail;
use App\Models\Banks;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\LookupDatas;
use App\Models\Telephones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;

class FicaProcessController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function ReadNotification(Request $request)
    {

        $NotificationLink = $request->session()->get('NotificationLink');

        $Consumerid = Auth::user()->Id;
        $SearchCustomerId = CustomerUser::where('Id', '=', $Consumerid)->first();
        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::getCustomerDetails($Customerid);

        // $customerName =  $request->session()->get('customerName');
        $client = Auth::user();
        $customerName = $client->FirstName . ' ' . $client->LastName;

        $EmailID = $request->emailid;
        //   app('debugbar')->info($EmailID);

        SendEmail::where('EmailID', '=', $EmailID)->update([
            'IsRead' => 0,
        ]);

        return redirect()->back()
            // ->with('Logo', $Logo)
            // ->with('Icon', $Icon)
            ->with('customerName', $customerName)
            ->with('NotificationLink', $NotificationLink);
    }

    public function fica(Request $request)
    {

        $Customerid = Auth::user()->CustomerId;
        $customer = Customer::where('Id', '=',  $Customerid)->first();
        $Logo = $customer['Client_Logo'];
        $customerName = $customer['RegistrationName'];
        $Icon = $customer['Client_Icon'];

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // app('debugbar')->info($Logo);

        $occupation = [];
        $countries = [];
        $funds = [];
        $bankNames = [];
        $provincesNames = [];
        $citiesNames = [];
        $Telephones = [];

        //try {
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
        // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        $LoggedInConsumerId = $fica['Consumerid'];
        $consumerIdentity = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $financial = Financial::where('FICA_id', '=',  $fica->FICA_id)->first();
        $declaration = Declaration::where('FICA_ID', '=',  $fica->FICA_id)->first();
        $kyc = KYC::where('FICA_id', '=',  $fica->FICA_id)->first();
        $dovs = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $comply = Compliance::where('FICA_id', '=',  $fica->FICA_id)->first();



        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $LoggedInConsumerId = $consumer['Consumerid'];
        $NotificationLink = SendEmail::where('Consumerid', '=',  $LoggedInConsumerId)->where('IsRead', '=', '1')->get();
        $request->session()->put('NotificationLink', $NotificationLink);

        app('debugbar')->info($NotificationLink);

        $bankTpye = BankAccountType::all();
        $lookupdata = LookupDatas::all();

        //Telephones on LookUpData Table
        foreach ($lookupdata as  $telephone) {
            if ($telephone->Type == 'Telephone Type Indicator') {
                array_push($Telephones, [$telephone->Text => $telephone->Value]);
            }
        }
        // $test = [];

        // foreach ($Telephones as $tel) {
        // }
        // app('debugbar')->info($Telephones[0]);


        // app('debugbar')->info($Telephones);


        // $NotificationLink = $request->session()->get('NotificationLink');

        // app('debugbar')->info($NotificationLink);

        $customer = Customer::where('Id', '=',  $customerUser->CustomerId)->first();
        // $NotificationLink = $request->session()->get('NotificationLink');
        //app('debugbar')->info($avs);
        // app('debugbar')->info($consumer2);

        $DOB = ($consumerIdentity->DOB != null) ? date('Y-m-d', strtotime($consumerIdentity->DOB)) : null;

        //select values from the dropdowlist
        $selectedIndustryofoccupation =  $consumer->Industryofoccupation;

        $selectedBankType = ($avs->BankTypeid != null) ?  $avs->BankTypeid : null;
        $selectSourceOfFunds = ($financial->Sources_Funds != null) ?  $financial->Sources_Funds : null;


        //get addresses
        // $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
        // $postalAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 15)->first();
        // $workAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 14)->first();

        // $homeAddressExist =  $homeAddress != null ? true : false;
        // $postalAddressExist =  $postalAddress != null ? true : false;
        // $workAddressExist =  $workAddress != null ? true : false;

        $Addresses = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $Home  = null;
        $Postal = null;
        $Work  = null;
        if ($Addresses) {
            foreach ($Addresses as $address) {
                if ($address['AddressTypeInd'] == 16) {
                    $Home = $address;
                } else if ($address['AddressTypeInd'] == 15) {
                    $Postal = $address;
                } else if ($address['AddressTypeInd'] == 14) {
                    $Work = $address;
                }
            }
        }

        $Telephone = Telephones::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $TelCell  = null;
        $TelHome = null;
        $TelWork  = null;
        if ($Telephone) {
            foreach ($Telephone as $tele) {
                if ($tele['TelephoneTypeInd'] == 12) {
                    $TelCell = $tele;
                } else if ($tele['TelephoneTypeInd'] == 11) {
                    $TelHome = $tele;
                } else if ($tele['TelephoneTypeInd'] == 10) {
                    $TelWork = $tele;
                }
            }
        }

        //Telephone
        // $telephone = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 11)->first();
        // $worktelephone = Telephones::where('ConsumerID', '=',   $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 10)->first();

        // $homeTelephoneNumber = ($telephone != null) ? $telephone->TelephoneCode . $telephone->TelephoneNo : null;
        // $workTelephoneNumber = ($worktelephone != null) ? $worktelephone->TelephoneCode . $worktelephone->TelephoneNo : null;

        //Check if addresses exist
        // if ($telephone != null) {
        //     $homeTelephoneNumebr =  $telephone->TelephoneCode . $telephone->TelephoneNo;
        // }

        // app('debugbar')->info($homeTelephoneNumebr);

        $stepState = $fica->FICAProgress != null ? (int)$fica->FICAProgress : 0;

        // app('debugbar')->info('stepState: ' . $stepState);

        $request->session()->put('stepState', $stepState);


        //Get IndustryOccupation
        $industryOccupation = IndustryOccupation::all();
        foreach ($industryOccupation as $industry) {
            // array_push($occupation, strtoupper($industry->Industry_occupation));
            array_push($occupation, $industry->Industry_occupation);
        }

        //Get Nationality
        // $nationality = Nationality::all()->sort($countries);
        $nationality = Nationality::all()->sortBy($countries);
        foreach ($nationality as $country) {
            // array_push($countries, strtoupper($country->Nationality));
            array_push($countries, $country->Nationality);
        }
        // sort($countries);

        //Get SourceOfFunds
        $sourceOfFunds = SourceOfFunds::all()->sortBy($funds);
        foreach ($sourceOfFunds as $sourceoffund) {
            // array_push($funds, strtoupper($sourceoffund->Funds));
            array_push($funds, $sourceoffund->Funds);
        }
        // sort($funds);

        //Geting banks
        $banks = Banks::all();
        foreach ($banks as $bank) {
            // array_push($bankNames, strtoupper($bank->bankname));
            array_push($bankNames, $bank->bankname);
        }

        //Geting Provinces
        $provinces = Provinces::all()->sortBy($provincesNames);
        foreach ($provinces as $province) {
            // array_push($provincesNames, $province->Province_name);
            array_push($provincesNames, $province->Province_name);
        }
        // sort($provincesNames);

        // Geting Cities but we changed it to input boxes so the drop down is disabled and this fucntion is pointless
        // $cities = Cities::all();
        // foreach ($cities as $city) {
        //     array_push($citiesNames, strtoupper($city->cityName));
        // }
        // sort($citiesNames);


        //app('debugbar')->info($citiesNames);


        $request->session()->put('FICAProgress', $fica->FICAProgress);

        //API Checks
        $APIResultStatus = ([
            'IDAS_Status' => isset($consumerIdentity->Identity_status) ?  (int)$consumerIdentity->Identity_status : 0,
            'KYC_Status' => isset($kyc->KYC_Status) ? (int)$kyc->KYC_Status : 0,
            'AVS_Status' => isset($avs->AVS_Status) ? (int)$avs->AVS_Status : 0,
            'DOVS_Status' => isset($dovs->DOVS_Status) ? (int)$dovs->DOVS_Status : 0,
            'Compliance_Status' => isset($comply->Compliance_Status) ? (int) $comply->Compliance_Status : 0
        ]);

        $validationCheck = ($APIResultStatus['KYC_Status'] != null || $APIResultStatus['AVS_Status'] != null  || $APIResultStatus['Compliance_Status'] != null) ?  true : false;
        app('debugbar')->info($APIResultStatus);
        app('debugbar')->info($validationCheck);

        $isValidationPassed = ($APIResultStatus['IDAS_Status'] == 1 && $APIResultStatus['KYC_Status'] == 1 && $APIResultStatus['AVS_Status'] == 1 && $APIResultStatus['DOVS_Status'] == 1 && $APIResultStatus['Compliance_Status'] == 1) ?   1 : 0;
        app('debugbar')->info('isValidationPassed: ' . $isValidationPassed);
        // return view('fica');

        return view('fica-process', [
            'fica' => $fica, 'consumer' => $consumer, 'consumerIdentity' => $consumerIdentity, 'customerUser' => $customerUser, 'Home' => $Home, 'Postal' => $Postal, 'Work' => $Work,
            'bankTpye' => $bankTpye, 'avs' => $avs, 'occupation' => $occupation, 'DOB' => $DOB, 'selectedIndustryofoccupation' => $selectedIndustryofoccupation, 'countries' => $countries,
            'funds' => $funds, 'selectSourceOfFunds' => $selectSourceOfFunds, 'financial' => $financial, 'customer' => $customer, 'declaration' => $declaration, 'bankNames' => $bankNames,
            'validationCheck' => $validationCheck, 'provincesNames' => $provincesNames, 'Telephones' => $Telephones, 'NotificationLink' => $NotificationLink, 'TelWork' => $TelWork, 'TelHome' => $TelHome, 'TelCell' => $TelCell,
            'isValidationPassed' => $isValidationPassed, 'APIResultStatus' => $APIResultStatus, 'Logo' => $Logo, 'customerName' => $customerName, 'Icon' => $Icon,
        ]);
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }
    }

    public function uploadfile(Request $request)
    {

        $client = Auth::user();
        $customer = Customer::getCustomerDetails($client->CustomerId);
        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $Logo = $customer->Client_Logo;
        $customerName = $customer->RegistrationName;
        $Icon = $customer->Client_Icon;


        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        // app('debugbar')->info($Logo);

        $occupation = [];
        $countries = [];
        $funds = [];
        $images = [];
        $extractedData = [];
        $bankNames = [];
        $provincesNames = [];
        $citiesNames = [];
        $Telephones = [];

        //try {
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $customerUser = CustomerUser::where('Id', '=',  $loggedInUserId)->first();
        // $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->where('FICAStatus', '=', 'In progress')->first();
        $fica = FICA::where('Consumerid', '=',  $consumer->Consumerid)->first();
        // dd($fica);
        $LoggedInConsumerId = $fica['Consumerid'];
        $consumerIdentity = ConsumerIdentity::where('Identity_Document_ID', '=',  $consumer->IDNUMBER)->first();
        $avs = AVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $financial = Financial::where('FICA_id', '=',  $fica->FICA_id)->first();
        $declaration = Declaration::where('FICA_ID', '=',  $fica->FICA_id)->first();
        $kyc = KYC::where('FICA_id', '=',  $fica->FICA_id)->first();
        $dovs = DOVS::where('FICA_id', '=',  $fica->FICA_id)->first();
        $comply = Compliance::where('FICA_id', '=',  $fica->FICA_id)->first();

        $LoggedInConsumerId = $consumer['Consumerid'];
        $NotificationLink = SendEmail::where('Consumerid', '=',  $LoggedInConsumerId)->where('IsRead', '=', '1')->get();
        // $request->session()->put('NotificationLink', $NotificationLink);



        $bankTpye = BankAccountType::all();
        $aws = new awsController();

        $lookupdata = LookupDatas::all();

        //Telephones on LookUpData Table
        foreach ($lookupdata as  $telephone) {
            if ($telephone->Type == 'Telephone Type Indicator') {
                array_push($Telephones, [$telephone->Value => $telephone->Text]);
            }
        }

        // $homeAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 16)->first();
        // $postalAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 15)->first();
        // $workAddress = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('AddressTypeInd', '=', 14)->first();

        //Telephone
        // $telephone = Telephones::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 11)->first();
        // $worktelephone = Telephones::where('ConsumerID', '=',   $fica->Consumerid)->where('RecordStatusInd', '=', 1)->where('TelephoneTypeInd', '=', 10)->first();

        // $homeTelephoneNumber = ($telephone != null) ? $telephone->TelephoneCode . $telephone->TelephoneNo : null;
        // $workTelephoneNumber = ($worktelephone != null) ? $worktelephone->TelephoneCode . $worktelephone->TelephoneNo : null;
        // $homeTelephoneNumebr = ($telephone != null) ? $telephone->TelephoneCode . $telephone->TelephoneNo : null;

        // app('debugbar')->info($homeTelephoneNumebr);

        // $homeAddressExist =  $homeAddress != null ? true : false;
        // $postalAddressExist =  $postalAddress != null ? true : false;
        // $workAddressExist =  $workAddress != null ? true : false;

        $Addresses = Address::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $Home  = null;
        $Postal = null;
        $Work  = null;
        if ($Addresses) {
            foreach ($Addresses as $address) {
                if ($address['AddressTypeInd'] == 16) {
                    $Home = $address;
                } else if ($address['AddressTypeInd'] == 15) {
                    $Postal = $address;
                } else if ($address['AddressTypeInd'] == 14) {
                    $Work = $address;
                }
            }
        }

        $Telephone = Telephones::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $TelCell  = null;
        $TelHome = null;
        $TelWork  = null;
        if ($Telephone) {
            foreach ($Telephone as $tele) {
                if ($tele['TelephoneTypeInd'] == 12) {
                    $TelCell = $tele;
                } else if ($tele['TelephoneTypeInd'] == 11) {
                    $TelHome = $tele;
                } else if ($tele['TelephoneTypeInd'] == 10) {
                    $TelWork = $tele;
                }
            }
        }

        $DOB =  date('Y-m-d', strtotime($consumerIdentity->DOB));

        //select values from the dropdowlist
        $selectedIndustryofoccupation =  $consumer->Industryofoccupation;
        $selectSourceOfFunds = ($financial->Sources_Funds != null) ?  $financial->Sources_Funds : null;
        // $selectSourceOfFunds = $financial->Sources_Funds;

        $NotificationLink = $request->session()->get('NotificationLink');

        //Get IndustryOccupation
        $industryOccupation = IndustryOccupation::all();
        foreach ($industryOccupation as $industry) {
            array_push($occupation, $industry->Industry_occupation);
        }

        //Get Nationality
        $nationality = Nationality::all()->sortBy($countries);
        foreach ($nationality as $country) {
            // array_push($countries, strtoupper($country->Nationality));
            array_push($countries, $country->Nationality);
        }
        // sort($countries);

        //Get SourceOfFunds
        $sourceOfFunds = SourceOfFunds::all()->sortBy($funds);
        foreach ($sourceOfFunds as $sourceoffund) {
            // array_push($funds, strtoupper($sourceoffund->Funds));
            array_push($funds, $sourceoffund->Funds);
        }
        // sort($funds);

        //Geting banks
        $banks = Banks::all()->sortBy($bankNames);
        foreach ($banks as $bank) {
            // array_push($bankNames, strtoupper($bank->bankname));
            array_push($bankNames, $bank->bankname);
        }
        // sort($bankNames);

        //Geting Provinces
        $provinces = Provinces::all()->sortBy($provincesNames);
        foreach ($provinces as $province) {
            // array_push($provincesNames, strtoupper($province->Province_name));
            array_push($provincesNames, $province->Province_name);
        }
        // sort($provincesNames);

        //Geting Cities
        $citiesNames = Cities::all()->sortBy($citiesNames);
        // foreach ($cities as $city) {
        //     // array_push($citiesNames, strtoupper($city->cityName));
        //     array_push($citiesNames, $city->cityName);
        // }
        // sort($citiesNames);

        //Update fica progress bar 
        $request->session()->put('FICAProgress', $fica->FICAProgress);

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,tiff'
        ]);

        $type = substr($request->file->getClientMimeType(), -3);
        $size = $request->file->getSize();
        // $path = '';
        $url = config('app.API_UPLOAD_PATH');
        $urlFile = '';

        $file = $request->file;
        $getfileName = $file->getClientOriginalName();
        $fileSubString = str::limit($getfileName, 40);
        $fileextension = substr($getfileName, -4);
        $fileName = $fileSubString . $fileextension;

        // $DocIDNumber = $SearchCustomerId['IDNUMBER'];
        // $DocTime = Carbon::now()->year();
        // $fileName = $DocIDNumber.$DocTime;
        $imagePath = '';
        $pdfTempPath = '';

        //Check if uploaded file is pdf

        $path = public_path('tempImages/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($type == 'pdf') {
            $request->file->move(public_path('pdf'), $fileName);
            //$firstPage =  $fileName . '[0]';
            $pdfPath = 'pdf/' .  $fileName;
            // $pdfPath = 'C:/PROJECT/V1.2/FICA_V1/public/pdf/' .  $fileName;

            app('debugbar')->info($pdfPath);
            $imagePath = $this->convertingPdfToImages($pdfPath);
        } else {
            $request->file->move(public_path('tempImages'), $fileName);
            $imagePath = 'tempImages/' . $fileName;
        }


        //Get all the images on the tempImages
        $files = File::files(public_path('tempImages/'));
        //Looping through tempImage folder
        foreach ($files as $file) {
            $images[] = $file->getRelativePathname();
        }

        //Read the first two pages using aws textract
        foreach ($images as $page) {
            if (count($extractedData) < 2) {
                $data =  $aws->TextractAmazonOCR(public_path('tempImages/' . $page), $request);
                array_push($extractedData, $data);
            }
        }

        //me
        $mergedData = call_user_func_array('array_merge', $extractedData);

        app('debugbar')->info($extractedData);

        app('debugbar')->info($mergedData);

        //ID Upload checks
        if ($request->stage == 'id') {
            app('debugbar')->info('ID Stage');
            $IDResults = $aws->smartCardAndGreenBookID($mergedData, $request);
            app('debugbar')->info($IDResults['status']);

            //Check if the ID Number is valide and store the ID copy to S3
            if ($IDResults['status'] == true) {
                $filePath = $customerUser->CustomerId . '- test' . '/' . $consumer->Consumerid . '/' . $fica->FICA_id . '/' . 'ID_' . $fileName;
                //Production S3 Folder
                // $filePath = $customerUser->CustomerId . '/' . $consumer->Consumerid . '/' . $fica->FICA_id . '/' . 'ID_' . $fileName;
                //Storing the file in s3 bucket
                if ($type == 'pdf') {
                    $pdfTempPath = public_path('pdf/' . $fileName);
                    Storage::disk('s3')->put($filePath, file_get_contents($pdfTempPath));
                } else {
                    Storage::disk('s3')->put($filePath, file_get_contents(public_path('tempImages/' . $fileName)));
                }
                $urlFile =   $url . $filePath;

                //Storing Documents url to the database
                ConsumerIdentity::where('FICA_id', $fica->FICA_id)->update(
                    array(
                        'Identity_Documentname' => $fileName,
                        'Identity_File_Path' =>  $urlFile,
                    )
                );
            }

            app('debugbar')->info($request);

            // $pathPDF = 'pdf/' . $fileName;
            //Remove the file in the application
            $this->deleteAllTempFiles(public_path('tempImages/*'));
            $this->deleteAllTempFiles(public_path('pdf/*'));
            // $this->removeImage($imagePath);
            // $this->removeImage($pathPDF);
            $response = ['status' => true, 'data' =>  $IDResults];
            return $response;
        }

        //Address Upload checks
        if ($request->stage == 'address') {
            app('debugbar')->info('Address Stage');
            $docDate = $aws->address($mergedData, $request);

            // if ($docDate <= 700) {
            // Store Proof Of Address document in S3 if document date is less than 3 months
            $filePath = $customerUser->CustomerId . '/' . $consumer->Consumerid . '/' . $fica->FICA_id . '/' . 'ADDRESS_' . $fileName;
            //Storing the file in s3 bucket
            if ($type == 'pdf') {
                $pdfTempPath = public_path('pdf/' . $fileName);
                Storage::disk('s3')->put($filePath, file_get_contents($pdfTempPath));
            } else {
                Storage::disk('s3')->put($filePath, file_get_contents(public_path('tempImages/' . $fileName)));
            }
            $urlFile =   $url . $filePath;

            //Storing Documents url to the database
            KYC::where('FICA_id', $fica->FICA_id)->update(
                array(
                    'Address_Documentname' => $fileName,
                    'Address_File_Path' =>  $urlFile,
                )
            );
            //}
            // $pathPDF = 'pdf/' . $fileName;
            //Remove the file in the application
            $this->deleteAllTempFiles(public_path('tempImages/*'));
            $this->deleteAllTempFiles(public_path('pdf/*'));

            app('debugbar')->info('Document Date: ' . $docDate);
        }

        //Bank statement Upload checks
        if ($request->stage == 'bank') {
            app('debugbar')->info('Bank Stage');
            $bank =  $aws->bankDetails($mergedData, $request);

            // if ($docDate <= 10) {
            // Store Proof Of Address document in S3 if document date is less than 3 months
            $filePath = $customerUser->CustomerId . '/' . $consumer->Consumerid . '/' . $fica->FICA_id . '/' . 'BANK_' . $fileName;
            //Storing the file in s3 bucket
            if ($type == 'pdf') {
                $pdfTempPath = public_path('pdf/' . $fileName);
                Storage::disk('s3')->put($filePath, file_get_contents($pdfTempPath));
            } else {
                Storage::disk('s3')->put($filePath, file_get_contents(public_path('tempImages/' . $fileName)));
            }
            $urlFile =   $url . $filePath;

            //Storing Documents url to the database
            AVS::where('FICA_id', $fica->FICA_id)->update(
                array(
                    'Bank_Documentname' => $fileName,
                    'Bank_File_Path' =>  $urlFile,
                )
            );
            //   }
            $this->deleteAllTempFiles(public_path('tempImages/*'));
            $this->deleteAllTempFiles(public_path('pdf/*'));
        }

        //API Checks
        $APIResultStatus = ([
            'IDAS_Status' => isset($consumerIdentity->Identity_status) ?  (int)$consumerIdentity->Identity_status : 0,
            'KYC_Status' => isset($kyc->KYC_Status) ? (int)$kyc->KYC_Status : 0,
            'AVS_Status' => isset($avs->AVS_Status) ? (int)$avs->AVS_Status : 0,
            'DOVS_Status' => isset($dovs->DOVS_Status) ? (int)$dovs->DOVS_Status : 0,
            'Compliance_Status' => isset($comply->Compliance_Status) ? (int) $comply->Compliance_Status : 0
        ]);


        $validationCheck = ($APIResultStatus['KYC_Status'] != null || $APIResultStatus['AVS_Status'] != null  || $APIResultStatus['Compliance_Status'] != null) ?  true : false;
        app('debugbar')->info($APIResultStatus);
        app('debugbar')->info($validationCheck);
        $isValidationPassed = ($APIResultStatus['IDAS_Status'] == 1 && $APIResultStatus['KYC_Status'] == 1 && $APIResultStatus['AVS_Status'] == 1 && $APIResultStatus['DOVS_Status'] == 1 && $APIResultStatus['Compliance_Status'] == 1) ?   true : false;
        app('debugbar')->info('validationCheck: ' . $isValidationPassed);


        return view('fica-process', [
            'fica' => $fica, 'consumer' => $consumer, 'Home' => $Home, 'Postal' => $Postal, 'Work' => $Work, 'consumerIdentity' => $consumerIdentity, 'customerUser' => $customerUser,
            'bankTpye' => $bankTpye, 'avs' => $avs, 'occupation' => $occupation, 'DOB' => $DOB, 'selectedIndustryofoccupation' => $selectedIndustryofoccupation, 'countries' => $countries,
            'funds' => $funds, 'selectSourceOfFunds' => $selectSourceOfFunds, 'financial' => $financial, 'customer' => $customer, 'declaration' => $declaration, 'bankNames' => $bankNames,
            'validationCheck' => $validationCheck, 'provincesNames' => $provincesNames, 'citiesNames' => $citiesNames, 'Telephones' => $Telephones, 'Logo' => $Logo, 'customerName' => $customerName, 'Icon' => $Icon,
            'NotificationLink' => $NotificationLink, 'isValidationPassed' => $isValidationPassed, 'APIResultStatus' => $APIResultStatus, 'TelWork' => $TelWork, 'TelHome' => $TelHome, 'TelCell' => $TelCell,
        ]);
        // } catch (\Exception $e) {
        //     app('debugbar')->info($e);
        // }
    }

    //Converting PDF to jpg Image
    public function convertingPdfToImages($pdfTempPath,)
    {
        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        //$imagick->readImage(public_path('pdf/83260744002_20220517.pdf'));
        $imagick->readImage($pdfTempPath);
        //$imagick->setImageIndex(0);
        $imagick->setImageFormat("jpg");
        // $imagick->setImageUnits(200, 200);
        $imagick->writeImages(public_path('tempImages/page.jpg'), true);
        return 'tempImages/page.jpg';
        // $imagick->writeImages(public_path('tempImages/page.jpg'), true);
    }

    //Delete all Temp Files
    public function deleteAllTempFiles($path)
    {
        $files = glob($path); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }
    //Delete a sing file
    public function removeImage($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        } else {
            //dd('File does not exists.');
        }
    }
}
