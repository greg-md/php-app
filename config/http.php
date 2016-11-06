<?php

return [
    'controllers_prefixes' => [
        'App\\Http\\Controllers\\',
    ],

    'components' => [
        \App\Http\Components\RouterComponent::class,
        \App\Http\Components\DebugComponent::class,
    ],
];
