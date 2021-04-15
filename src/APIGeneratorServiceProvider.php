<?php

namespace Jobins\APIGenerator;

use Illuminate\Support\ServiceProvider;
use Jobins\APIGenerator\Services\Generator;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\TestResponse;

/**
 * Class APIGeneratorServiceProvider
 */
class APIGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register Services
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/api-generator.php', 'api-generator'
        );
    }


    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/api-generator.php' => config_path('api-generator.php'),
        ]);

        TestResponse::macro("generate", function ($testCase, $generate) {
            if ( !$generate ) {
                return;
            }

            /** @var JsonResponse $response */
            $response = $this;

            (new Generator())->setRequest($testCase->getParams())->setResponse($response)->generate();
        });
    }
}
