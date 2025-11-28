<?php

declare(strict_types=1);

namespace App\Infra\Database;

use PDO;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $rootPath = dirname(__DIR__, 3);
            $dbPath = $rootPath . DIRECTORY_SEPARATOR . 'database.sqlite';

            self::$instance = new PDO('sqlite:' . $dbPath);
            
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$instance->exec('PRAGMA foreign_keys = ON;');
        }

        return self::$instance;
    }
}