<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\VehicleType;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Plate;
use DateTimeImmutable;
use Exception;

final class Parking
{
    private function __construct(
        private ?int $id,
        private Plate $plate,
        private VehicleType $vehicleType,
        private DateTimeImmutable $startTime,
        private ?DateTimeImmutable $endTime = null,
        private ?Money $totalPrice = null
    ) {}

 public static function start(Plate $plate, VehicleType $type): self
    {
        return new self(
            null,
            $plate,
            $type,
            new DateTimeImmutable()
        );
    }

    public static function restore(
        int $id,
        string $plate,
        string $vehicleType,
        string $startTime,
        ?string $endTime,
        ?int $priceCents
    ): self {
        return new self(
            $id,
            new Plate($plate),
            VehicleType::from($vehicleType),
            new DateTimeImmutable($startTime),
            $endTime ? new DateTimeImmutable($endTime) : null,
            $priceCents !== null ? new Money($priceCents) : null
        );
    }

    public function close(DateTimeImmutable $endTime, Money $price): self
    {
        if ($this->endTime !== null) {
            throw new Exception("Este ticket já está fechado.");
        }

        return new self(
            $this->id,
            $this->plate,
            $this->vehicleType,
            $this->startTime,
            $endTime,
            $price
        );
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getPlate(): Plate 
    { 
        return $this->plate;
    }
    public function getVehicleType(): VehicleType 
    { 
        return $this->vehicleType; 
    }

    public function getStartTime(): DateTimeImmutable 
    { 
        return $this->startTime; 
    }

    public function getEndTime(): ?DateTimeImmutable 
    { 
        return $this->endTime; 
    }

    public function getTotalPrice(): ?Money 
    { 
        return $this->totalPrice; 
    }
}
