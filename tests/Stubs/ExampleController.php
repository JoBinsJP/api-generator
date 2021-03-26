<?php

namespace Jobins\APIGenerator\Tests\Stubs;

use Illuminate\Http\JsonResponse;

/**
 * Class ExampleController
 * @package Jobins\APIGenerator\Tests\Stubs
 */
class ExampleController
{
    /**
     * @param ExampleFormRequest $request
     *
     * @return JsonResponse
     */
    public function index(ExampleFormRequest $request)
    {
        return response()->json(["message" => "This is json response", "data" => []]);
    }
}
