<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Messenger;

use App\Shared\Domain\Bus\Event\AbstractDomainEvent;
use App\Shared\Domain\Bus\Event\EventBusInterface;
use App\Shared\Infrastructure\Bus\AMQPPublisher;
use App\Shared\Infrastructure\Bus\RabbitMQService;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

final class MessengerEventBus implements EventBusInterface
{
    private RabbitMQService $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new RabbitMQService();
    }

    public function publish(AbstractDomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->publish($event);
            } catch (NoHandlerForMessageException) {
                // TODO optionally throw exception or not
            }
        }
    }
}
