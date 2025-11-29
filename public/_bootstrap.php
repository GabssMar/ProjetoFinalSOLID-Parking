<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Configurar fuso horário para Brasil
date_default_timezone_set('America/Sao_Paulo');

use App\Infra\Repository\SqliteParkingRepository;

$repository = new SqliteParkingRepository();
