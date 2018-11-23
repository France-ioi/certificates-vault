<?php

namespace App\Libs;

use App\Libs\UserHash;
use App\User;
use App\CertificateVersion;
use App\Certificate;

class Search
{


    public static function certificateVersion($first_name, $last_name, $code) {
        $hash = UserHash::get($first_name, $last_name);
        return CertificateVersion::query()
            ->where('user_hash', $hash)
            ->where('verification_code', $code)
            ->with([
                'certificate',
                'certificate.user',
                'certificateStrings',
                'certificateStrings.language',
                'certificateItems',
                'certificateItems.item',
                'certificateItems.item.itemStrings',
                'certificateItems.item.itemStrings.language'
            ])
            ->first();
    }


    public static function publicCertificates($first_name, $last_name) {
        $hash = UserHash::get($first_name, $last_name);
        return Certificate::query()
            ->where('public', true)
            ->whereHas('latestVersion', function($q) use ($hash) {
                $q->where('user_hash', $hash);
            })
            ->with([
                'latestVersion'
            ])
            ->get()
            ->map(function($cert) {
                return [
                    'created_at' => $cert->latestVersion->created_at->format('Y-m-d'),
                    'code' => $cert->latestVersion->verification_code,
                    'translations' => $cert->translations
                ];
            });
    }

}