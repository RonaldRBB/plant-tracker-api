<?php

/**
 * Base Model
 * -----------------------------------------------------------------------------
 * Clase base para los modelos de la aplicación.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Model
 * -----------------------------------------------------------------------------
 */
class BaseModel extends Model
{
    protected $attributes = [];
    protected array $relationsList = [];
    protected array $relationsToLoad = [];
    /**
     * Magic Get
     * -------------------------------------------------------------------------
     * Convierte los atributos de camelCase a snake_case para respetar la
     * convención PSR-12 y respetar el snake_case en base de datos.
     */
    public function __get($key)
    {
        $snakeKey = Str::snake($key);
        if (array_key_exists($snakeKey, $this->attributes) === true) {
            return $this->attributes[$snakeKey];
        }
        return parent::__get($key);
    }
    /**
     * Magic Set
     * -------------------------------------------------------------------------
     * Convierte los atributos de camelCase a snake_case para respetar la
     * convención PSR-12 y respetar el snake_case en base de datos.
     */
    public function __set($key, $value)
    {
        $snakeKey = Str::snake($key);
        if (array_key_exists($snakeKey, $this->attributes) === true) {
            $this->attributes[$snakeKey] = $value;
        } else {
            parent::__set($key, $value);
        }
    }
}
