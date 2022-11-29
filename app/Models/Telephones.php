<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Telephones extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Telephones';
    public $timestamps = false;

    protected $fillable = [
        'ConsumerID',
        'TelephoneTypeInd',
        'InternationalDialingCode',
        'TelephoneCode',
        'TelephoneNo',
        'RecordStatusInd',
        'CreatedonDate',
        'ChangedonDate',
        'LastUpdatedDate'
    ];
    public function consumer()
    {
        return $this->belongsTo(\App\Models\Consumer::class);
    }

    /* Get loggedin users role name */
    public static function getAllTelephones()
    {
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $Telephone = Telephones::where('Consumerid', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $telephones = [];
        if ($Telephone) {
            foreach ($Telephone as $tele) {
                if ($tele['TelephoneTypeInd'] == 12) {
                    $telephones['TelCell'] = $tele->TelephoneCode . $tele->TelephoneNo;
                } else if ($tele['TelephoneTypeInd'] == 11) {
                    $telephones['TelHome'] = $tele->TelephoneCode . $tele->TelephoneNo;
                } else if ($tele['TelephoneTypeInd'] == 10) {
                    $telephones['TelWork'] = $tele->TelephoneCode . $tele->TelephoneNo;
                }
            }
        }
        return $telephones;
    }
}
