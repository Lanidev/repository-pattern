<?php

namespace Lanidev\Pattern\Console;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Create a new repository class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     *
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = null;

        if ($this->option('model')) {
            $stub = '/stubs/repository.model.stub';
        }

        $stub = $stub ?? '/stubs/repository.plain.stub';

        return __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $rootNamespace = Config::get('pattern.namespaces.repositories');
        return $rootNamespace;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements();
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildModelReplacements()
    {
        $model = $this->parseModel($this->option('model'));
        $class = class_basename($model);

        if (! class_exists($model)) {
            if ($this->confirm("A {$class} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $model]);
            }
        }

        return [
            'DummyModelClass' => $class,
        ];
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = Config::get('pattern.namespaces.models'))) {
            $model = "$rootNamespace\\$model";
        }

        return $model;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_REQUIRED, 'Generate a new Eloquent model for the given repository.'],
        ];
    }
}
