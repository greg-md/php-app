<?php

/**
 * @var $app \Greg\ApplicationStrategy
 */
$app = require __DIR__ . '/../autoload.php';

try {
    $app->run(function(\Greg\Http\HttpKernelStrategy $kernel) {
        $response = $kernel->run();

        $response->send();
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    \Greg\Support\Debug::exception($e, $app->debugMode());
}
