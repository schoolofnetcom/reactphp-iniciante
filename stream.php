<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$source = new React\Stream\Stream(fopen(__DIR__ . '/email.php', 'r'), $loop);
$dest = new React\Stream\Stream(fopen(__DIR__ . '/email-2.php', 'w'), $loop);

$source->pipe($dest);

$loop->run();
