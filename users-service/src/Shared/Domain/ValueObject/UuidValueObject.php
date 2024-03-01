<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;
use Ramsey\Uuid\Uuid;

class UuidValueObject
{
    public function __construct(public readonly string $value)
    {
        $this->assertIsValidUuid($value);
    }

    public static function fromValue(string $value): UuidValueObject
    {
        return new self($value);
    }

    public static function random(): UuidValueObject
    {
        return new self(Uuid::uuid4()->toString());
    }

    private function assertIsValidUuid(string $uuid): void
    {
        if (! Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException(
                sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $uuid)
            );
        }
    }
}
