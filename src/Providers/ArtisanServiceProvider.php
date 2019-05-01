<?php

namespace Lanidev\Pattern\Providers;

use Lanidev\Pattern\Console\ModelMakeCommand;
use Lanidev\Pattern\Console\RepositoryMakeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as BaseServiceProvider;

/**
 * Class ArtisanServiceProvider
 *
 * @package Lanidev\Pattern\Providers
 */
class ArtisanServiceProvider extends BaseServiceProvider
{

    protected $myCommands = [
        'ModelMake' => 'command.model.make',
        'RepositoryMake' => 'command.repository.make'
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(array_merge(
            $this->commands, $this->devCommands, $this->myCommands
        ));
    }

    /**
     * Register the make:model command.
     *
     * @return void
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the make:respository command.
     *
     * @return void
     */
    protected function registerRepositoryMakeCommand()
    {
        $this->app->singleton('command.repository.make', function ($app) {
            return new RepositoryMakeCommand($app['files']);
        });
    }

}
