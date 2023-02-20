<?php

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true, // ここにルール追記
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->exclude([
            'vendor'
        ])
        ->in(__DIR__)
    )
;
