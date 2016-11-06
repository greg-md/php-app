#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

copy(__DIR__ . '/env.example.php', __DIR__ . '/env.php');

\Greg\Support\Dir::copy(__DIR__ . '/vendor/maximebf/debugbar/src/DebugBar/Resources', __DIR__ . '/public/debug');

echo 'Application initialized!' . PHP_EOL;
