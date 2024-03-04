<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    protected AMQPStreamConnection $connection;
    protected AbstractChannel|AMQPChannel $channel;
    protected string $exchange = 'my_exchange';
    protected string $queue = 'my_queue';
    protected string $routingKey = 'my_routing_key';

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );

        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare($this->exchange, 'direct', false, true, false);
        $this->channel->queue_declare($this->queue, false, true, false, false);
    }

    public function publish($message): void
    {
        $this->channel->queue_bind($this->queue, $this->exchange, $message->eventName());

        $msg = new AMQPMessage(json_encode($message));
        $this->channel->basic_publish($msg, $this->exchange, $message->eventName());
    }

    public function consume($callback): void
    {
        $this->channel->basic_consume($this->queue, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
