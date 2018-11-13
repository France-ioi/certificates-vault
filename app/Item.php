<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'platform_id',
        'type',
        'url'
    ];


    public function itemStrings() {
        return $this->hasMany('App\ItemString');
    }
}
