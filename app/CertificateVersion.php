<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateVersion extends Model
{

    protected $fillable = [
        'certificate_id',
        'verification_code',
        'user_hash',
        'views'
    ];


    protected $visible = [
        'id',
        'verification_code',
        'views',
        'created_at',
        'items',
        'translations'
    ];

    protected $appends = [
        'items',
        'translations'
    ];


    public function certificateItems() {
        return $this->hasMany('App\CertificateItem');
    }


    public function getItemsAttribute() {
        $res = [];
        foreach($this->certificateItems as $ci) {
            if($ci->parent_id !== null) continue;
            $res[$ci->id] = $ci->toArray();
            $res[$ci->id]['children'] = [];
        }
        foreach($this->certificateItems as $ci) {
            if($ci->parent_id === null) continue;
            $res[$ci->parent_id]['children'][] = $ci->toArray();
        }
        return array_values($res);
    }


    public function certificateStrings() {
        return $this->hasMany('App\CertificateString', 'certificate_id');
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