<?php

namespace JoBins\APIGenerator\Security;

use Illuminate\Support\Arr;

/**
 * Trait HasServer
 */
trait HasServer
{
    public function processServer(array $config): array
    {
        return [
            Arr::get($config, 'servers'),
        ];
    }
}
