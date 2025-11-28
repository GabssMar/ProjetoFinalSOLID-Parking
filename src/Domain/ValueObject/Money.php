<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class Money
{
    private int $cents;

    public function __construct(int $cents)
    {
        if ($cents < 0) {
            throw new InvalidArgumentException("O valor não pode ser negativo: $cents");
        }
        $this->cents = $cents;
    }

    public static function fromFloat(float $amount): self
    {
        return new self((int) round($amount * 100));
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function multiply(int $multiplier): self
    {
        return new self($this->cents * $multiplier);
    }

    public function __toString(): string
    {
        return 'R$ ' . number_format(($this->cents / 100), 2, ',', '.');
    }
}