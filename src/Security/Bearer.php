<?php

namespace JoBins\APIGenerator\Security;

/**
 * Class Bearer
 */
class Bearer
{
    public function getSchema()
    {
        return [
            'name' => 'barerToken',
            'type' => 'http',
            'scheme' => 'bearer',
        ];
    }
}
