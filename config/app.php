<?php

return [
    'debug_mode' => appEnv('debug_mode', true),

    'base_path' => realpath(__DIR__ . '/..'),

    'public_path' => realpath(__DIR__ . '/../public'),
];
