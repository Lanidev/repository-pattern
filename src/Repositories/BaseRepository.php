<?php

namespace Lanidev\Pattern\Repositories;

use Illuminate\Contracts\Container\Container as App;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Lanidev\Pattern\Contracts\RepositoryInterface;
use Lanidev\Pattern\Exceptions\RepositoryException;

/**
 * Class BaseRepository
 * @package Lanidev\Pattern\Repositories
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * The IoC container instance.
     *
     * @var App
     */
    private $app;

    /**
     * The repository model
     *
     * @var string
     */
    protected $model;

    /**
     * @param App $app
     * @throws RepositoryException
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel() {
        $namespace = Config::get('pattern.namespaces.models');
        $model = $this->app->make("$namespace\\$this->model");

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model->newQuery();
    }
}
