<?php

namespace App\Jobs;

use App\Models\Consumer;
use App\Models\ConsumerIdentity;
use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\DebtSummary;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\SelfBankingCompanySRN;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use DateTime;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class SBExtract implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date1;
    protected $date2;
    protected $disk;
    protected $sbids;
    protected $keyofchunks;
    protected $totalcount;
    protected $chunk_size;

    public function __construct($key, $sbids, $totalcount, $chunk_size)
    {
        $this->date1 = "2024-10-10"; //date("Y-m-d"); //"2024-08-15"; //date("Y-m-d");
        $this->date2 = "10102024"; //date("dmY"); //"15082024"; //date("dmY");
        $this->disk = 'public'; //'sftp';
        $this->sbids = $sbids;
        $this->keyofchunks = $key;
        $this->totalcount = $totalcount;
        $this->chunk_size = $chunk_size;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'handle function of SBExtract job';

        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $compliteidlist_list = implode(',', $this->sbids);
        $today = new DateTime($this->date1);

        $batchId = $this->batch()->id;
        $testing  = SelfBankingDetails::getsbresults($today, $compliteidlist_list);

        if (empty($testing)) {
            return false;
        }


        $ComplianceData = [];
        $data = [];
        $debt_summary_data = [];
        $SelfBankingCompanySRN = [];

        $avs = '';
        $kyc = '';
        $compliance = '';
        $debt = '';
        $facial = '';
        $filedata = '';
        $PersonalDetails = "";
        $DOVS = "";
        $BankingDetails = "";

        $count = ($this->keyofchunks ) * ($this->chunk_size);
        $RiskStatusbyFICA = '';
        $formattedDate = '';
        foreach ($testing as $key => $compliance_id) {
            $ConsumerID = $compliance_id;

           $SelfBankingDetailsId = $testing[$key]->SelfBankingDetailsId;

            $SelfBankinglinkId = $testing[$key]->SelfBankingLinkId;


            $selfbankinglink = SelfBankingLink::where('Id', '=',  $SelfBankinglinkId)->first();
            $PersonalDetails = $selfbankinglink->PersonalDetails;
            $DOVS = $selfbankinglink->DOVS;
            $BankingDetails = $selfbankinglink->BankingDetails;
            $SelfBankingCompanySRN =  SelfBankingCompanySRN::where('SelfBankingdetailsId', $SelfBankingDetailsId)->get();
            $consumerIdentity  = ConsumerIdentity::where('FICA_id', '=',  $testing[$key]->FICA_id)->first();


            $data = [
                'Customerid' => $testing[$key]->Customerid,
                'FirstName' => $testing[$key]->FirstName,
                'SecondName' => $testing[$key]->SecondName,
                'ThirdName' => $testing[$key]->ThirdName,
                'SURNAME' => $testing[$key]->SURNAME,
                'Lname' => $testing[$key]->Lname,
                'SecName' => $testing[$key]->SecName,
                'TName' => $testing[$key]->TName,
                'Fname' => $testing[$key]->Fname,
                // Residence Address
                'Res_OriginalAdd1' => $testing[$key]->Res_OriginalAdd1,
                'Res_OriginalAdd2' => $testing[$key]->Res_OriginalAdd2,
                'Res_OriginalAdd3' => $testing[$key]->Res_OriginalAdd3,
                'Res_Pcode' => $testing[$key]->Res_Pcode,
                'ResProvince' => $testing[$key]->Res_OriginalAdd4,
                'IDNUMBER' => $testing[$key]->IDNUMBER,
                'Email' => $testing[$key]->Email,

                'BirthDate' =>  $testing[$key]->BirthDate,

                'CellCode' => $testing[$key]->CellCode,
                'CellNo' => $testing[$key]->CellNo,
                'HomeTelCode' => $testing[$key]->HomeTelCode,
                'HomeTelNo' => $testing[$key]->HomeTelNo,
                'WorkTelCode' => $testing[$key]->WorkTelCode,
                'WorkTelNo' => $testing[$key]->WorkTelNo,


                //Bank Account Details
                'Account_no' => $testing[$key]->Account_no,
                'Account_name' => $testing[$key]->Account_name,
                'Branch_code' => $testing[$key]->Branch_code,
                'Bank_name' => $testing[$key]->Bank_name,
                'Branch' => $testing[$key]->Branch,
                'ACCOUNT_OPEN' => $testing[$key]->ACCOUNT_OPEN,
                'ACCOUNTDORMANT' => $testing[$key]->ACCOUNTDORMANT,
                //'AccountType' => $testing[$key]->AccountType,
                'BankTypeid' => $testing[$key]->BankTypeid,
                'INITIALS' => $testing[$key]->AccountHolderInitial,
                'INITIALSMATCH' => $testing[$key]->INITIALSMATCH,
                'IDNUMBERMATCH' => $testing[$key]->IDNUMBERMATCH,
                'SURNAMEMATCH' => $testing[$key]->SURNAMEMATCH,
                'EMAILMATCH' => $testing[$key]->EMAILMATCH,
                'Email' => $testing[$key]->Email,
                'ACCOUNTOPENFORATLEASTTHREEMONTHS' => $testing[$key]->ACCOUNTOPENFORATLEASTTHREEMONTHS,
                'ACCOUNTACCEPTSDEBITS' => $testing[$key]->ACCOUNTACCEPTSDEBITS,
                // 'ACCOUNTACCEPTSCREDITS' => $testing[$key]->ACCOUNTACCEPTSCREDITS,
                'DeceasedStatus' => $testing[$key]->DeceasedStatus,

                //Facial Recognition
                'CreatedOnDate' => $testing[$key]->CreatedOnDate,
                'FICAStatus' => $testing[$key]->FICAStatus,
                'ConsumerIDPhotoMatch' => $testing[$key]->ConsumerIDPhotoMatch,
                'MatchResponseCode' => $testing[$key]->MatchResponseCode,
                'LivenessDetectionResult' => $testing[$key]->LivenessDetectionResult,
                'Latitude' => $testing[$key]->Latitude,
                'Longitude' => $testing[$key]->Longitude,
                'CellularNo' => $testing[$key]->CellularNo,
                'HomeTelephoneNo' => $testing[$key]->HomeTelephoneNo,
                'PhoneNumber' => $testing[$key]->PhoneNumber,
                'WorkTelephoneNo' => $testing[$key]->WorkTelephoneNo,
                'PostalAddress' => $testing[$key]->PostalAddress,
                'ResidentialAddress' => $testing[$key]->ResidentialAddress,
                'Longitude' => $testing[$key]->Longitude,
                'ConsumerIDPhoto' => $testing[$key]->ConsumerIDPhoto,
                'ConsumerCapturedPhoto' => $testing[$key]->ConsumerCapturedPhoto,
                //HA Details
                'HA_IDNO' => $testing[$key]->IDNo,
                'HA_Names' => $testing[$key]->FirstName,
                'HA_Surname' => $testing[$key]->Surname,
                'HA_DateOfBirth' => $testing[$key]->BirthDate,
                'HA_DeceasedStatus' => $testing[$key]->DeceasedStatus,
                'HA_Gender' => $testing[$key]->Gender,
                'HA_EnquiryReference' => $testing[$key]->ReferenceNo,
                'MaritalStatusDesc' => $testing[$key]->MaritalStatusDesc,
                'TitleDesc' => $testing[$key]->TitleDesc,

            ];

            $cell1 = $consumerIdentity->CELL_1_PHONE_NUMBER;
            $cell2 = $consumerIdentity->CELL_2_PHONE_NUMBER;
            $cell3 = $consumerIdentity->CELL_3_PHONE_NUMBER;
            $cell4 = $consumerIdentity->CELL_4_PHONE_NUMBER;
            $cell5 = $consumerIdentity->CELL_5_PHONE_NUMBER;
            $cellmatch = "Unmatched";
            $emailmatch = 'Unmatched';
            $namematch = 'Unmatched';
            $smatch = 'Unmatched';
            $secnamematch = 'Unmatched';
            $thirdnamematch = 'Unmatched';
            if($data['PhoneNumber'] ==$cell1 || $data['PhoneNumber'] ==$cell2 ||
            $data['PhoneNumber'] ==$cell3 || $data['PhoneNumber'] ==$cell4|| $data['PhoneNumber'] ==$cell5)
            {
               $cellmatch = 'Matched';
            }
            if(strtolower($data['Email']) == strtolower($consumerIdentity->X_EMAIL) )
            {
               $emailmatch = 'Matched';
            }
            if(strtolower($data['Fname']) == strtolower($consumerIdentity->FIRSTNAME))
            {
               $namematch = 'Matched';
            }
            elseif ($data['Fname'] == null)
            {
                $namematch = 'Not Available';
            }
            else
            {
                $namematch = 'Unmatched';
            }
            if(strtolower($data['SecName']) == strtolower($consumerIdentity->SECONDNAME) && $data['SecName'] !== null)
            {
               $secnamematch = 'Matched';
            }
            elseif ($data['SecName'] == null)
            {
                $secnamematch = 'Not Available';
            }
            else
            {
                $secnamematch = 'Unmatched';
            }

            if(strtolower($data['TName']) == strtolower($consumerIdentity->OTHER_NAMES)   )
            {
               $thirdnamematch = 'Matched';
            }
            elseif ($data['TName'] == null)
            {
                $thirdnamematch = 'Not Available';
            }
            else
            {
                $thirdnamematch = 'Unmatched';
            }

            if(strtolower($data['Lname']) == strtolower($consumerIdentity->SURNAME) )
            {
               $smatch = 'Matched';
            }
            elseif ($data['Lname'] == null)
            {
                $smatch = 'Not Available';
            }
            else
            {
                $smatch = 'Unmatched';
            }


            $VerificationStaticPhoto = base64_encode(file_get_contents(public_path('images/results/client1.png')));
            $PaymentPhoto = base64_encode(file_get_contents(public_path('images/results/AVS.png')));
            $FacialPhoto = base64_encode(file_get_contents(public_path('images/results/facephone4.png')));
            $tick = base64_encode(file_get_contents(public_path('assets/images/small/tick.png')));
            $question = base64_encode(file_get_contents(public_path('assets/images/question.png')));
            $cross = base64_encode(file_get_contents(public_path('assets/images/small/cross.png')));
            $xds = base64_encode(file_get_contents(public_path('assets/images/small/xds1.png')));

            //$customer = Customer::getCustomerDetails($testing[$key]->Customerid);
            //$Logo = $customer->Client_Logo;
           // $font_colour = $customer->Client_Font_Code;

            $pdf = FacadePdf::loadView(
                'bulk-pdfs.sbextract',
                [
                    'data' => $data,
                    'SelfBankingCompanySRN' => $SelfBankingCompanySRN,
                    'VerificationStaticPhoto' => $VerificationStaticPhoto,
                    'PaymentPhoto' => $PaymentPhoto,
                    'FacialPhoto' => $FacialPhoto,
                    'tick' => $tick,
                    'question' => $question,
                    'cross' => $cross,
                    'xds' => $xds,
                    'avs' => $avs,
                    'today' => $today->format('m/d/Y'),
                    'formattedDate' => $formattedDate,
                    //'Logo' => $Logo,
                    //'font_colour' => $font_colour,
                    'PersonalDetails' => $PersonalDetails,
                    'DOVS' => $DOVS,
                    'BankingDetails' => $BankingDetails,
                    'cellmatch' => $cellmatch,
                    'emailmatch' => $emailmatch,
                    'thirdnamematch' => $thirdnamematch,
                    'secnamematch' => $secnamematch,
                    'namematch' => $namematch,
                    'smatch' => $smatch,
                    'ha_name' => $consumerIdentity->FIRSTNAME,
                    'ha_secondname' => $consumerIdentity->SECONDNAME,
                    'ha_surname' => $consumerIdentity->SURNAME,

                ]
            );


            $pdf->setPaper('A2', 'portrait');

            $count = $count + 1;

            if ($count < 10)
                $row = "0000000" . (string)$count;
            else if ($count < 100)
                $row = "000000" . (string)$count;
            else if ($count < 1000)
                $row =  "00000" . (string)$count;
            else if ($count < 10000)
                $row = "0000" . (string)$count;
            else if ($count < 100000)
                $row = "000" . (string)$count;
            else if ($count < 1000000)
                $row =  "00" . (string)$count;
            else if ($count < 10000000)
                $row =  "0" . (string)$count;
            else $row = (string)$count;

            $dateformate = date("d-m-Y", strtotime($this->date1));

            //$content = $row . ",CSS-LNK," . $data['Client_Ref'] . "," . $row . "_" . $data['Client_Ref'] . "_iFICADOCS.pdf,Account_Confirmation_Details," . $dateformate . ",FICA," . $dateformate . "\n";


            //$filedata = $filedata . $content;

            $pdfilename =  $row . "_" . $SelfBankingDetailsId . "_SelfBankingDOCS.pdf";
            //$pdf->save($pdfilename, 'public');
            $lastiteration = $count == $this->totalcount ? 1 : 0;

            $this->transferfile($pdf, $pdfilename,$data['FirstName'],$data['SURNAME'], $data['IDNUMBER'],$data['Account_no'],$data['Branch_code'],$data['Bank_name'],$data['Email'],$data['PhoneNumber'],$data['FICAStatus'], $count, $type = 'sb', $lastiteration, $data['Customerid']);

        }

        /* $fileName = 'Contact Centre Due Diligence/Extraction_' . $this->date2 . '/' . 'index.txt';

        if (Storage::disk($this->disk)->exists($fileName)) {
            // Append the content to the existing file
            Storage::disk($this->disk)->append($fileName, $filedata);
        }else{
            // Write the content to a file
            Storage::disk($this->disk)->put($fileName, $filedata);
        } */
        return 'files written successfully';

    }

    public function transferfile($pdf, $filename,$name,$Surname, $ID_Number,$Bank_Account_Number,$Branch_Code,$Bank_Name,$Email_Address,$Mobile_Number,$FICA_Status, $index, $type, $lastiteration, $custID)
    {
        $customer = Customer::getCustomerDetails($custID);
        $Year = Carbon::now()->year;
        if (!empty($filename)) {

            /* below code is to store the  file cs's server with sftp driver
           $filepath - server path where file needs to be stored*/

            $foldername = $type == 'sb' ? 'Self Banking Extract' : '';
            $mailsubject = $type == 'sb' ? 'Self Banking PDFs - ' . $this->date1 : ' - ' . $this->date1;

            $filePath = '/' . $foldername . '/Extraction_' . $this->date2 . '/' . $filename;
            // Storage::disk('sftp')->put($filePath, $data);

            try {
                //Storage::disk('sftp')->put($filePath, $data, 'public');
                $pdf->save($filePath, $this->disk);
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage();
                exit;
            }

             $xlfilename = public_path('SelfBankingPDFs_' . $this->date1 . '.xlsx');

            $dd_res = [$index + 1, $filename, $name,$Surname, $ID_Number,$Bank_Account_Number,$Branch_Code,$Bank_Name,$Email_Address,$Mobile_Number,$FICA_Status];
            if (file_exists($xlfilename)) {
                $spreadsheet = IOFactory::Load($xlfilename);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
            } else {
                $spreadsheet = new Spreadsheet();
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet->getColumnDimension('A')->setWidth(15); // Row Number
                $worksheet->getColumnDimension('B')->setWidth(45); // Filename
                $worksheet->getColumnDimension('C')->setWidth(20); // First_Name
                $worksheet->getColumnDimension('D')->setWidth(20); // Surname
                $worksheet->getColumnDimension('E')->setWidth(15); // ID Number
                $worksheet->getColumnDimension('F')->setWidth(15); // Bank_Account_Number
                $worksheet->getColumnDimension('G')->setWidth(14); // Branch_Code
                $worksheet->getColumnDimension('H')->setWidth(20); // Bank_Name
                $worksheet->getColumnDimension('I')->setWidth(30); // Email_Address
                $worksheet->getColumnDimension('J')->setWidth(13); // Mobile_Number
                $worksheet->getColumnDimension('K')->setWidth(20); // Mobile_Number
                $data = [

                    ['Row Number','Filename', 'First_Name', 'Surname', 'ID Number','Bank_Account_Number','Branch_Code','Bank_Name','Email_Address','Mobile_Number', 'FICA_Status']

                ];
                foreach ($data as $rowNum => $rowData) {
                    $worksheet->fromArray($rowData, null, 'A' . ($rowNum + 1));

                }


                $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save($xlfilename);
            }

            $spreadsheet = IOFactory::Load($xlfilename);
            $worksheet = $spreadsheet->getActiveSheet();
            $row = $worksheet->getHighestRow() + 1;
            $worksheet->insertNewRowBefore($row);
            $worksheet->fromArray($dd_res, null, 'A' . $row);

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save($xlfilename);

            /* if ($lastiteration == 1) {
                Mail::send(
                    'auth.bulk_dd_pdfs',
                    ['Logo' => $customer->Client_Logo, 'TradingName' => $customer->RegistrationName, 'YearNow' => $Year, 'type' => $type],
                    function ($message) use ($xlfilename, $mailsubject) {
                        $message->to(config("app.CS_CUSTOMER_EMAIL_BULKPDF"));
                        $message->subject($mailsubject);
                        $message->attach($xlfilename);
                    }
                );
                sleep(2);
                unlink($xlfilename);
            } else {
                print_r('not in');
            }*/
        } else {
            echo "No Data Sent";
        }
        //exit();
    }

}
