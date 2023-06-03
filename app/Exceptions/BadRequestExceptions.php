<?php

namespace App\Exceptions;

use Exception;

class BadRequestExceptions extends Exception
{
    //
    public function render()
    {
        $error_code = 40000;

        return response()->json(["code" => $error_code, "message" => $this->getMessage()]);
    }
}
