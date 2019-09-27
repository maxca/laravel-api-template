<?php

namespace App\Repository\Criteria;

use App\Repository\ApiRepositoryServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class RequestCriteria
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var array
     */
    private $filters = [];

    /**
     * RequestCriteria constructor.
     * @param array $filters
     */
    public function __construct($filters = [])
    {
        $this->request = app('request');
        $this->filters = $filters;
    }

    /**
     * Apply criteria in query repository
     * @param         Builder|Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, ApiRepositoryServiceInterface $repository)
    {

        $model = $model->where(function ($query) use ($model, $repository) {
            $requestData      = $this->request->all();
            $fieldsSearchable = $repository->getFieldsSearchable();

            if (count($requestData) > 0 && count($fieldsSearchable) > 0) {
                $query->where(function ($query) use ($requestData, $fieldsSearchable) {
                    foreach ($requestData as $key => $val) {
                        if (array_key_exists($key, $fieldsSearchable)) {
                            $operation = $fieldsSearchable[$key];
                            $val       = $operation == 'like' ? '%' . $val . '%' : $val;
                            $query->where($key, $operation, $val);
                            unset($requestData[$key]);
                        }
                    }
                });
            }
        });


        if ($this->request->has('orderBy')) {
            $model = $model->orderBy($this->request->orderBy, $this->request->get('sortedBy', 'asc'));
        }

        if ($this->request->has('offset')) {
            $model = $model->offset($this->request->offset);
        }

        if ($this->request->has('limit')) {
            $model = $model->limit($this->request->limit);
        }

        if (count($this->filters) > 0) {
            foreach ($this->filters as $field => $value) {
                $model = $model->where($field, $value);
            }
        }
        return $model;
    }
}
