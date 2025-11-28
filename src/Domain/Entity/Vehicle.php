<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\VehicleType;
use App\Domain\ValueObject\Plate;

final class Vehicle
{
    public function __construct(
        private Plate $plate,
        private VehicleType $type
    ) {}

    public function getPlate(): Plate
    {
        return $this->plate;
    }

    public function getType(): VehicleType
    {
        return $this->type;
    }
}