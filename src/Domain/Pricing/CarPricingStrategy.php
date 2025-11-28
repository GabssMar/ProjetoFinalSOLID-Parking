<?php

declare(strict_types=1);

namespace App\Domain\Pricing;

use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\ParkingPeriod;

final class CarPricingStrategy implements PricingStrategy
{
    private const HOURLY_RATE_CENTS = 500;

    public function calculate(ParkingPeriod $period): Money
    {
        $hours = $period->getBillableHours();

        return new Money($hours * self::HOURLY_RATE_CENTS);
    }
}