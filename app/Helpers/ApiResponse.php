<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Response success API common
     *
     * @param $data
     * @param null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success($data, $message = null, int $statusCode = 200): JsonResponse
    {
        $collectionData = !is_array($data) ? json_decode($data->toJson(), true) : [];
        $response = [
            'success' => true,
            'data' => $data,
            ... !empty($collectionData['data']) ? $collectionData : [],
            'message' => $message
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Response error API common
     *
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    public static function error($message, $statusCode): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        return response()->json($response, $statusCode);
    }
}
