<?php

/**
 * Controller
 * -----------------------------------------------------------------------------
 * Controlador base para todos los controladores.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\BaseControllerException;
use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller
 * -----------------------------------------------------------------------------
 */
class Controller extends BaseController
{
    protected const DEFAULT_PAGE_SIZE = 5000;
    protected const ALLOWED_PAGE_SIZES = [10, 100, 1000, 5000];
    protected ApiResponse $apiResponse;
    protected Model $modelInstance;
    protected array $loadRelations = [];
    protected array $rules = [];
    /**
     * Construct
     * -------------------------------------------------------------------------
     */
    public function __construct(Model $model)
    {
        $this->apiResponse = new ApiResponse();
        $this->modelInstance = $model;
    }
    /**
     * Index Resource
     * -------------------------------------------------------------------------
     * Obtiene todos los registros de la base de datos.
     */
    protected function indexResource(Request $request): JsonResponse
    {
        $query = $this->applyFilter($request);
        if (!empty($this->loadRelations)) {
            $query->with($this->loadRelations);
        }
        $query = $this->sortQuery($query, $request);
        $result = $this->paginateQuery($query, $request);
        return $this->apiResponse->success($result, $this->apiResponse::$recordRetrievedMessage);
    }
    /**
     * Apply Filter
     * -------------------------------------------------------------------------
     * Filtra los registros de la base de datos.
     */
    protected function applyFilter(Request $request): Builder
    {
        $filters = $this->modelInstance->getFillable();
        $query = $this->modelInstance->query();
        foreach ($filters as $filter) {
            if ($request->has($filter) === true) {
                $value = $request->input($filter);
                if (is_array($value) === true) {
                    $query->whereIn($filter, $value);
                } else {
                    $query->where($filter, $value);
                }
            }
        }
        if ($request->has('start_date') === true && $request->has('end_date') === true) {
            $startDate = $request->input('start_date') . ' 00:00:00';
            $endDate = $request->input('end_date') . ' 23:59:59';
            if (in_array('datetime', $filters) === true) {
                $query->whereBetween('datetime', [$startDate, $endDate]);
            } else {
                $query->whereBetween('updated_at', [$startDate, $endDate]);
            }
        }
        return $query;
    }
    /**
     * Sort Query
     * -------------------------------------------------------------------------
     * Ordena los registros de la base de datos.
     */
    private function sortQuery(Builder $query, Request $request): Builder
    {
        if ($request->has('order_by') === true && $request->has('sort') === true) {
            $query->orderBy($request->input('order_by'), $request->input('sort'));
        } else {
            $query->orderBy('id', 'desc');
        }
        return $query;
    }
    /**
     * Paginate Query
     * -------------------------------------------------------------------------
     * Pagina los registros de la base de datos.
     */
    protected function paginateQuery(Builder $query, Request $request): LengthAwarePaginator
    {
        if ($request->has('page_size') === true) {
            $pageSize = $request->input('page_size');
            if (in_array($pageSize, self::ALLOWED_PAGE_SIZES) === true) {
                return $query->paginate($pageSize);
            }
        }
        return $query->paginate(self::DEFAULT_PAGE_SIZE);
    }
    /**
     * Store Resource
     * -------------------------------------------------------------------------
     * Crea un nuevo registro en la base de datos.
     */
    protected function storeResource(Request|array $request, bool $validated = false): JsonResponse
    {
        if ($validated === false) {
            $request = $this->validateRequest($request);
        }
        return $this->apiResponse->success(
            $this->modelInstance->create($request),
            $this->apiResponse::$recordCreatedMessage,
            Response::HTTP_CREATED
        );
    }
    /**
     * Show Resource
     * -------------------------------------------------------------------------b
     * Obtiene un registro de la base de datos.
     */
    protected function showResource(Request $request, Model $resource): JsonResponse
    {
        $loadParameters = array_keys($request->all());
        foreach ($loadParameters as $key) {
            if (strpos($key, 'load_') === 0) {
                $resource->addToRelationsToLoad(Str::after($key, 'load_'));
            }
        }
        return $this->apiResponse->success($resource, $this->apiResponse::$recordRetrievedMessage);
    }
    /**
     * Update Resource
     * -------------------------------------------------------------------------
     * Actualiza un registro de la base de datos.
     */
    protected function updateResource(Request|array $request, Model $resource, bool $validated = false): JsonResponse
    {
        if ($validated === false) {
            $request = $this->validateRequest($request, true);
        }
        $resource->update($request);
        return $this->apiResponse->success($resource, $this->apiResponse::$recordUpdatedMessage);
    }
    /**
     * Destroy Resource
     * -------------------------------------------------------------------------
     * Elimina un registro de la base de datos.
     */
    protected function destroyResource(Model $resource): JsonResponse
    {
        $resource->delete();
        return $this->apiResponse->success($resource, $this->apiResponse::$recordDeletedMessage);
    }
    /**
     * Validate Request
     * -------------------------------------------------------------------------
     * Valida los datos enviados en el request.
     */
    public function validateRequest(Request $request, bool $update = false): array
    {
        $rules = $this->rules;
        if ($update === true) {
            $validRules = array_intersect_key($rules, $request->all());
        } else {
            $validRules = $rules;
        }
        try {
            return $request->validate($validRules);
        } catch (\Exception $e) {
            throw BaseControllerException::validationError($e->errors());
        }
    }
}
