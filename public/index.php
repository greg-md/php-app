<?php

require_once __DIR__ . '/../autoload.php';

try {
    app()->run(function(\Greg\Http\HttpKernel $kernel) {
        $response = $kernel->run();

        $response->send();
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    \Greg\Support\Debug::exception($e, app()->debugMode());
}
