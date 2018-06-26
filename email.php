<?php

require __DIR__ . '/vendor/autoload.php';

use React\Promise\Deferred;
use React\EventLoop\Factory;
use React\EventLoop\StreamSelectLoop;

class Email
{
    private $loop;

    public function __construct(StreamSelectLoop $loop)
    {
        $this->loop = $loop;
    }

    public function envia(string $email)
    {
        $deferred = new Deferred;

        try {
            $this->enviaEmail($email, $deferred);
        } catch (\Exception $e) {
            $deferred->reject();
        }

        return $deferred->promise();
    }

    public function enviaEmail($email, $deferred)
    {
        $this->loop->addTimer(2, function () use ($email, $deferred) {
            $deferred->resolve($email);
        });
    }
}

$loop = Factory::create();

$email = new Email($loop);

$email->envia('erik@erik.com')
    ->then(function ($email) {
        return 'sucesso... ' . $email .PHP_EOL;
    })
    ->then(function ($data) use ($loop) {
        echo 'MSG: ' . $data;
        $loop->stop();
    })
    ->otherwise(function () {
        echo 'erro'.PHP_EOL;
    });

$loop->addPeriodicTimer(0, function () {
    echo '.';
});

$loop->run();
