<?php

/**
 * Bet Exception
 * -----------------------------------------------------------------------------
 * Clase de manejo de excepciones de apuestas.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bet Exception
 * -----------------------------------------------------------------------------
 */
class BaseControllerException extends BaseException {
    public static function validationError($errors) {
        return new self(
            'Validation Error',
            $errors,
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
