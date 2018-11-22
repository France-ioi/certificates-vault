<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Libs\Search;
use App\Language;

class AppController extends Controller
{

    public function index() {
        return view('app', [
            'app_data' => $this->appData()
        ]);
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