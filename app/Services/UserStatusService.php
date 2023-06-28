<?php

namespace App\Services;
use App\Services\BaseService;
use App\Models\UserStatus;

class UserStatusService extends BaseService
{

    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return UserStatus::class;
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