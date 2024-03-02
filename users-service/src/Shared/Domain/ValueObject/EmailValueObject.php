<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class EmailValueObject
{

    public function __construct(public readonly string $value)
    {
        $this->assertIsValidEmail($value);
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    private function assertIsValidEmail(string $email): void
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $email)
            );
        }
    }
}
