<?php

namespace JoBins\APIGenerator\Security;

/**
 * Class Bearer
 *
 * @package JoBins\APIGenerator\Security
 */
class Bearer
{
    public function getSchema()
    {
        return [
            "name" => "barerToken",
            "type" => "http",
            "scheme" => "bearer",
        ];
    }
}
