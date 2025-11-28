<?php

declare(strict_types=1);

namespace App\Infra\Repository;

use App\Domain\Entity\Parking;
use App\Domain\Repository\ParkingRepository;
use App\Infra\Database\Connection;
use PDO;

class SqliteParkingRepository implements ParkingRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function save(Parking $parking): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO parkings (plate, vehicle_type, start_time, end_time, total_price)
            VALUES (:plate, :type, :start, :end, :price)s
        ");

        $stmt->execute([
            ':plate' => (string) $parking->getPlate(),
            ':type'  => $parking->getVehicleType()->value,
            ':start' => $parking->getStartTime()->format('Y-m-d H:i:s'),
            ':end'   => $parking->getEndTime()?->format('Y-m-d H:i:s'),
            ':price' => $parking->getTotalPrice()?->getCents()
        ]);
    }

    public function update(Parking $parking): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE parkings 
            SET end_time = :end, total_price = :price 
            WHERE id = :id
        ");

        $stmt->execute([
            ':end'   => $parking->getEndTime()?->format('Y-m-d H:i:s'),
            ':price' => $parking->getTotalPrice()?->getCents(),
            ':id'    => $parking->getId()
        ]);
    }

    public function getById(int $id): ?Parking
    {
        $stmt = $this->pdo->prepare("SELECT * FROM parkings WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    /**
     * @return Parking[]
     */
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM parkings ORDER BY end_time DESC, id DESC");
        $allData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $parkings = [];
        foreach ($allData as $data) {
            $parkings[] = $this->hydrate($data);
        }

        return $parkings;
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM parkings WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    private function hydrate(array $data): Parking
    {
        return Parking::restore(
            (int) $data['id'],
            $data['plate'],
            $data['vehicle_type'],
            $data['start_time'],
            $data['end_time'],
            $data['total_price'] !== null ? (int) $data['total_price'] : null
        );
    }
}