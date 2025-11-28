<?php

declare(strict_types=1);

namespace App\Domain\Pricing;

use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\ParkingPeriod;

interface PricingStrategy
{
    public function calculate(ParkingPeriod $period): Money;
}