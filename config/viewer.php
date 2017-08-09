<?php

return [
    'path' => __DIR__ . '/../resources/views',

    'compilers' => [
        [
            'extension' => '.blade.php',
            'type' => \Greg\AppView\ViewServiceProvider::EXTENSION_BLADE,
            'compilationPath' => __DIR__ . '/../storage/views'
        ],
    ],
];
