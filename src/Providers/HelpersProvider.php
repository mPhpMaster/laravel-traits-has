<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * Class HelpersProvider
 *
 * @package mPhpMaster\LaravelTraitsHas\Providers
 */
class HelpersProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        /**
         * Helpers
         */
        require_once __DIR__ . '/../Helpers/Functions.php';
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
