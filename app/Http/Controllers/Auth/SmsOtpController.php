<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsOtpController extends Controller
{
    protected $opt;
    protected $apiKey;
    protected $apiSecret;
    protected $authEndpoint;

    public function __construct()
    {
        //generate client OTP number
        $this->opt = rand(100000, 999999);
        $this->apiKey = config('app.API_OTP_KEY');
        $this->apiSecret = config('app.API_OTP_SECRET');
        $this->authEndpoint = config('app.API_OTP_AUTH_ENDPOINT');
    }

    public function sendOTP($phoneNumber)
    {
        /* $apiKey = config('app.API_OTP_KEY');
        $apiSecret = config('app.API_OTP_SECRET');
        $accountApiCredentials = $apiKey . ':' . $apiSecret;

        $base64Credentials = base64_encode($accountApiCredentials);
        $authHeader = 'Authorization: Basic ' . $base64Credentials;

        $authEndpoint = config('app.API_OTP_AUTH_ENDPOINT');
        //$phoneNumber = '0844675067';
        $authOptions = array(
            'http' => array(
                'header'  => $authHeader,
                'method'  => 'GET',
                'ignore_errors' => true
            )
        );
        $authContext  = stream_context_create($authOptions);

        $result = file_get_contents($authEndpoint, false, $authContext);

        $authResult = json_decode($result);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status === '200') {
            $authToken = $authResult->{'token'};

            var_dump($authResult);
        } else {
            var_dump($authResult);
        } */

        $authToken = $this->getToken();

        $sendUrl = config("app.API_OTP_SEND_URL");
        $authHeader = 'Authorization: Bearer ' . $authToken;
        $sendData = "{ 'messages' : [ { 'content' : 'Your FICA OTP verification code is: $this->opt', 'destination' : '$phoneNumber' } ] }";

        $options = array(
            'http' => array(
                'header'  => array("Content-Type: application/json", $authHeader),
                'method'  => 'POST',
                'content' => $sendData,
                'ignore_errors' => true
            )
        );
        $context  = stream_context_create($options);

        $sendResult = file_get_contents($sendUrl, false, $context);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status === '200') {
            var_dump($sendResult);
        } else {
            var_dump($sendResult);
        }
        return $this->opt;
    }


    
    public function sendselfServicelink($phoneNumber, $linkgenerated){
       
        $authToken = $this->getToken();

        $sendUrl = config("app.API_OTP_SEND_URL");
        $authHeader = 'Authorization: Bearer ' . $authToken;
        $sendData = "{ 'messages' : [ { 'content' : 'Please click the link below to start your self service: $linkgenerated', 'destination' : '$phoneNumber' } ] }";

        $options = array(
            'http' => array(
                'header'  => array("Content-Type: application/json", $authHeader),
                'method'  => 'POST',
                'content' => $sendData,
                'ignore_errors' => true
            )
        );
        $context  = stream_context_create($options);

        $sendResult = file_get_contents($sendUrl, false, $context);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status === '200') {
            var_dump($sendResult);
        } else {
            var_dump($sendResult);
        }
        return true;
    }


    public function getToken(){
        
        $accountApiCredentials = $this->apiKey . ':' . $this->apiSecret;

        $base64Credentials = base64_encode($accountApiCredentials);
        $authHeader = 'Authorization: Basic ' . $base64Credentials;

        $authOptions = array(
            'http' => array(
                'header'  => $authHeader,
                'method'  => 'GET',
                'ignore_errors' => true
            )
        );
        $authContext  = stream_context_create($authOptions);

        $result = file_get_contents($this->authEndpoint, false, $authContext);

        $authResult = json_decode($result);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status === '200') {
            $authToken = $authResult->{'token'};

            var_dump($authResult);
            return $authToken;
        } else {
            var_dump($authResult);
            return false;
        }
    }

    /* function to send sms for self banking functionlaity */
    public function sbSMS($phonenumber, $message)
    {
        $phonenumber = '0723865361';
        $apiKey = config("app.SB_SMS_APIKEY");
        $apiSecret = config("app.SB_SMS_APISECRET");
        $sbsmsurl = config("app.SB_SMS_URL");
        $accountApiCredentials = $apiKey . ':' . $apiSecret;

        $base64Credentials = base64_encode($accountApiCredentials);
        $authHeader = 'Authorization: Basic ' . $base64Credentials;

        $sendData = '{ "messages" : [ { "content" : "'.$message.'", "destination" : "'.$phonenumber.'" } ] }';

        $options = array(
            'http' => array(
                'header' => array("Content-Type: application/json", $authHeader),
                'method' => 'POST',
                'content' => $sendData,
                'ignore_errors' => true
            )
        );

        $sendResult = file_get_contents($sbsmsurl, false, stream_context_create($options));

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        if ($status === '200') {
            echo "Success:\n";
            var_dump($sendResult);
        } else {
            echo "Failure:\n";
            var_dump($sendResult);
        }
        exit;
        return true;
    }
}
