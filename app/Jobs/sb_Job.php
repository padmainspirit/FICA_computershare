<?php

namespace App\Jobs;

use App\Models\Consumer;
use App\Models\ConsumerIdentity;
use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\DebtSummary;
use App\Models\DOVS;
use App\Models\FICA;
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

class DDJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date1;
    protected $date2;
    protected $disk;
    protected $compliteids;
    protected $keyofchunks;
    protected $totalcount;
    protected $chunk_size;

    public function __construct($key, $compliteids, $totalcount, $chunk_size)
    {
        $this->date1 = date("Y-m-d"); //date("Y-m-d");//"2024-07-02"
        $this->date2 = date("dmY"); //date("dmY"); //"02072024"
        $this->disk = 'sftp'; //'sftp';
        $this->compliteids = $compliteids;
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
        echo 'handle function of DD job';

        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        $csids = config("app.COMPUTERSHARE_CUSTOMER_IDS");
        $csid_list = implode(',', $csids);
        $compliteidlist_list = implode(',', $this->compliteids);
        $today = new DateTime($this->date1);

        $batchId = $this->batch()->id;
        $testing  = Consumer::getSPDetailsComplianceAll($today, $csid_list, $compliteidlist_list);

        if (empty($testing)) {
            return false;
        }


        $UserFullName = $client->FirstName . ' ' . $client->LastName;

        $reason = $request->reason;
        $status = $request->avsStatus;

        $getCustomerId = $id;
        $selfbankingdetails = SelfBankingDetails::where('SelfBankingDetailsId', '=',  $getCustomerId)->first();
        $selfbankinglink = SelfBankingLink::where('Id', '=',  $selfbankingdetails->SelfBankingLinkId)->first();

       //print_r($selfbankingdetails);exit;
        $sbdetails = SelfBankingDetails::where(['SelfBankingDetailsId' => $getCustomerId])
        ->join('TBL_FICA', 'TBL_FICA.Consumerid', '=', 'TBL_Consumer_SelfBankingDetails.SelfBankingDetailsId')
        ->first();

         $exceptions = SelfBankingExceptions::where('SelfBankingLinkId', '=', $selfbankingdetails->SelfBankingLinkId)->get();

         $avs = AVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $dovs = DOVS::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $consumerIdentity  = ConsumerIdentity::where('FICA_id', '=',  $sbdetails->FICA_id)->first();
         $fica =  FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->first();
         $SbActions =  SbActions::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();
         $SelfBankingCompanySRN =  SelfBankingCompanySRN::where('SelfBankingdetailsId', $selfbankingdetails->SelfBankingDetailsId)->get();



        // print_r($SelfBankingCompanySRN);exit;
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
         if($selfbankingdetails->PhoneNumber ==$cell1 || $selfbankingdetails->PhoneNumber ==$cell2 ||
         $selfbankingdetails->PhoneNumber ==$cell3 || $selfbankingdetails->PhoneNumber ==$cell4|| $selfbankingdetails->PhoneNumber ==$cell5)
         {
            $cellmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->Email) == strtolower($consumerIdentity->X_EMAIL) )
         {
            $emailmatch = 'Matched';
         }
         if(strtolower($selfbankingdetails->FirstName) == strtolower($consumerIdentity->FIRSTNAME) )
         {
            $namematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->SecondName) == strtolower($consumerIdentity->SECONDNAME) )
         {
            $secnamematch = 'Matched';
         }
         if(strtolower($selfbankingdetails->ThirdName) == strtolower($consumerIdentity->OTHER_NAMES) )
         {
            $thirdnamematch = 'Matched';
         }


         if(strtolower($selfbankingdetails->Surname) == strtolower($consumerIdentity->SURNAME) )
         {
            $smatch = 'Matched';
         }
//print_r($sbdetails);exit;
         if(!empty($_POST))
         {
            FICA::where('Consumerid', $selfbankingdetails->SelfBankingDetailsId)->update(
                array(
                    'LastUpdatedDate' => date("Y-m-d H:i:s"),
                    'FICAStatus' =>  $status,
                )
            );


                SbActions::create([
                    'ActionId' => Str::upper(Str::uuid()),
                    'AdminID' => $client->Id,
                    'SelfBankingdetailsId' =>  $selfbankingdetails->SelfBankingDetailsId,
                    'CreatedAt' => date("Y-m-d H:i:s"),
                    'ActionFrom' => $fica->FICAStatus,
                    'ActionTo' => $status,
                    'Comment' => $reason,
                    'Admin_User' => $UserFullName
                ]);

            $pdf = FacadePdf::loadView(
                'bulk-pdfs.bulkddpdf',
                [
                    'customer' => $customer,
                    'avs' => $avs,
                    'dovs' => $dovs,
                    'UserFullName' => $UserFullName,
                    'customerName' =>$customer->RegistrationName,
                    'sbdetails' => $sbdetails,
                    'Icon' => $customer->Client_Icon,
                    'message' => $message,
                    'SelfBankingCompanySRN' => $SelfBankingCompanySRN,
                    'exceptions' => $exceptions,
                    'Logo' => $customer->Client_Logo,
                    'LogUserName' => $client->FirstName,
                    'cellmatch' => $cellmatch,
                    'emailmatch' => $emailmatch,
                    'thirdnamematch' => $thirdnamematch,
                    'secnamematch' => $secnamematch,
                    'FICAStatus' => $fica->FICAStatus,
                    'namematch' => $namematch,
                    'SbActions' => $SbActions,
                    'smatch' => $smatch,
                    'ha_name' => $consumerIdentity->FIRSTNAME,
                    'ha_secondname' => $consumerIdentity->SECONDNAME,
                    'selfbankinglink' => $selfbankinglink,
                    'iddoc' => $consumerIdentity->Identity_File_Path,
                    'ha_surname' => $consumerIdentity->SURNAME,
                    'LogUserSurname' => $client->LastName


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

            $content = $row . ",CSS-LNK," . $data['Client_Ref'] . "," . $row . "_" . $data['Client_Ref'] . "_iFICADOCS.pdf,Account_Confirmation_Details," . $dateformate . ",FICA," . $dateformate . "\n";


            $filedata = $filedata . $content;

            $pdfilename =  $row . "_" . $data['Client_Ref'] . "_iFICADOCS.pdf";
            //$pdf->save($pdfilename, 'public');
            $lastiteration = $count == $this->totalcount ? 1 : 0;

            $this->transferfile($pdf, $pdfilename, $key, $type = 'dd', $lastiteration, $data['Customerid']);
        }

        $fileName = 'Contact Centre Due Diligence/Extraction_' . $this->date2 . '/' . 'index.txt';

        if (Storage::disk($this->disk)->exists($fileName)) {
            // Append the content to the existing file
            Storage::disk($this->disk)->append($fileName, $filedata);
        }else{
            // Write the content to a file
            Storage::disk($this->disk)->put($fileName, $filedata);
        }
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

            $foldername = $type == 'dovs' ? 'Contact Centre Facial Recognition' : 'Contact Centre Due Diligence';
            $mailsubject = $type == 'dovs' ? 'Facial Recognition PDFs - ' . $this->date1 : 'Due Diligence PDFs - ' . $this->date1;

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
