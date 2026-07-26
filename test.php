<?php
require __DIR__.'/vendor/autoload.php';
$a = require 'bootstrap/app.php';
foreach (get_class_methods($a) as $m) {
    if (stripos($m, 'path') !== false) {
        echo $m . PHP_EOL;
    }
}
