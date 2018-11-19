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


    public function language() {
        return $this->belongsTo('App\Language');
    }

}
