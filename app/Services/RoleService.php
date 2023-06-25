<?php

namespace App\Services;
use App\Models\Role;

class RoleService extends BaseService
{

    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return Role::class;
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