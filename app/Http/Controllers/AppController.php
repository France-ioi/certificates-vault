<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Libs\Search;
use App\Language;

class AppController extends Controller
{

    public function index() {
        return view('app', [
            'app_state' => null,
            'app_data' => $this->appData()
        ]);
    }


    public function search($first_name, $last_name, $code) {
        return view('app', [
            'app_state' => null,
            'app_data' => $this->appData()
        ]);
        /*
        $cert_version = Search::certificateVersion($first_name, $last_name, $code);
        if($cert_version) {
            $cert_version->views = $cert_version->views + 1;
            $cert_version->save();
            $app_state = [
                'data' => $cert_version,
                'params' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'code' => $code
                ]
            ];
            return view('app', [
                'app_state' => $app_state,
                'app_data' => $this->appData()
            ]);
        }
        return redirect('/');
        */
    }


    private function appData() {
        return [
            'default_language' => env('DEFAULT_LANGUAGE', 'en'),
            'languages' => Language::get(),
            'date_format' => env('DATE_FORMAT', 'yy-MM-dd'),
            'platform_url' => env('PLATFORM_URL', false)
        ];
    }
}