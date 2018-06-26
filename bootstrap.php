<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$numbers = range(1, 20);

$loop->addPeriodicTimer(7, function () use (&$numbers) {
    echo current($numbers).PHP_EOL;
    next($numbers);
});

$loop->addPeriodicTimer(10, function () use (&$numbers, $loop) {
    if (!current($numbers)) {
        $loop->stop();
    }
});

$loop->addTimer(3, function () {
    echo 'daqui 3 segundos' . PHP_EOL;
});

$loop->run();
