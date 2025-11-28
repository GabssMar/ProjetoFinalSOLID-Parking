<?php

require 'vendor/autoload.php';

use App\Infra\Database\Connection;

$pdo = Connection::getInstance();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS parkings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        plate TEXT NOT NULL,
        vehicle_type TEXT NOT NULL,
        start_time TEXT NOT NULL,
        end_time TEXT,
        total_price INTEGER
    );
");

echo 'Banco de dados e tabela criados com sucesso!' . PHP_EOL;