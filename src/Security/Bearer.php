<?php

namespace Jobins\APIGenerator\Security;

/**
 * Class Bearer
 *
 * @package Jobins\APIGenerator\Security
 */
class Bearer
{
    public function getSchema()
    {
        return [
            "name"   => "barerToken",
            "type"   => "http",
            "scheme" => "bearer",
        ];
    }
}
