<?php

require_once __DIR__ . '/../bootstrap/app.php';

try {
    app()->scope(function (Greg\StaticImage\StaticImageManager $collector) {
        $collector->send(\Greg\Support\Http\Request::uriPath());
    });
} catch (Exception $e) {
    \Greg\Support\Http\Response::sendCode(500);

    dump($e->getMessage(), $e->getTraceAsString());
}
