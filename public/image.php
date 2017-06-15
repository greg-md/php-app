<?php

/** @var \App\Application $app */
$app = require __DIR__ . '/../app.php';

try {
    $app->scope(function (Greg\StaticImage\StaticImageManager $collector) {
        $collector->send(\Greg\Support\Http\Request::uriPath());
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    dump($e->getMessage(), $e->getTrace());
}
