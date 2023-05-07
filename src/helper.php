<?php

function getClassIdentifier(string $class): string
{
    return md5($class);
}
