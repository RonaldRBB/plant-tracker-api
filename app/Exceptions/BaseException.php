<?php

/**
 * Base Exception
 * -----------------------------------------------------------------------------
 * Clase de base para las excepciones de la api.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\ApiResponse;

/**
 * Base Exception
 * -----------------------------------------------------------------------------
 */
abstract class BaseException extends Exception
{
    protected $errors;
    /**
     * Construct
     * -------------------------------------------------------------------------
     */
    protected function __construct(
        string $message = '',
        array $errors = [],
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }
    /**
     * Render
     * -------------------------------------------------------------------------
     */
    public function render(): JsonResponse
    {
        return ApiResponse::error($this->getMessage(), $this->errors, $this->code);
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
