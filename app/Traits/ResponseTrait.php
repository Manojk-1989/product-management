<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Location\Facades\Location;

trait ResponseTrait
{
    /**
     * Send a JSON response with the given data, status code, and message.
     *
     * @param  array  $data
     * @param  int  $statusCode
     * @param  string|null  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendJsonResponse(array $data, $statusCode, $message = null)
    {
        $responseData = [
            'status' => $statusCode,
            'message' => $message ?? $this->getDefaultMessage($statusCode),
            'data' => $data,
        ];

        return response()->json($responseData, $statusCode);
    }

    /**
     * Get the default message for a given status code.
     *
     * @param  int  $statusCode
     * @return string
     */
    protected function getDefaultMessage($statusCode)
    {
        switch ($statusCode) {
            case 200:
                return 'Success';
            case 201:
                return 'Created';
            case 400:
                return 'Bad Request';
            case 401:
                return 'Unauthorized';
            case 404:
                return 'Not Found';
            case 500:
                return 'Internal Server Error';
            default:
                return '';
        }
    }

    /**
     * Send a JSON success response with the given message and status code 200.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse($message = null)
    {
        return $this->sendJsonResponse([], 200, $message);
    }

    /**
     * Send a JSON error response with the given message and status code 500.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendErrorResponse($message = null)
    {
        return $this->sendJsonResponse([], 500, $message);
    }

    /**
     * Send a JSON created response with the given message and status code 201.
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendCreatedResponse($message = null)
    {
        return $this->sendJsonResponse([], 201, $message);
    }
}
