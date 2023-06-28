<?php

namespace App\Services\Admin;
use App\Services\BaseService;
use App\Models\User;

class UserService extends BaseService
{

    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return User::class;
    }

    public function prepareQuery()
    {
        return $this->model->select('*');
    }

    public function firstByFieldTrashed($field, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($field, '=', $value)->withTrashed()->first($columns);
        $this->resetModel();

        return $model;
    }
}