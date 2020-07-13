<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ControllerApi extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $response = [
        "success" => true,
    ];
    public $response_code = 200;

    public function __construct()
    {

    }

    /**
     * @param string $error_message
     * @param int $error_code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($error_message = "", $error_code = 500, $headers = [])
    {
        $this->response['success'] = false;
        return response()->json([
            "error" => $error_message
        ], $error_code, $headers);
    }

    public function setResponseFailed($error, $error_code = 200, $data = [])
    {
        $this->response_code = $error_code;
        $this->response['error'] = $error;
        $this->response['data'] = $data;
        $this->response['success'] = false;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function response()
    {
        return response()->json($this->response, $this->response_code);
    }
}
