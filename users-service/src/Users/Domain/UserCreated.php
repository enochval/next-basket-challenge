<?php

namespace App\Users\Domain;

use App\Shared\Domain\Bus\Event\AbstractDomainEvent;
use JetBrains\PhpStorm\NoReturn;

class UserCreated extends AbstractDomainEvent
{
    #[NoReturn] public function __construct(
        public readonly string $id,
        public readonly array $body,
        public ?string $eventId = null,
        public ?string $occurredOn = null
    )
    {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId, array $body, string $eventId, string $occurredOn
    ): AbstractDomainEvent
    {
        return new self(
            $aggregateId,
            $body,
            $eventId,
            $occurredOn
        );
    }

    public function eventName(): string
    {
        return 'user.created';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->body['firstName'],
            'lastName' => $this->body['lastName'],
            'email' => $this->body['email'],
        ];
    }
}
