<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateItem extends Model
{

    protected $fillable = [
        'parent_id',
        'certificate_version_id',
        'item_id',
        'on_site',
        'completion_rate',
        'date'
    ];


    protected $visible = [
        'id',
        'on_site',
        'completion_rate',
        'type',
        'translations'
    ];


    protected $appends = [
        'type',
        'translations'
    ];


    public function item() {
        return $this->belongsTo('App\Item');
    }


    public function getTypeAttribute() {
        return $this->item->type;
    }


    public function getTranslationsAttribute() {
        $res = [];
        foreach($this->item->itemStrings as $str) {
            $res[$str->language->code] = [
                'name' => $str->name,
                'description' => $str->description
            ];
        }
        return $res;
    }
}
