<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Address extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Addresses';
    public $timestamps = false;
    protected $fillable = [
        'ConsumerID',
        'AddressTypeInd',
        'OriginalAddress1',
        'OriginalAddress2',
        'OriginalAddress3',
        'OriginalAddress4',
        'OriginalPostalCode',
        'OccupantTypeInd',
        'RecordStatusInd',
        'LastUpdatedDate',
        'CreatedOnDate',
        'Province',
    ];

    public function consumer()
    {
        return $this->belongsTo(\App\Models\Consumer::class);
    }

    public static function getAllAddresses()
    {
        $loggedInUserId = Auth::user()->Id;
        $consumer = Consumer::where('CustomerUSERID', '=',  $loggedInUserId)->first();
        $Addresses = Address::where('ConsumerID', '=',  $consumer->Consumerid)->where('RecordStatusInd', '=', 1)->get();
        $address = [];
        if ($Addresses) {
            $address['Home'] = null;
            $address['Postal'] = null;
            $address['Work'] = null;

            foreach ($Addresses as $add) {
                if ($add['AddressTypeInd'] == 16) {
                    $address['Home'] = $add;
                } else if ($add['AddressTypeInd'] == 15) {
                    $address['Postal'] = $add;
                } else if ($add['AddressTypeInd'] == 14) {
                    $address['Work'] = $add;
                }
            }
        }
        return $address;
    }

    public static function getAllAddressesAdmin($userconsumerid)
    {
        // $SearchConsumerID = $userconsumerid;
        // $consumer = Consumer::where('IDNUMBER', '=',  $loggedInUserId)->first();
        $Addresses = Address::where('ConsumerID', '=',  $userconsumerid->ConsumerID)->where('RecordStatusInd', '=', 1)->get();
        $address = [];
        if ($Addresses) {
            $address['Home'] = null;
            $address['Postal'] = null;
            $address['Work'] = null;

            foreach ($Addresses as $add) {
                if ($add['AddressTypeInd'] == 16) {
                    $address['Home'] = $add;
                } else if ($add['AddressTypeInd'] == 15) {
                    $address['Postal'] = $add;
                } else if ($add['AddressTypeInd'] == 14) {
                    $address['Work'] = $add;
                }
            }
        }
        return $address;
    }
}
