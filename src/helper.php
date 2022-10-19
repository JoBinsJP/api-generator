<?php

/**
 * @param  string  $class
 * @return string
 */
function getClassIdentifier(string $class): string
{
    return md5($class);
}
