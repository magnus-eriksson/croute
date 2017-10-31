<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Controllers/RootController.php';

function dd(...$args)
{
    echo PHP_EOL;
    echo ' ' . PHP_EOL;
    echo PHP_EOL;
    var_dump(...$args);
    echo PHP_EOL;
    echo ' ' . PHP_EOL;
    echo PHP_EOL;
    exit;
}