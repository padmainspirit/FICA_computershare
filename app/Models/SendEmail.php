<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendEmail extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TBL_Consumer_Emails';
    public $timestamps = false;

    protected $fillable = [

      'EmailID',
      'Consumerid',
      'Consumer_Firstname',
      'Consumer_Surname',
      'EMailType',
      'EmailMessage',
      'CustomerAdminId',
      'Admin_Name',
      'Admin_Surname',
      'EmailDate',
      'Send',
      'Receive',
      'IsRead',
      'Subject',

    ];
}
