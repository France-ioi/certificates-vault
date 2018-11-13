<?php
namespace App\Libs;

class UserHash
{

    public static function get($first_name, $last_name) {
        return sha1($first_name.$last_name);
    }

}