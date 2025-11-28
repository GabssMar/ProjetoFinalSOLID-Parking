<?php

declare(strict_types=1);

namespace App\Application\DTO;

readonly class CheckInInputDTO
{
    public function __construct(
        public string $plate,
        public string $vehicleType
    ) {}
}