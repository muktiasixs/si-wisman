<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$storage = '/tmp/storage';
$app->useStoragePath($storage);

$directories = [
    $storage.'/framework/cache/data',
    $storage.'/framework/views',
    $storage.'/framework/sessions',
    $storage.'/logs'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

$app->handleRequest(Illuminate\Http\Request::capture());
