<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

final class ParkingPeriod
{
    public function __construct(
        private DateTimeImmutable $startTime,
        private ?DateTimeImmutable $endTime
    ) {
        if ($endTime < $startTime) {
            throw new InvalidArgumentException("O tempo de encerramento não pode ser anterior ao tempo de início.");
        }
    }

    public function getBillableHours(): int
    {
        $diffInSeconds = $this->endTime->getTimestamp() - $this->startTime->getTimestamp();

        $hours = $diffInSeconds / 3600;

        return (int) ceil($hours);
    }

    public function getFormattedDuration(): string
    {
        $diff = $this->startTime->diff($this->endTime);
        return $diff->format('%h horas e %i minutos');
    }
}