<?php

declare(strict_types=1);

namespace App\Domain\Pricing;

use App\Domain\Pricing\CarPricingStrategy;
use App\Domain\Pricing\MotorcyclePricingStrategy;
use App\Domain\Pricing\PricingStrategy;
use App\Domain\Pricing\TruckPricingStrategy;
use App\Domain\Entity\VehicleType;

final class PricingStrategyFactory
{
    public static function make(VehicleType $type): PricingStrategy
    {
        return match ($type) {
            VehicleType::CAR => new CarPricingStrategy(),
            VehicleType::MOTORCYCLE => new MotorcyclePricingStrategy(),
            VehicleType::TRUCK => new TruckPricingStrategy(),
        };
    }
}