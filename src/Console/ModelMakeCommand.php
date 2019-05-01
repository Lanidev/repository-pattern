<?php

namespace Lanidev\Pattern\Console;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Console\ModelMakeCommand as Command;

class ModelMakeCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        if ($this->option('all')) {
            $this->input->setOption('factory', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('resource', true);
            $this->input->setOption('repository', true);
        }

        if($this->option('repository')){
            $this->createRepository();
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $rootNamespace = Config::get('pattern.namespaces.models');
        return $rootNamespace;
    }

    /**
     * Create a repository for the model.
     *
     * @return void
     */
    protected function createRepository()
    {
        $repository = Str::studly(class_basename($this->argument('name')));

        $this->call('make:repository', [
            'name' => "{$repository}Repository",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        array_push($options,
            ['repository', null, InputOption::VALUE_NONE, 'Create a new repository for the model']
        );

        return $options;
    }
}
