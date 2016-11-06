<?php

return [
    'debug_mode' => appEnv('debug_mode', true),

    'base_path' => realpath(__DIR__ . '/..'),

    'public_path' => realpath(__DIR__ . '/../public'),

    'controllers_prefixes' => [
        'App\\Http\\Controllers\\',
    ],

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
        \App\Components\RouterComponent::class,
        \App\Components\DebugComponent::class,
    ],

    'translates' => require __DIR__ . '/../resources/translates/general.php',
];
