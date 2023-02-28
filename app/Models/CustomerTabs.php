<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerTabs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'CustomerTabs';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'slug',
        'name',
    ];

    public static function checkTabPermission($customerId)
    {        
        $customerTabs = DB::table("customer_has_tabs")->where("customer_has_tabs.CustomerId", $customerId)
        ->pluck('customer_has_tabs.TabId', 'customer_has_tabs.TabId')
        ->all();
        $slug = DB::table("CustomerTabs")->whereIn('Id',$customerTabs)
        ->pluck('CustomerTabs.slug')
        ->all();
        return $slug;
    }

}
