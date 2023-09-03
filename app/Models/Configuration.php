<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_name",
        "ruc",
        "address",
        "contact_number",
        "mail_mailer",
        "mail_host",
        "mail_port",
        "email",
        "mail_password",
        "mail_encryption",
        "mail_from_address",
        "mail_from_name",
    ];
}
