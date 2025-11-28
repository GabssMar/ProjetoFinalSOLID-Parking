<?php

declare(strict_types=1);

namespace App\Application\DTO;

readonly class CheckOutInputDTO
{
    public function __construct(
        public int $ticketId
    ) {}
}
