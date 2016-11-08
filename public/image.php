<?php

/**
 * @var $app \Greg\ApplicationStrategy
 */
$app = require __DIR__ . '/../autoload.php';

try {
    $app->scope(function (\Greg\StaticImage\ImageCollector $collector) {
        $collector->run(\Greg\Support\Http\Request::uriPath());
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    \Greg\Support\Debug::exception($e, $app->debugMode());
}
