<?php

namespace App\Jobs;

use App\Models\Consumer;
use App\Models\ConsumerIdentity;
use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\DebtSummary;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\SelfBankingDetails;
use Carbon\Carbon;
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
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
        $this->date1 = "2024-10-11"; //date("Y-m-d"); //"2024-08-15"; //date("Y-m-d");
        $this->date2 = "11102024"; //date("dmY"); //"15082024"; //date("dmY");
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
        $FetchComplianceSanct = [];
        $FetchComplianceAdd = [];
        $ConsumerIDPhotos = [];
        $avs = '';
        $kyc = '';
        $compliance = '';
        $debt = '';
        $facial = '';
        $filedata = '';
        $count = ($this->keyofchunks ) * ($this->chunk_size);
        $RiskStatusbyFICA = '';
        $formattedDate = '';
        foreach ($testing as $key => $compliance_id) {
            $ConsumerID = $compliance_id;
            $SelfBankingDetailsId = $testing[$key]->SelfBankingDetailsId;


            $data = [
                'Customerid' => $testing[$key]->Customerid,
                'FirstName' => $testing[$key]->FirstName,
                'SURNAME' => $testing[$key]->SURNAME,
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
                'ConsumerIDPhotoMatch' => $testing[$key]->ConsumerIDPhotoMatch,
                'MatchResponseCode' => $testing[$key]->MatchResponseCode,
                'LivenessDetectionResult' => $testing[$key]->LivenessDetectionResult,
                'Latitude' => $testing[$key]->Latitude,
                'Longitude' => $testing[$key]->Longitude,
                //HA Details
                'HA_IDNO' => $testing[$key]->IDNo,
                'HA_Names' => $testing[$key]->FirstName,
                'HA_Surname' => $testing[$key]->Surname,
                'HA_DateOfBirth' => $testing[$key]->BirthDate,
                'HA_DeceasedStatus' => $testing[$key]->DeceasedStatus,
                'HA_Gender' => $testing[$key]->Gender,
                'HA_EnquiryReference' => $testing[$key]->ReferenceNo,


            ];


            $getSearchFica = FICA::where('Consumerid', '=', $SelfBankingDetailsId)->first();
            $SearchFica = $getSearchFica['FICA_id'];

           
            
       
            $data['cellmatch'] = 'Unmatched';
            $data['workmatch'] = 'Unmatched';
            $data['homematch'] = 'Unmatched';
            $data['emailmatch'] = 'Unmatched';
            $data['idas_firstname_match'] = 'Unmatched';
            $data['idas_surname_match'] = 'Unmatched';
            $data['fullnamesmatch'] = 'Unmatched';

            $getConsumerIDdetails = ConsumerIdentity::where('FICA_id', '=', $getSearchFica['FICA_id'])->first();
            $inputcellnumber = $data['CellCode'] . $data['CellNo'];
            $inputHomenumber = $data['HomeTelCode'] . $data['HomeTelNo'];
            $inputworknumber = $data['WorkTelCode'] . $data['WorkTelNo'];
            if (
                $inputcellnumber == $getConsumerIDdetails->CELL_1_PHONE_NUMBER || $inputcellnumber == $getConsumerIDdetails->CELL_2_PHONE_NUMBER
                || $inputcellnumber == $getConsumerIDdetails->CELL_3_PHONE_NUMBER || $inputcellnumber == $getConsumerIDdetails->CELL_4_PHONE_NUMBER
                || $inputcellnumber == $getConsumerIDdetails->CELL_5_PHONE_NUMBER
            ) {
                $data['cellmatch'] = 'Matched';
            }

            if (
                $inputHomenumber == $getConsumerIDdetails->WORK_1_PHONE_NUMBER || $inputHomenumber == $getConsumerIDdetails->WORK_2_PHONE_NUMBER
                || $inputHomenumber == $getConsumerIDdetails->WORK_3_PHONE_NUMBER || $inputHomenumber == $getConsumerIDdetails->WORK_4_PHONE_NUMBER
                || $inputHomenumber == $getConsumerIDdetails->WORK_5_PHONE_NUMBER
            ) {
                $data['workmatch'] = 'Matched';
            }

            if (
                $inputworknumber == $getConsumerIDdetails->HOME_1_PHONE_NUMBER || $inputworknumber == $getConsumerIDdetails->HOME_2_PHONE_NUMBER
                || $inputworknumber == $getConsumerIDdetails->HOME_3_PHONE_NUMBER || $inputworknumber == $getConsumerIDdetails->HOME_4_PHONE_NUMBER
                || $inputworknumber == $getConsumerIDdetails->HOME_5_PHONE_NUMBER
            ) {
                $data['homematch'] = 'Matched';
            }

            if (strtoupper($data['Email']) == strtoupper($getConsumerIDdetails->X_EMAIL)) {
                $data['emailmatch'] = 'Matched';
            }
            if (strtoupper($data['FirstName']) == $getConsumerIDdetails->FIRSTNAME || strtoupper($data['FirstName']) == $getConsumerIDdetails->SECONDNAME || strtoupper($data['FirstName']) == $getConsumerIDdetails->FIRSTNAME . ' ' . $getConsumerIDdetails->SECONDNAME) {
                $data['idas_firstname_match'] = 'Matched';
            }
            if (strtoupper($data['SURNAME']) == $getConsumerIDdetails->SURNAME) {
                $data['idas_surname_match'] = 'Matched';
            }
            if (strtoupper($data['IDNUMBER']) == $getConsumerIDdetails->Identity_Document_ID) {
                $data['idas_idnumber_match'] = 'Matched';
            }
            if ($data['idas_firstname_match'] == 'Matched' && $data['idas_surname_match'] == 'Matched') {
                $data['fullnamesmatch'] = 'Matched';
            }

            
            
            //$getPhoto = DOVS::getConsumerID($request);
            $getPhoto = DOVS::where('FICA_id', '=', $getSearchFica['FICA_id'])->first();

            // exit;
            if ($getPhoto == null || $getPhoto->ConsumerIDPhoto == null) {
                DOVS::where('FICA_id', '=', $SearchFica)->update(
                    array(

                        'ConsumerIDPhoto' => NULL,

                    )
                );

                $ConsumerIDPhoto = base64_encode(file_get_contents(public_path('assets/images/nouser.png')));
            } else {
                $ConsumerIDPhoto = $getPhoto->ConsumerIDPhoto;
            }
            $ConsumerIDPhotos = [
                'IDPhoto' => $ConsumerIDPhoto,
            ];
           
            
            $compliancephoto = base64_encode(file_get_contents(public_path('assets/images/compliance.png')));
            $VerificationStaticPhoto = base64_encode(file_get_contents(public_path('assets/images/verification-static.png')));
            $PaymentPhoto = base64_encode(file_get_contents(public_path('assets/images/payment.png')));
            $Debtphoto = base64_encode(file_get_contents(public_path('assets/images/policy5.png')));
            $KYCPhoto = base64_encode(file_get_contents(public_path('assets/images/KYC.png')));
            $FacialPhoto = base64_encode(file_get_contents(public_path('assets/images/facial.png')));
            $tick = base64_encode(file_get_contents(public_path('assets/images/small/tick.png')));
            $question = base64_encode(file_get_contents(public_path('assets/images/question.png')));
            $cross = base64_encode(file_get_contents(public_path('assets/images/small/cross.png')));
            $xds = base64_encode(file_get_contents(public_path('assets/images/small/xds1.png')));
            
            $customer = Customer::getCustomerDetails($testing[$key]->Customerid);
            $Logo = $customer->Client_Logo;
            $font_colour = $customer->Client_Font_Code;

            $pdf = FacadePdf::loadView(
                'bulk-pdfs.sbextract',
                [
                    'data' => $data,
                    'debt_summary_data' => $debt_summary_data,
                    'compliance_data' => $ComplianceData,
                    'FetchComplianceSanct' => $FetchComplianceSanct,
                    'FetchComplianceAdd' => $FetchComplianceAdd,
                    'ConsumerIDPhotos' => $ConsumerIDPhotos,
                    'VerificationStaticPhoto' => $VerificationStaticPhoto,
                    'PaymentPhoto' => $PaymentPhoto,
                    'Debtphoto' => $Debtphoto,
                    'KYCPhoto' => $KYCPhoto,
                    'FacialPhoto' => $FacialPhoto,
                    'RiskStatusbyFICA' => $RiskStatusbyFICA,
                    'tick' => $tick,
                    'question' => $question,
                    'cross' => $cross,
                    'xds' => $xds,
                    'compliancephoto' => $compliancephoto,
                    'inputcellnumber' => $inputcellnumber,
                    'inputHomenumber' => $inputHomenumber,
                    'inputworknumber' => $inputworknumber,
                    'avs' => $avs,
                    'kyc' => $kyc,
                    'compliance' => $compliance,
                    'debt' => $debt,
                    'facial' => $facial,
                    'today' => $today->format('m/d/Y'),
                    'formattedDate' => $formattedDate,
                    'Logo' => $Logo,
                    'font_colour' => $font_colour

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
            
            $this->transferfile($pdf, $pdfilename, $key, $type = 'sb', $lastiteration, $data['Customerid']);
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

    public function transferfile($pdf, $filename, $index, $type, $lastiteration, $custID)
    {
        $customer = Customer::getCustomerDetails($custID);
        $Year = Carbon::now()->year;
        if (!empty($filename)) {
            //print_r('in'); exit;
            //$data = base64_decode($_POST['data']);
            //file_put_contents( public_path($_POST['name']), $data ); //this will store file into public folder of application

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

            /* $xlfilename = public_path('DueDeligencePDFs_' . $this->date1 . '.xlsx');
            $dd_res = [$index + 1, $filename];
            if (file_exists($xlfilename)) {
                $spreadsheet = IOFactory::Load($xlfilename);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
            } else {
                $spreadsheet = new Spreadsheet();
                $worksheet = $spreadsheet->getActiveSheet();
                $data = [
                    ['SL NUMBER', 'Filename']
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
            $writer->save($xlfilename); */

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
            } */
        } else {
            echo "No Data Sent";
        }
        //exit();
    }

}
