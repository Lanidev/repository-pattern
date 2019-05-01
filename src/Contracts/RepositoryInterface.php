<?php

namespace Lanidev\Pattern\Contracts;

/**
 * Interface RepositoryInterface
 *
 * @package Lanidev\Pattern\Contracts
 */
interface RepositoryInterface {

    public function browse($columns = array('*'));

    public function read($field, $value, $columns = array('*'));

    public function add(array $data);

    public function edit(array $data, $id);

    public function delete($id);

    public function paginate($perPage = 15, $columns = array('*'));

}
