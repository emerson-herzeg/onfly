<?php

namespace App\Services;
use Illuminate\Http\JsonResponse;

class ApiResponseService
{
    public function success($data = [], string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'code' => $statusCode,
        ],$statusCode);
    }

    public function error(string $message = 'Error', array $errors = [], int $statusCode = 400): JsonResponse 
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'code' => $statusCode,
        ], $statusCode);
    }
}
