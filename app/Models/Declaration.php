<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Declaration extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Declaration';
    public $timestamps = false;

    protected $fillable = [
        'Declaration_ID',
        'FICA_ID',
        'ConsumerID',
        'ClientDueDiligence',
        'NomineeDeclaration',
        'IssuerCommunication',
        'CustodyService',
        'SegregatedDeposit',
        'DividendTax',
        'BeeShareholder',
        'StampDuty',
        'StockBrokerName',
        'StockBrokerContact',
    ];
    public function fica()
    {
        return $this->belongsTo(\App\Models\FICA::class);
    }
    public static function getFicaId(Request $request)
    {
        $getSearchConsumerID = Consumer::getConsumerId($request);
        $SearchConsumerID = $getSearchConsumerID['Consumerid']; 
        $getSearchFica = Declaration::where('ConsumerID', '=', $SearchConsumerID)->first();
        // $SearchFica = $getSearchFica['FICA_ID'];

        return $getSearchFica;
    }
}
