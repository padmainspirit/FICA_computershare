<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'Companies';
    public $timestamps = true;
    
    const CREATED_AT = 'Created_At';
    const UPDATED_AT = 'Updated_At';
    protected $primaryKey = 'Id';

    protected $casts = [
        'Id' => 'string'
    ];

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Id',
        'Company_Name',
        'Created_At',
        'Updated_At'
    ];
}
