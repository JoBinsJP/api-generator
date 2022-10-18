<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use JoBins\APIGenerator\APIGeneratorServiceProvider;
use JoBins\APIGenerator\Tests\Stubs\ExampleController;
use JoBins\APIGenerator\Tests\Stubs\UsersController;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class TestCase
 */
class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
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
     * @param  Router  $router
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->get('/api/users', [UsersController::class, 'index'])->name('users.index');
        $router->get('/api/users/{id}', [UsersController::class, 'show'])->name('users.show');
        $router->delete('/api/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        $router->post('/api/posts', [ExampleController::class, 'index'])->name('posts.store');
    }
}
