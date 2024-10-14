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

    protected $DIA_UAT;
    protected $DIA_LIVE;
    protected $DIA_USERNAME;
    protected $DIA_PASSWORD;
    PROTECTED $DIA_INSTNAME;

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

        $this->DIA_UAT = config("app.DIA_UAT");
        $this->DIA_LIVE = config("app.DIA_LIVE");
        $this->DIA_USERNAME = config("app.DIA_USERNAME");
        $this->DIA_PASSWORD = config("app.DIA_PASSWORD");
        $this->DIA_INSTNAME = config("app.DIA_INSTNAME");
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

    public function parseSoapXmlDia($xml){
		if(str_contains($xml,'cURL Error')){
            $data['Body'] = array("Fault" => $xml);
            $json = json_encode($data);
        }else{
            $response = strtr($xml, ['</s:' => '</', '<s:' => '<']);
            $response1 = strtr($response, ['</a:' => '</', '<a:' => '<']);
            $simple_xml = simplexml_load_string($response1);
            $json = json_encode($simple_xml);
        }
        
        return json_decode($json,true);
	}

    /* function request an OTL using DIA API */
    public function requestOTL($idnumber)
    {
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:fac="http://schemas.datacontract.org/2004/07/FaceService">
                                <soapenv:Header/>
                                    <soapenv:Body>
                                        <tem:RequestOTL>
                                            <tem:Request>
                                                <fac:ClientUniqueNumber>'.$idnumber.'</fac:ClientUniqueNumber>
                                                <fac:InstName>'.$this->DIA_INSTNAME.'</fac:InstName>
                                                <fac:OTLtype>2</fac:OTLtype>
                                                <fac:SaIdNo>true</fac:SaIdNo>
                                                <fac:UserName>'.$this->DIA_USERNAME.'</fac:UserName>
                                                <fac:UserPassword>'.$this->DIA_PASSWORD.'</fac:UserPassword>
                                            </tem:Request>
                                        </tem:RequestOTL>
                                    </soapenv:Body>
                                </soapenv:Envelope>';   // data from the form, e.g. some ID number

        $headers = array(
            "POST /DiaFace/FaceService HTTP/1.1",
            //"Host: www.web.xds.co.za",
            'Content-type: text/xml; charset=utf-8',
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            //"Authorization: Basic Y3pzX3dzOjFDb24xJEFkbSE=",
            "SOAPAction: http://tempuri.org/IFaceService/RequestOTL",
        ); //SOAPAction: your op URL

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->DIA_LIVE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERPWD => $this->DIA_USERNAME . ":" . $this->DIA_PASSWORD,
            CURLOPT_POSTFIELDS => $xml_post_string,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_SSL_VERIFYPEER => 1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) { 
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

    } 

}
