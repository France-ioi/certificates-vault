<?php

namespace App\Libs;
use App\Libs\LanguagesCache;
use App\Libs\UserHash;
use App\User;
use App\Certificate;
use App\CertificateVersion;
use App\CertificateItem;
use App\Item;
use App\ItemString;


class Importer
{

    protected $languages_cache;


    public function __construct() {
        $this->languages_cache = new LanguagesCache;
    }


    public function run($data) {
        $user = $this->getUser($data);
        return $this->createCertificate($data, $user);
    }


    private function getUser($data) {
        $user = User::query()
            ->where('platform_id', $data['platform_id'])
            ->where('external_id', $data['user_id'])
            ->first();
        if(!$user) {
            $user = User::create([
                'external_id' => $data['user_id'],
                'platform_id' => $data['platform_id']
            ]);
        }
        return $user;
    }



    private function createCertificate($data, $user) {
        $cert = Certificate::find($data['previous_certificate_id']);
        if(!$cert) {
            $cert = Certificate::create([
                'user_id' => $user->id
            ]);
        }

        $user_hash = UserHash::get($data['user_first_name'], $data['user_last_name']);
        $code = $this->createVerificationCode($user_hash);
        $cert_version = CertificateVersion::create([
            'certificate_id' => $cert->id,
            'verification_code' => $code,
            'user_hash' => $user_hash
        ]);

        $cert->public = $data['public'];
        $cert->view_latest = $data['view_latest'];
        $cert->latest_version_id = $cert_version->id;
        $cert->save();

        $this->createItems(
            $data['platform_id'],
            $data['items'],
            $cert_version
        );

        return [
            'id' => $cert->id,
            'url' => $this->certificateUrl($data, $cert_version)
        ];
    }


    private function createVerificationCode($user_hash) {
        $length = env('VERIFICATION_CODE_LENGTH', 9);
        do {
            $code = $this->randomCode($length);
            $exists = CertificateVersion::query()
                ->where('verification_code', $code)
                ->where('user_hash', $user_hash)
                ->first();
        } while ($exists);
        return $code;
    }


    private function randomCode($l) {
        $c = '0123456789';
        return substr(str_shuffle(str_repeat($c, 5)), 0, $l);
    }


    private function createItems($platform_id, $items_array, $cert_version, $parent_cert_item = null) {
        foreach($items_array as $item_data) {
            if(!($item = Item::find($item_data['id']))) {
                $item = Item::create([
                    'platform_id' => $platform_id,
                    'url' => $item_data['url'],
                    'type' => $item_data['type']
                ]);
                $this->syncItemStrings($item, $item_data['translations']);
            }

            $cert_item = CertificateItem::create([
                'certificate_version_id' => $cert_version->id,
                'parent_id' => $parent_cert_item ? $parent_cert_item->id : null,
                'item_id' => $item->id,
                'on_site' => $item_data['on_site'],
                'completion_rate' => $item_data['completion_rate']
            ]);

            if(isset($item_data['children']) && is_array($item_data['children'])) {
                $this->createItems($platform_id, $item_data['children'], $cert_version, $cert_item);
            }
        }
    }


    private function syncItemStrings($item, $strings) {
        // TODO: items_strings: if the text content is different from existing items_strings,
        // we create a new Item with new items_strings, but with the same items.sURI
        foreach($strings as $str) {
            ItemString::create([
                'item_id' => $item->id,
                'language_id' => $this->languages_cache->getId($str['language']),
                'name' => $str['name'],
                'description' => $str['description']
            ]);
        }
    }



    private function certificateUrl($data, $cert_version) {
        return rtrim(env('APP_BASE_URL', 'http://localhost'), '/').
            '/certificate/'.
            urlencode($data['user_first_name']).'/'.
            urlencode($data['user_last_name']).'/'.
            urlencode($cert_version->verification_code);
    }

}