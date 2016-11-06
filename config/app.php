<?php

return [
    'debug_mode' => appEnv('debug_mode', true),

    'base_path' => realpath(__DIR__ . '/..'),

    'public_path' => realpath(__DIR__ . '/../public'),

    'injectable' => [
        \App\Misc\Options::class,
    ],

    'injectable_prefixes' => [
        'App\\Services\\',
        'App\\Models\\',
    ],

    'components' => [
        \App\Components\InitComponent::class,
        \App\Components\TranslatorComponent::class,
    ],

    'translates' => require __DIR__ . '/../resources/translates/general.php',
];
