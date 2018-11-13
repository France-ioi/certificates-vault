<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateString extends Model
{

    protected $fillable = [
        'certificate_id',
        'language_id',
        'name',
        'description',
    ];

}
