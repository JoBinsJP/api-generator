<?php

namespace JoBins\APIGenerator\Security;

use Illuminate\Support\Arr;

/**
 * Trait HasServer
 *
 * @package JoBins\APIGenerator\Security
 */
trait HasServer
{
    /**
     * @param array $config
     *
     * @return array
     */
    public function processServer(array $config): array
    {
        return [
            Arr::get($config, "servers"),
        ];
    }
}
