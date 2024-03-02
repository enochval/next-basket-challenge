<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Messenger;

use App\Shared\Domain\Bus\Event\AbstractDomainEvent;
use App\Shared\Domain\Bus\Event\EventBusInterface;
use App\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use App\Shared\Infrastructure\Bus\SenderLocator;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpSender;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;

final class MessengerEventBus implements EventBusInterface
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
//        $this->bus = new MessageBus(
//            [
//                new HandleMessageMiddleware(
//                    new HandlersLocator(
//                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
//                    )
//                ),
//            ]
//        );

        $this->bus = new MessageBus(
            [
                new SendMessageMiddleware(
                    new SenderLocator()
                )
            ]
        );
    }

    public function publish(AbstractDomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch(new Envelope($event));
            } catch (NoHandlerForMessageException) {
                // TODO optionally throw exception or not
            }
        }
    }
}
