<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class Plate
{
    private string $value;

    public function __construct(string $value)
    {
        $value = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $value));

        if (!$this->isValid($value)) {
            throw new InvalidArgumentException("Placa com caracteres inválidos: $value");
        }

        $this->value = $value;
    }

    private function isValid(string $value): bool
    {
        return preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', $value) === 1;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}