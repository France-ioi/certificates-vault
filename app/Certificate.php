<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

    protected $fillable = [
        'user_id',
        'latest_id',
        'public',
        'view_latest'
    ];


    public function latestVersion() {
        return $this->belongsTo('App\CertificateVersion');
    }


    public function user() {
        return $this->belongsTo('App\User');
    }
}
