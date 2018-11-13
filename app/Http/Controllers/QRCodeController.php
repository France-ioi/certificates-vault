<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;


class QRCodeController extends Controller
{

    public function render(Request $request) {
        $url = $request->get('url');
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(200);
        $renderer->setWidth(200);
        $renderer->setMargin(0);
        $writer = new \BaconQrCode\Writer($renderer);
        return response($writer->writeString($url), 200)->header('Content-Type', 'image/png');
    }
}