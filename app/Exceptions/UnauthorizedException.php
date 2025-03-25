<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Exception;

class UnauthorizedException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized Access',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
