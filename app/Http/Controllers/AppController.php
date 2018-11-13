<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Libs\Search;


class AppController extends Controller
{

    public function index() {
        return view('app.index', [
            'app_state' => null
        ]);
    }


    public function search($first_name, $last_name, $code) {
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
            return view('app.index', [
                'app_state' => $app_state
            ]);
        }
        return redirect('/');
    }
}