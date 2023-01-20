<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use Illuminate\Http\Request;
use App\Models\ConsumerIdentity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SebastianBergmann\Type\NullType;
use  Webpatser\Uuid\Uuid;



class VerificationDataController extends Controller
{

    public function __construct()
    {
        // $this->username = config("app.VERIFICATION_USER_NAME");
        // $this->pass = config("app.VERIFICATION_USER_PASSWORD");
        // $this->url = config("app.VERIFICATION_USER_URL");
        // $this->apiSearch = config("app.VERIFICATION_USER_API_URL");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function verifyClientData($IDNum, Request $request)
    {
        // $user = Auth::user();
        // $client = User::find($request->clientId);
        try {
            $idas_data = array();
            $idas_address = array();
            $idas_api_data = array();

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
            $id_no = $IDNum;

            app('debugbar')->info($id_no);
            $context  = stream_context_create($arrContextOptions);

            $result = file_get_contents($url, false, $context);

            $resultJsonFormat = json_decode($result);
            $apiUrl = $apiSearch . $id_no . '&username=' . $username . '&password=' . $pass;
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
            $idas_data = explode(",", $result);

          


            for ($i = 0; $i < count($idas_data); $i++) {
                $idas_api_data[$i] = $this->removeEverythingBefore($idas_data[$i], ':');
            }


            // dd($idas_api_data);
            // $len = $this->idasArrayLength(count($idas_data));

            // app('debugbar')->info($len);
            // dd($idas_api_data);
            //saving data to the TBL_Consumer_IDENTITY table
            // if ($len > 0) {
            $client = Auth::user()->Id;
            $consumer = Consumer::where('CustomerUSERID', '=',  $client)->first();

            //app('debugbar')->info($consumer);

            if ($consumer != null) {
                ConsumerIdentity::where('Identity_Document_ID', $consumer->IDNUMBER)->update(
                    array(
                        'CreatedonDate' => date("Y-m-d H:i:s"),
                        'Identity_status' => 1,
                        'DOB' => $idas_api_data[1],
                        'TITLE' => $idas_api_data[2],
                        'INITIALS' => $idas_api_data[3],
                        'FIRSTNAME' => $idas_api_data[4],
                        'SURNAME' => $idas_api_data[5],
                        'SECONDNAME' => $idas_api_data[6],
                        'OTHER_NAMES' => $idas_api_data[7],
                        'SPOUSE_NAME' => $idas_api_data[8],
                        'SPOUSE_SURNAME' => $idas_api_data[9],
                        'PROFILE_GENDER' => $idas_api_data[10],
                        'PROFILE_AGE_GROUP' => $idas_api_data[11],
                        'PROFILE_MARITAL_STATUS' => $idas_api_data[12],
                        'LSM' => $idas_api_data[13],
                        'PROFILE_CONTACT_ABILITY' => $idas_api_data[14],
                        'INCOME' => $idas_api_data[15],
                        'PROFILE_HOMEOWNERSHIP' => $idas_api_data[16],
                        'NUM_PROPERTIES' => $idas_api_data[17],
                        'PROPERTYVALUE' => $idas_api_data[18],
                        'PROFILE_DIRECTORSHIP' => $idas_api_data[19],
                        'NUM_DIRECTORSHIPS' => $idas_api_data[20],
                        'ADVERSE_INDICATOR' => $idas_api_data[21],
                        'DECEASED_IND' => $idas_api_data[22],
                        'DATEOFDEATH' => $idas_api_data[24],
                        'PLACEOFDEATH' => $idas_api_data[23],
                        'OCCUPATION' => $idas_api_data[25],
                        'X_EMPLOYMENT_1' => $idas_api_data[26],
                        'EMPLOYMENT_1_DATE' => $idas_api_data[27],
                        'X_EMPLOYMENT_2' => $idas_api_data[28],
                        'EMPLOYMENT_2_DATE' => $idas_api_data[29],
                        'X_EMPLOYMENT_3' => $idas_api_data[30],
                        'EMPLOYMENT_3_DATE' =>  $idas_api_data[31],
                        'X_EMPLOYMENT_4' => $idas_api_data[32],
                        'EMPLOYMENT_4_DATE' =>  $idas_api_data[33],
                        'X_EMPLOYMENT_5' => $idas_api_data[34],
                        'EMPLOYMENT_5_DATE' =>  $idas_api_data[35],
                        'X_EMAIL' => $idas_api_data[36],
                        'HOME_ADDRESS1_LINE_1' => $idas_api_data[37],
                        'HOME_ADDRESS1_LINE_2' => $idas_api_data[38],
                        'HOME_ADDRESS1_TOWNSHIP' => $idas_api_data[39],
                        'HOME_ADDRESS1_REGION' => $idas_api_data[40],
                        'HOME_ADDRESS1_PROVINCE' => $idas_api_data[41],
                        'HOME_ADDRESS1_POSTAL_CODE' => $idas_api_data[42],
                        'HOME_ADDRESS1_DATE' =>  $idas_api_data[43],
                        'HOME_ADDRESS2_LINE_1' => $idas_api_data[44],
                        'HOME_ADDRESS2_LINE_2' => $idas_api_data[45],
                        'HOME_ADDRESS2_TOWNSHIP' => $idas_api_data[46],
                        'HOME_ADDRESS2_REGION' => $idas_api_data[47],
                        'HOME_ADDRESS2_PROVINCE' => $idas_api_data[48],
                        'HOME_ADDRESS2_POSTAL_CODE' => $idas_api_data[49],
                        'HOME_ADDRESS2_DATE' => $idas_api_data[50],
                        'HOME_ADDRESS3_LINE_1' => $idas_api_data[51],
                        'HOME_ADDRESS3_LINE_2' => $idas_api_data[52],
                        'HOME_ADDRESS3_TOWNSHIP' => $idas_api_data[53],
                        'HOME_ADDRESS3_REGION' => $idas_api_data[54],
                        'HOME_ADDRESS3_PROVINCE' => $idas_api_data[55],
                        'HOME_ADDRESS3_POSTAL_CODE' => $idas_api_data[56],
                        'HOME_ADDRESS3_DATE' => $idas_api_data[57],
                        'POSTAL_ADDRESS1_LINE_1' => $idas_api_data[58],
                        'POSTAL_ADDRESS1_LINE_2' => $idas_api_data[59],
                        'POSTAL_ADDRESS1_TOWNSHIP' => $idas_api_data[60],
                        'POSTAL_ADDRESS1_REGION' => $idas_api_data[61],
                        'POSTAL_ADDRESS1_PROVINCE' => $idas_api_data[62],
                        'POSTAL_ADDRESS1_POSTAL_CODE' => $idas_api_data[63],
                        'POSTAL_ADDRESS1_DATE' =>  $idas_api_data[43],
                        'POSTAL_ADDRESS2_LINE_1' => $idas_api_data[65],
                        'POSTAL_ADDRESS2_LINE_2' => $idas_api_data[66],
                        'POSTAL_ADDRESS2_TOWNSHIP' => $idas_api_data[67],
                        'POSTAL_ADDRESS2_REGION' => $idas_api_data[68],
                        'POSTAL_ADDRESS2_PROVINCE' => $idas_api_data[69],
                        'POSTAL_ADDRESS2_POSTAL_CODE' => $idas_api_data[70],
                        'POSTAL_ADDRESS2_DATE' => $idas_api_data[71],
                        'POSTAL_ADDRESS3_LINE_1' => $idas_api_data[72],
                        'POSTAL_ADDRESS3_LINE_2' => $idas_api_data[73],
                        'POSTAL_ADDRESS3_TOWNSHIP' => $idas_api_data[74],
                        'POSTAL_ADDRESS3_REGION' => $idas_api_data[75],
                        'POSTAL_ADDRESS3_PROVINCE' => $idas_api_data[76],
                        'POSTAL_ADDRESS3_POSTAL_CODE' => $idas_api_data[77],
                        'POSTAL_ADDRESS3_DATE' => $idas_api_data[78],
                        'HOME_1_PHONE_NUMBER' => $idas_api_data[79],
                        'HOME_1_DATE' =>  $idas_api_data[80],
                        'WORK_1_PHONE_NUMBER' => $idas_api_data[81],
                        'WORK_1_DATE' =>  $idas_api_data[82],
                        'CELL_1_PHONE_NUMBER' => $idas_api_data[83],
                        'CELL_1_DATE' =>  $idas_api_data[84],
                        'HOME_2_PHONE_NUMBER' => $idas_api_data[85],
                        'HOME_2_DATE' =>  $idas_api_data[86],
                        'WORK_2_PHONE_NUMBER' => $idas_api_data[87],
                        'WORK_2_DATE' =>  $idas_api_data[88],
                        'CELL_2_PHONE_NUMBER' => $idas_api_data[89],
                        'CELL_2_DATE' =>  $idas_api_data[90],
                        'HOME_3_PHONE_NUMBER' => $idas_api_data[91],
                        'HOME_3_DATE' => $idas_api_data[92],
                        'WORK_3_PHONE_NUMBER' => $idas_api_data[93],
                        'WORK_3_DATE' =>  $idas_api_data[94],
                        'CELL_3_PHONE_NUMBER' => $idas_api_data[95],
                        'CELL_3_DATE' =>  $idas_api_data[96],
                        'HOME_4_PHONE_NUMBER' => $idas_api_data[97],
                        'HOME_4_DATE' =>  $idas_api_data[98],
                        'WORK_4_PHONE_NUMBER' => $idas_api_data[99],
                        'WORK_4_DATE' =>  $idas_api_data[100],
                        'CELL_4_PHONE_NUMBER' => $idas_api_data[101],
                        'CELL_4_DATE' =>   $idas_api_data[102],
                        'HOME_5_PHONE_NUMBER' => $idas_api_data[103],
                        'HOME_5_DATE' =>   $idas_api_data[104],
                        'WORK_5_PHONE_NUMBER' => $idas_api_data[105],
                        'WORK_5_DATE' => $idas_api_data[106],
                        'CELL_5_PHONE_NUMBER' => $idas_api_data[107],
                        'CELL_5_DATE' =>  $idas_api_data[108],
                    )
                );
            }

            // dd($idas_api_data[0]);
            return  $idas_api_data[0];
        } catch (\Exception $e) {
            //  return  0;
            app('debugbar')->info($e);
        }
    }

    //Removing characters
    function removeEverythingBefore($in, $before)
    {
        $pos = strpos($in, $before);
        return $pos !== FALSE
            ? substr($in, $pos + strlen($before), strlen($in))
            : "";
    }

    function idasArrayLength($length)
    {
        return $length;
    }
}
