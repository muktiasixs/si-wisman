<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
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
} catch (\Throwable $e) {
    echo "<h1>Vercel PHP Error</h1>";
    echo "<pre>" . (string) $e . "</pre>";
}
