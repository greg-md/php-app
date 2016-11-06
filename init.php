#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

copy('env.example.php', 'env.php');

\Greg\Support\Dir::copy('vendor/maximebf/debugbar/src/DebugBar/Resources', 'public/debug');

echo 'Application initialized!' . PHP_EOL;
