<?php

namespace App\Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpSender;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;

class SenderLocator implements SendersLocatorInterface
{

    public function getSenders(Envelope $envelope): iterable
    {
        // just for simplicity sake...
        $dsn = env('MESSENGER_TRANSPORT_DSN', "");
        $connection = Connection::fromDsn($dsn);

        return [
            'async' => new AmqpSender($connection)
        ];
    }
}
