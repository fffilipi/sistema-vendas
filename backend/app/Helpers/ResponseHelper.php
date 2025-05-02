<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Generate a success JSON response.
     *
     * @param string $message The success message to include in the response.
     * @param mixed|null $data Optional data to include in the response.
     * @param int $status The HTTP status code for the response (default is 200).
     * @return \Illuminate\Http\JsonResponse The JSON response with the success message and optional data.
     */
    public static function success(string $message, $data = null, int $status = 200): JsonResponse
    {
        $response = ['message' => $message];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Generate an error JSON response.
     *
     * @param string $message The error message to include in the response (default is a generic error message).
     * @param int $status The HTTP status code for the response (default is 500).
     * @return \Illuminate\Http\JsonResponse The JSON response with the error message.
     */
    public static function error(string $message = 'Erro interno. Tente novamente mais tarde.', int $status = 500): JsonResponse
    {
        if ($status < 100 || $status >= 600) {
            $status = 500;
        }

        return response()->json([
            'message' => $message
        ], $status);
    }
}
