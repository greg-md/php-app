<?php

return [
    'debug' => getenv('DEBUG') ?: true,

    'base_path' => realpath(__DIR__ . '/..'),

    'public_path' => realpath(__DIR__ . '/../public'),
];
