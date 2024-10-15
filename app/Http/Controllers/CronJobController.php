<?php

namespace App\Http\Controllers;

use App\Models\APILogs;
use App\Models\ConsumerIdentity;
use App\Models\CustomerUser;
use App\Models\DOVS;
use App\Models\FICA;
use App\Models\SelfBankingDetails;
use App\Models\SelfBankingExceptions;
use App\Models\SelfBankingLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function getDiaResponse(Request $request)
    {
      Log::info('message');
      $xmlContent = $request->getContent();
    //Log::info($xmlContent);

      $data1 = json_decode($xmlContent);
      $diareference = $data1->DiaReference;
      $UniqueReference =  $data1->UniqueReference;
      $Hanisreference = $data1->Hanisreference;
      $Name = $data1->Name;
      $SurName = $data1->SurName;
      $DeceasedStatus = $data1->DeceasedStatus;
      $homeaffairsImage = $data1->HomeAffairsImage;
      $image = $data1->Image;
      $DatetimeChecked = $data1->DatetimeChecked;
      $RespMessage = $data1->RespMessage;
      $DeceasedDate = $data1->DeceasedDate;
      $IdCardInd = $data1->IdCardInd;
      $IdbookDate = $data1->IdbookDate;
      $IdcardDate = $data1->IdcardDate;
      $ResponseCode = $data1->ResponseCode;
      $status = $RespMessage == 'Matched' ? 'Completed' : 'Failed';
      DOVS::where(['EnquiryInput'=>$diareference, 'API_TYPE'=>2])->update([
            'LastUpdatedDate' => date("Y-m-d H:i:s"),
            'DeceasedStatus' => $DeceasedStatus,
            'ConsumerIDPhotoMatch' => $RespMessage,
            'MatchResponseCode' => $ResponseCode,
            'ConsumerIDPhoto' => $homeaffairsImage,
            'ConsumerCapturedPhoto' => $image,
            'DOVS_DIA_Response' => $xmlContent,
            'FirstName' => $Name,
            'Surname' => $SurName,
            'ReferenceNo'=> $UniqueReference,
            'SelfieStatus' => $status,
            'DOVS_DIA_Response'=>$xmlContent,
      ]);
      Log::info('Dovs response has been updated successfully');

    //$diareference = '31035262';
    $getfICA = DOVS::where(['EnquiryInput'=>$diareference, 'API_TYPE'=>2])->first();
    $fica_id = $getfICA->FICA_id;

    $getIdentity = ConsumerIdentity::where(['FICA_id'=>$fica_id])->first();

    DOVS::where(['FICA_id'=>$fica_id])->update([
        'LastUpdatedDate' => date("Y-m-d H:i:s"),
        'FirstName' => $getIdentity->FIRSTNAME,
        'SecondName'=> $getIdentity->SECONDNAME,
        'ThirdName'=> $getIdentity->OTHER_NAMES,
        'Surname'=> $getIdentity->SURNAME,
        'BirthDate'=> $getIdentity->DOB,
        'Gender'=> $getIdentity->PROFILE_GENDER,
        'TitleDesc'=> $getIdentity->TITLE,
        'maritalStatus'=> $getIdentity->PROFILE_MARITAL_STATUS,
        'HomeTelephoneNo'=> $getIdentity->HOME_1_PHONE_NUMBER,
        'WorkTelephoneNo'=> $getIdentity->WORK_1_PHONE_NUMBER,
        'CellularNo'=> $getIdentity->CELL_1_PHONE_NUMBER,
        'EmailAddress'=> $getIdentity->X_EMAIL,
        'EmployerDetail'=> $getIdentity->X_EMPLOYMENT_1,
        'ResidentialAddress1'=> $getIdentity->HOME_ADDRESS1_LINE_1,
        'ResidentialAddress2'=> $getIdentity->HOME_ADDRESS1_LINE_2,
        'ResidentialAddress3'=> $getIdentity->HOME_ADDRESS1_TOWNSHIP,
        'ResidentialAddress4'=> $getIdentity->HOME_ADDRESS1_REGION,
        'ResidentialPostalCode'=> $getIdentity->HOME_ADDRESS1_POSTAL_CODE,
        'PostalAddress1'=> $getIdentity->POSTAL_ADDRESS1_LINE_1,
        'PostalAddress2'=> $getIdentity->POSTAL_ADDRESS1_LINE_2,
        'PostalAddress3'=> $getIdentity->POSTAL_ADDRESS1_TOWNSHIP,
        'PostalAddress4'=> $getIdentity->POSTAL_ADDRESS1_REGION,
        'PostalPostalCode'=> $getIdentity->POSTAL_ADDRESS1_POSTAL_CODE,

    ]);


    $ficadetails = FICA::where(['FICA_id'=>$fica_id])->first();
    $sb_detailsid = $ficadetails->Consumerid;
    $selfbankingdetails = SelfBankingDetails::where('SelfBankingDetailsId', '=',  $sb_detailsid)->first();
    $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica'])->where('Id',$selfbankingdetails->SelfBankingLinkId)->first();
    $sbid = $selfbankingdetails->SelfBankingLinkId;

    if($homeaffairsImage == '' || $homeaffairsImage == null || $RespMessage == 'BadPose' || $RespMessage == 'BadSharpness')
    {
        $sbe = SelfBankingExceptions::create([
            'Id' => Str::upper(Str::uuid()),
            'SelfBankingLinkId' => $sbid,
            'API' => 4,
            'Status' => 'Validation Pending',
            'Comment' => $RespMessage
        ]);
        $sbe->save();

        SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>2]);

    }else if($RespMessage == 'Not Matched'){
        /* Process failed flow, terminate the execution */
        $sbe = SelfBankingExceptions::create([
            'Id' => Str::upper(Str::uuid()),
            'SelfBankingLinkId' => $sbid,
            'API' => 4,
            'Status' => 'Failed',
            'Comment' => 'Photo does not match'
        ]);
        $sbe->save();

        SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>-2]);

        FICA::where(['FICA_id' => $fica_id])->update(
            array(
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FICAStatus' =>  'Failed',
                'FailedDate' => date("Y-m-d H:i:s"),
                'FICAProgress' =>  '5.0',
            )
        );


    }else if($RespMessage == 'Matched'){
        SelfBankingLink::where('Id', '=',  $sbid)->update(['DOVS'=>1]);
        FICA::where(['FICA_id' => $fica_id])->update(
            array(
                'LastUpdatedDate' => date("Y-m-d H:i:s"),
                'FailedDate' => date("Y-m-d H:i:s"),
                'FICAProgress' =>  '5.0',
            )
        );
    }
    //API LOGS
    APILogs::create([
        'API_Log_Id' => Str::upper(Str::uuid()),
        'FICAId' => $fica_id,
        'ConsumerID' => $selfbankinglinkdetails->SelfBankingDetailsId,
        'CustomerID' =>  $selfbankinglinkdetails->CustomerId,
        'Createddate' => date("Y-m-d H:i:s"),
        'API_ID' => 7,
    ]);

      return response()->json(['message' => 'XML received successfully'], 200);
    }


    public function getDovsSelfieStatus(Request $request) {
        $sbid = $request->session()->get('sbid');
        $selfbankinglinkdetails = SelfBankingLink::with(['selfBankingDetails.fica','selfBankingDetails.bankAccountType','selfBankingDetails.SBCompanySRN'])->where('Id',$sbid)->first();

        $fica_id = $selfbankinglinkdetails->selfBankingDetails->fica->FICA_id;
        $ficaDetails = DOVS::where(['FICA_ID'=>$fica_id])->select('FICA_id','DOVS_id','ConsumerIDPhotoMatch','LastUpdatedDate')->first();
        return $ficaDetails;
    }
}
