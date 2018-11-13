<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemString extends Model
{

    protected $fillable = [
        'item_id',
        'language_id',
        'name',
        'description'
    ];


    public function language() {
        return $this->belongsTo('App\Language');
    }
}
