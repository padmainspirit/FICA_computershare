<?php

namespace App\Http\Controllers;

use App\Jobs\SBExtract;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingLink;
use DateTime;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Throwable;

class BulkExtractioncontroller extends Controller
{
    protected $date1;
    protected $date2;
    protected $disk;

    public function __construct()
    {
        $this->date1 = date("Y-m-d"); //"2024-08-15"; //date("Y-m-d");
        $this->date2 = date("dmY"); //"15082024"; //date("dmY");
        $this->disk = 'public'; //'sftp';
    }

    public function generateSelfBankingPDF()
    {
        $csids = config("app.COMPUTERSHARE_CUSTOMER_IDS");
        //get today's date
        $today = new DateTime($this->date1);

        //supply Compliance lite table id
        $selfbankingdetails_ids =  DB::connection('sqlsrv2')->table('TBL_Consumer_SelfBankingDetails as sd')
        ->join(config('app.DB_DATABASE').'.dbo.SelfBankingLink as sl','sl.Id','=','sd.SelfBankingLinkId')
        ->whereDate('CreatedOnDate', $today)
        ->get()
        ->pluck('SelfBankingDetailsId')
        ->toArray();



        if (empty($selfbankingdetails_ids)) {
            return false;
        }

        $jobs=[];
        $chunk_size = 5;
        $idsarray = array_chunk($selfbankingdetails_ids,$chunk_size);
        foreach ($idsarray as $key => $value) {
            //print_r($value);exit;
            $jobs[] = new SBExtract($key, $value, count($selfbankingdetails_ids), $chunk_size);
        }

        $batch = Bus::batch($jobs)->then(function (Batch $batch) {
            // All jobs completed successfully...
            print_r('Batch ' . $batch->id . ' finished successfully!');
            })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            print_r('Batch ' . $batch->id . ' did not finish successfully!');
            })->finally(function (Batch $batch) {
            // The batch has finished executing...
            print_r('Cleaning leftovers from batch ' . $batch->id);
            })->onQueue('sbextract')->name('sbextract')->allowFailures()->dispatch();
        print_r($batch->id);exit;
    }
}
