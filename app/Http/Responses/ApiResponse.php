<?php

/**
 * API Response
 * -----------------------------------------------------------------------------
 * Clase base para las respuestas de la API.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Response
 * -----------------------------------------------------------------------------
 */
class ApiResponse
{
    public static $successMessage = 'Operation successful.';
    public static $recordRetrievedMessage = 'Data retrieved successfully.';
    public static $recordCreatedMessage = 'Record created successfully.';
    public static $recordUpdatedMessage = 'Record updated successfully.';
    public static $recordDeletedMessage = 'Record deleted successfully.';
    /**
     * Success Response
     * -------------------------------------------------------------------------
     * Envia una respuesta exitosa.
     */
    public static function success(
        Model|LengthAwarePaginator|Collection|array $data,
        string $message = '',
        int $status = Response::HTTP_OK
    ): JsonResponse {
        if (empty($message) === true) {
            $message = self::$successMessage;
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => $message,
                'data' => $data,
            ],
            $status
        );
    }
    /**
     * Error Response
     * -------------------------------------------------------------------------
     * Envia una respuesta de error.
     */
    public static function error(string $message, array $error = null, int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(
            [
                'status' => 'error',
                'message' => $message,
                'errors' => $error,
            ],
            $status
        );
    }
}
