<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\ValueObject\UuidValueObject;
use DateTimeImmutable;

abstract class AbstractDomainEvent
{
    public function __construct(
        public readonly string $aggregateId,
        public ?string $eventId = null,
        public ?string $occurredOn = null
    )
    {
        $this->eventId = $eventId ?? UuidValueObject::random()->value;
        $this->occurredOn = $occurredOn ?? (new DateTimeImmutable())->format('Y-m-d H:i:s.u T');
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;
}
