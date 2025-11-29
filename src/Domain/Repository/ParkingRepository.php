<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Parking;

interface ParkingRepository
{
    /**
     * @return Parking[]
     */
    public function all(): array;

    public function getById(int $id): ?Parking;

    public function save(Parking $parking): void;

    public function update(Parking $parking): void;

    public function delete(int $id): void;
}