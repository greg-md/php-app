<?php

require __DIR__ . '/../bootstrap/app.php';

try {
    app()->run(function (\App\Http\HttpKernel $kernel) {
        $response = $kernel->run();

        $response->send();
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    dump($e->getMessage(), $e->getTraceAsString());
}
