<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class BaseService
{
    protected $model;

    protected $defaultLimit = 20;

    protected $defaultMaxLimit = 500;

    protected $defaultSort = 'id:desc';

    protected $cacheOnly = ['getAll'];

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Repository class name
     *
     * @return string
     */
    abstract public function model(): string;

    /**
     * @return Model
     * @throws Exception
     */
    public function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function resetModel()
    {
        $this->makeModel();
    }

    public function getAll(array $params = [], $query = null)
    {
        $params = Arr::except($params, 'device');

        if (!$query) {
            $query = $this->prepareQuery();
        }

        $filters = Arr::except($params, ['limit', 'sort', 'offset']);
        $limit = $params['limit'] ?? $this->defaultLimit;
        $limit = $limit < 0 ? $this->defaultMaxLimit : min($limit, $this->defaultMaxLimit);
        $offset = $params['offset'] ?? 0;
        $sort = explode(',', data_get($params, 'sort', $this->defaultSort));
//        $orders = [];
//
//        foreach ($sort as $item) {
//            $item = explode(':', $item);
//
//            if (count($item) === 2) {
//                $orders[$item[0]] = $item[1];
//            }
//        }

        $filters = $this->prepareFilterData($filters);
//        $orders = $this->prepareSortData($orders);
        $result = $query->offset($offset)->paginate($limit)->appends($params);
        $this->resetModel();

        return $result;
    }

    protected function prepareSortData($orders)
    {
        return $orders;
    }

    protected function prepareFilterData($filters)
    {
        return $filters;
    }

    protected function prepareQuery()
    {
        return $this->model->newQuery();
    }

    public function find($id, $columns = ['*'])
    {
        $model = $this->model->find($id, $columns);
        $this->resetModel();

        return $model;
    }

    public function findOrFail($id, $columns = ['*'])
    {
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $model;
    }

    public function findByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($field, '=', $value)->get($columns);
        $this->resetModel();

        return $model;
    }

    public function findOrFailByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($field, '=', $value)->firstOrFail($columns);
        $this->resetModel();

        return $model;
    }

    public function firstByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($field, '=', $value)->first($columns);
        $this->resetModel();

        return $model;
    }

    public function all($columns = ['*'])
    {
        $result = $this->model->get($columns);
        $this->resetModel();

        return $result;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        $attributes = $this->prepareData($attributes);
        $model = $this->model->newInstance($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $attributes = $this->prepareData($attributes);
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    protected function prepareData($attributes)
    {
        return $attributes;
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function findMultipleFields($params=[])
    {
        $model = $this->model;
        if (count($params)) {
            foreach ($params as $key => $value) {
                if (!empty($value)){
                    if (is_string($value)) {
                        $model = $model->where($key, 'like', '%' . $value . '%');
                    } else {
                        $model = $model->where($key, $value);
                    }
                }
            }
        }
        return $model;
    }

    /**
     * Trigger method calls to the model
     *
     * @param $method
     * @param $arguments
     * @return false|mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }
}
