<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\CheckOutInputDTO;
use App\Domain\Repository\ParkingRepository;
use App\Domain\Pricing\PricingStrategyFactory;
use App\Domain\ValueObject\ParkingPeriod;
use DateTimeImmutable;
use Exception;

final class CheckOutVehicle
{
    public function __construct(
        private ParkingRepository $repository
    ) {}

    public function execute(CheckOutInputDTO $input): array
    {
        $parking = $this->repository->getById($input->ticketId);

        if (!$parking) {
            throw new Exception("Ticket " . $input->ticketId . " não encontrado.");
        }

        $endTime = new DateTimeImmutable();
        
        $period = new ParkingPeriod($parking->getStartTime(), $endTime);

        $strategy = PricingStrategyFactory::make($parking->getVehicleType());
        $price = $strategy->calculate($period);

        $parking = $parking->close($endTime, $price);

        $this->repository->update($parking);

        return [
            'ticket_id'   => $parking->getId(),
            'plate'       => (string) $parking->getPlate(),
            'total_price' => (string) $price,
            'duration'    => $period->getFormattedDuration(),
            'exit_time'   => $endTime->format('d/m/Y H:i')
        ];
    }
}