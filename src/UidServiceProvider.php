<?php

namespace Orvital\Uid;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Orvital\Uid\Mixins\UlidSchemaMixin;

class UidServiceProvider extends ServiceProvider
{
    /**
     * Register service.
     */
    public function register()
    {
    }

    /**
     * Bootstrap service.
     */
    public function boot()
    {
        Blueprint::mixin(new UlidSchemaMixin());
    }
}
