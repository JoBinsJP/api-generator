<?php
return [

    // Basic server configuration
    "servers" => [
        "url" => env("API_URL", "http://api.localhost.test"),
    ],

    "openapi" => "3.0.0",
    "title"   => "Reaching APP API",
    "version" => "1.0.0",

    "file-path" => storage_path("api-docs/api-docs.json"),
];
