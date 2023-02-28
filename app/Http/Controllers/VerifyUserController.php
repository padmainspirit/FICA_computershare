<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerifyUserController extends Controller
{
    public function __construct()
    {
        // $this->username = config("app.VERIFICATION_USER_NAME");
        // $this->pass = config("app.VERIFICATION_USER_PASSWORD");
        // $this->url = config("app.VERIFICATION_USER_URL");
        // $this->apiSearch = config("app.VERIFICATION_USER_API_URL");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function verifyUser($id, Request $request)
    {
        try {
            $idasuser_data = array();
            $idasuser_api_data = array();

            $username = config("app.VERIFICATION_USER_NAME");
            $pass = config("app.VERIFICATION_USER_PASSWORD");
            $url = config("app.VERIFICATION_USER_URL");
            $apiSearch = config("app.VERIFICATION_USER_API_URL");
            $data = array(
                'username' => $username,
                'password' => $pass,
                'grant_type' => 'password',
            );

            $arrContextOptions = array(
                'http' => array(
                    'header'  => 'Content-Type: application/x-www-form-urlencoded\r\n',
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                )
            );
            $userid_no = $id;

            // app('debugbar')->info($id_no);
            $context  = stream_context_create($arrContextOptions);

            $result = file_get_contents($url, false, $context);

            $resultJsonFormat = json_decode($result);
            $apiUrl = $apiSearch . $userid_no . '&username=' . $username . '&password=' . $pass;
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt($ch, CURLOPT_URL,  $apiUrl);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $headers = [];
            $headers[] = 'Content-Type:application/json';
            $token = $resultJsonFormat->access_token;
            $headers[] = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);;
            curl_close($ch);
            $rawData = strtok($response, '[');
            $jsonData = strtok('');
            $jsonDataMod = str_replace('\\', '', $jsonData);
            $jsonDataMod2 = str_replace('{', '', $jsonDataMod);
            $jsonDataMod3 = str_replace('"', '', $jsonDataMod2);
            $result =   substr(rtrim($jsonDataMod3, ']'), 0, -3);
            //here we removing the last 2 character
            $idasuser_data = explode(",", $result);

         


            for ($i = 0; $i < count($idasuser_data); $i++) {
                $idasuser_api_data[$i] = $this->removeEverythingBeforeData($idasuser_data[$i], ':');
            }


            // dd($idas_api_data);

            return  $idasuser_api_data;

            // dd($idas_api_data[5]);

        } catch (\Exception $e) {
            //  return  0;
            app('debugbar')->info($e);
        }
    }


    //Removing characters
    function removeEverythingBeforeData($in, $before)
    {
        $pos = strpos($in, $before);
        return $pos !== FALSE
            ? substr($in, $pos + strlen($before), strlen($in))
            : "";
    }

    function idasUserArrayLength($length)
    {
        return $length;
    }
    
}
