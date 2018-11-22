<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

    protected $fillable = [
        'user_id',
        'latest_id',
        'public',
        'view_latest',

    ];



    public function latestVersion() {
        return $this->belongsTo('App\CertificateVersion');
    }


    public function user() {
        return $this->belongsTo('App\User');
    }


    public function certificateStrings() {
        return $this->hasMany('App\CertificateString');
    }


    public function getTranslationsAttribute() {
        $res = [];
        foreach($this->certificateStrings as $str) {
            $res[$str->language->code] = [
                'name' => $str->name,
                'description' => $str->description
            ];
        }
        return $res;
    }

}
