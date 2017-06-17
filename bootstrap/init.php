#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

\Greg\Support\Dir::copy(__DIR__ . '/../vendor/maximebf/debugbar/src/DebugBar/Resources', __DIR__ . '/../public/debug');

echo 'Application initialized!' . PHP_EOL;
