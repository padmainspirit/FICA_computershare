<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminSelfServiceBankingApiController extends Controller
{
    protected $xdsusername;
    protected $xdspassword;

    //API ID
    protected $KYC; //KYC
    protected $AVS; //AVS
    protected $DOVS; //DOVS
    protected $COMPLIANCE; //COMPLIANCE

    //
    protected $Flat_API; //COMPLIANCE
    //
    protected $soapUrlLive;
    protected $soapUrlDemo;

    // $kycLookup = LookupDatas::where('ID', '=', $this->KYC)->first();
    // $avsLookup = LookupDatas::where('ID', '=', $this->AVS)->first();
    // $dovsLookup = LookupDatas::where('ID', '=', $this->DOVS)->first();
    // $complyLookup = LookupDatas::where('ID', '=', $this->COMPLIANCE)->first();

    public function __construct()
    {
        $this->xdsusername = config("app.API_LOGIN_USERNAME");
        $this->xdspassword = config("app.API_LOGIN_PASSWORD");

        $this->KYC = config("app.API_ID_KYC");
        $this->AVS = config("app.API_ID_AVS");
        $this->DOVS = config("app.API_ID_DOVS");
        $this->COMPLIANCE = config("app.API_ID_COMPLIANCE");

        $this->soapUrlLive = config("app.API_SOAP_URL_LIVE_XDS_SELFIE_RESULT");
        $this->soapUrlDemo = config("app.API_SOAP_URL_DEMO_XDS_SELFIE_RESULT");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /* Common function to connect to xds and get a ticket */
    public function connectandgetNewTicket()
    {
        $soapUrlLive = $this->soapUrlLive; //here we are changing the url to the demo/dev/testing environment
        $username = $this->xdsusername; // Demo username

        $password = $this->xdspassword;

        $userVerification = new UserVerificationController();

        $returnValue = $userVerification->soapLoginAPICall($soapUrlLive, $username, $password);

        $tempData = explode('>', $returnValue);

        //app('debugbar')->info($tempData);
        if (isset($tempData[5])) {
            $tempData2 = explode('<', $tempData[5]);
            $ticketNo = $tempData2[0];

            $returnValue = $userVerification->soapValidateTicketNo($soapUrlLive, $username, $password, $ticketNo);

            $tempData = explode('>', $returnValue);
            $tempData2 = explode('<', $tempData[5]);
            $valid = $tempData2[0];

            if ($valid  == "true") {
                Session::put('xdsTicket', $ticketNo);
                return $ticketNo;
            } else {
                print_r('invalid ticket'); //exit;
                return 'Failure';
            }
        } else {
            print_r('invalid credentials'); //exit;
            return 'Failure';

        }
    }

     /* Parse SOAP XML response to Array Conversion */
	public function parseSoapXml($xml){
		if(str_contains($xml,'cURL Error')){
            $data['Body'] = array("Fault" => $xml);
            $json = json_encode($data);
        }else{
            $response = strtr($xml, ['</soap:' => '</', '<soap:' => '<']);
            $simple_xml = simplexml_load_string($response);
            $json = json_encode($simple_xml);
        }
        
        return json_decode($json,true);
	}

}
