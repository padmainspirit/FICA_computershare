<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
