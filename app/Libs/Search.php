<?php

namespace App\Libs;

use App\Libs\UserHash;
use App\User;
use App\CertificateVersion;

class Search
{


    public static function certificateVersion($first_name, $last_name, $code) {
        $hash = UserHash::get($first_name, $last_name);
        return CertificateVersion::query()
            ->where('user_hash', $hash)
            ->where('verification_code', $code)
            ->with([
                'certificateStrings',
                'certificateStrings.language',
                'certificateItems',
                'certificateItems.item',
                'certificateItems.item.itemStrings',
                'certificateItems.item.itemStrings.language'
            ])
            ->first();
    }


    public static function publicCertificates($platform_id, $user_id) {
        $user = User::query()
            ->where('platform_id', $platform_id)
            ->where('external_id', $user_id)
            ->firstOrFail();

        return CertificateVersion::query()
            ->whereIn('certificate_id', function($q) use ($user) {
                $q->select('id')
                    ->from('certificates')
                    ->where('user_id', $user->id)
                    ->where('public', true);
            })
            ->with([
                'certificateStrings',
                'certificateStrings.language',
                'certificateItems',
                'certificateItems.item',
                'certificateItems.item.itemStrings',
                'certificateItems.item.itemStrings.language'
            ])
            ->get();
    }

}