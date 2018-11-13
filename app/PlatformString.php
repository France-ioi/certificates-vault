<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformString extends Model
{

    protected $fillable = [
        'platform_id',
        'name',
        'language_id'
    ];

}
