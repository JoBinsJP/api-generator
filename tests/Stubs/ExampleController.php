<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Http\JsonResponse;

/**
 * Class ExampleController
 */
class ExampleController
{
    /**
     * @param  ExampleFormRequest  $request
     * @return JsonResponse
     */
    public function index(ExampleFormRequest $request)
    {
        return response()->json(['message' => 'This is json response', 'data' => []]);
    }
}
