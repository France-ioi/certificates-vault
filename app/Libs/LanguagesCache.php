<?php

namespace App\Libs;

use App\Language;

class LanguagesCache
{

    protected $data;

    public function __construct() {
        $this->data = Language::get()->pluck('id', 'code')->toArray();
    }

    public function getId($code) {
        if(!isset($this->data[$code])) {
            $lng = Language::create([
                'code' => $code
            ]);
            $this->data[$code] = $lng;
        }
        return $this->data[$code];
    }

}
