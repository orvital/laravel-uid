<?php

namespace Orvital\Uid;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orvital\Uid\UlidMigrationRepository;
use Orvital\Uid\Mixins\UlidSchemaMixin;

class UidServiceProvider extends ServiceProvider
{
    /**
     * Register service.
     */
    public function register()
    {
        $this->app->extend('migration.repository', function ($repository, $app) {
            return new UlidMigrationRepository($app['db'], $app['config']['database.migrations']);
        });
    }

    /**
     * Bootstrap service.
     */
    public function boot()
    {
        Blueprint::mixin(new UlidSchemaMixin());
    }
}
