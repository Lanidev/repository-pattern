<?php

namespace Lanidev\Pattern\Repositories;

/**
 * Class EloquentRepository
 * @package Lanidev\Pattern\Repositories
 */
class EloquentRepository extends BaseRepository
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function browse($columns = array('*')) {
        return $this->model->get($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function read($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function edit(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }
}
