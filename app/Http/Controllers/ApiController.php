<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Libs\RequestValidator;
use Validator;
use App\Certificate;
use App\Libs\Importer;
use DB;
use App\Libs\Search;

class ApiController extends Controller
{


    public function get($first_name, $last_name, $code) {
        $res = [
            'success' => false,
            'error' => 'not_found'
        ];
        if($cert_version = Search::certificateVersion($first_name, $last_name, $code)) {
            $res = [
                'success' => true,
                'data' => $cert_version
            ];
        }
        return response()->json($res);
    }


    public function publicCertificates($platform_id, $user_id) {
        return response()->json(
            Search::publicCertificates($platform_id, $user_id)
        );
    }


    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $importer = new Importer;
            $res = $importer->run($request->json()->all());
            $res['success'] = true;
        } catch(Exception $e) {
            DB::rollback();
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($res);
        }
        DB::commit();
        return response()->json($res);
    }


    public function update(Request $request, $certificate_id) {
        $validator = Validator::make(
            $request->json()->all(),
            RequestValidator::certificateStatus()
        );
        if($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $validator->getMessageBag()->add('success', false);
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }
        $cert = Certificate::find($certificate_id);
        $cert->public = $request->json()->get('public');
        $cert->view_latest = $request->json()->get('view_latest');
        $cert->save();
        return response()->json([
            'success' => true
        ]);
    }

}