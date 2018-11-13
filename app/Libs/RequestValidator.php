<?php

namespace App\Libs;

class RequestValidator
{


    public static function certificateStatus() {
        return [
            //'certificate_id' => 'required|exists:certificates,id',
            'public' => 'required',
            'view_latest' => 'required'
        ];
    }


    public static function certificate() {
        return [
            'platform_id' => 'required|exists:platforms,id',
            'user_first_name' => 'required',
            'user_last_name' => 'required',
        ];
    }


    //public static function certificate() {

    //}

}