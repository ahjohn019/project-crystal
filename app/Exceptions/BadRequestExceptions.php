<?php

namespace App\Exceptions;

use Exception;

class BadRequestExceptions extends Exception
{
    //
    public function render()
    {
        return response()->json(["error" => true, "message" => $this->getMessage()]);
    }
}
