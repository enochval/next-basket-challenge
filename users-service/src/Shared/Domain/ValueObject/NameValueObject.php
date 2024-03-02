<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class NameValueObject
{
    public function __construct(public readonly string $value)
    {
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }
}
