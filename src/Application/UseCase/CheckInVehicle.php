<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\CheckInInputDTO;
use App\Domain\Entity\Parking;
use App\Domain\Entity\Vehicle;
use App\Domain\Entity\VehicleType;
use App\Domain\Repository\ParkingRepository;
use App\Domain\ValueObject\Plate;

final class CheckInVehicle
{
    public function __construct(
        private ParkingRepository $repository
    ) {}

    public function execute(CheckInInputDTO $input): array
    {
        $plate = new Plate($input->plate);
        $type = VehicleType::from($input->vehicleType);

        $vehicle = new \App\Domain\Entity\Vehicle($plate, $type);

        $parking = Parking::start($vehicle);

        $this->repository->save($parking);

        return [
            'ticket_id' => $parking->id(),
            'plate' => (string) $plate,
            'start_time' => $parking->startTime()->format('d-m-Y H:i')
        ];
    }
}