<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class RegraNegocioException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
           'message' => $this->getMessage()
        ], 400); // Codigo para Bad Request
    }
}
