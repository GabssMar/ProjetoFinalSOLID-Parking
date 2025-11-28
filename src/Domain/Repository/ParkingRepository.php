<?php

declare(strict_types=1);

namespace App\Domain;

interface ParkingRepository
{
    /**
     * @return Parking[]
     */
    public function all(): array;

    public function getById(int $id): ?Parking;

    public function save(Parking $parking): Parking;

    public function update(Parking $parking): void;

    public function delete(int $id): void;
}