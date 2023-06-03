<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function successResponse(String $message, $result = null, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'data' => $result,
            'code' => $code
        ], $code);
    }

    public static function failedResponse(String $message, $result = null, $code = Response::HTTP_FORBIDDEN)
    {
        return response()->json([
            'message' => $message,
            'data' => $result,
            'code' => $code
        ], $code);
    }
}
