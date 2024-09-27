<?php

namespace App\Http\Controllers;

use App\Models\FICA;
use App\Models\SelfBankingLink;
use App\Models\SelfBankingDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    /* Below function updates all the records of the fica table 
    which are related to the self banking flow with 
    'In progress' status and is created before 24 hours
    to 'expired' status*/
    public function checksbLInks()
    {
        $current_date_time = Carbon::now('Africa/Johannesburg');
        $minus_24_hours = $current_date_time->subHour(24);
        //$selfbankinglinkdetails = SelfBankingLink::select('Id')->with(['selfBankingDetails:SelfBankingDetailsId,SelfBankingLinkId'])->where("CreatedAt", "<", $minus_24_hours)->get();
        $selfbankinglinkdetails = SelfBankingDetails::select('SelfBankingLinkId','SelfBankingDetailsId')->where("CreatedOnDate", "<", $minus_24_hours)->get();
        $SelfBankingDetailsIdArray = [];
     
        foreach ($selfbankinglinkdetails as $key => $value) {
            if(!empty($value['SelfBankingDetailsId'])){
            $SelfBankingDetailsIdArray[]=$value['SelfBankingDetailsId'];
            }
        }

        
        FICA::where(['FICAStatus'=> "In progress", 'ConsumerReferance' =>4])
            ->whereIn("Consumerid", $SelfBankingDetailsIdArray)
            ->update(["FICAStatus" => "Expired",'LastUpdatedDate' => date("Y-m-d H:i:s")]);

        return "updated all the records";
    }

     /* Function to get the DIA OTL response */
     public function getDiaResponse()
     {
         
     }
}
