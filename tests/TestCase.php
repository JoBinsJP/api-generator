<?php

namespace Jobins\APIGenerator\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Jobins\APIGenerator\APIGeneratorServiceProvider;
use Jobins\APIGenerator\Tests\Stubs\ExampleController;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Jobins\APIGenerator
 */
class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
//        $app->setBasePath(__DIR__.'/..');

        return [
            APIGeneratorServiceProvider::class,
        ];
    }

    /**
     * Define routes setup.
     *
     * @param Router $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->post("/api/posts", [ExampleController::class, "index"])->name("posts.store");
    }
}
