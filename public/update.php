<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

use App\Domain\Entity\Parking;
use App\Domain\Entity\VehicleType;
use App\Domain\ValueObject\Plate;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\ParkingPeriod;
use App\Domain\Pricing\PricingStrategyFactory;

$id = (int)($_POST['id'] ?? 0);
$errors = [];
$success = false;

try {
    $existing = $repository->getById($id);
    if (!$existing) {
        throw new Exception("Registro não encontrado.");
    }

    $plate = new Plate($_POST['plate'] ?? '');
    $vehicleType = VehicleType::from($_POST['vehicle_type'] ?? '');
    $startTime = new DateTimeImmutable($_POST['start_time'] ?? 'now');
    $endTime = !empty($_POST['end_time']) ? new DateTimeImmutable($_POST['end_time']) : null;
    
    // Calcular preço automaticamente se hora de saída foi fornecida
    $totalPrice = null;
    if ($endTime !== null) {
        $period = new ParkingPeriod($startTime, $endTime);
        $strategy = PricingStrategyFactory::make($vehicleType);
        $totalPrice = $strategy->calculate($period);
    } elseif (!empty($_POST['total_price'])) {
        // Permitir entrada manual de preço se não houver hora de saída
        $totalPrice = new Money((int)(floatval($_POST['total_price']) * 100));
    }
    
    // Create updated parking object
    $parking = Parking::restore(
        $id,
        (string)$plate,
        $vehicleType->value,
        $startTime->format('Y-m-d H:i:s'),
        $endTime?->format('Y-m-d H:i:s'),
        $totalPrice?->getCents()
    );
    
    $repository->update($parking);
    $success = true;
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Atualizar Registro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-xl mx-auto p-6">
    <?php if ($success): ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: 'Registro atualizado com sucesso.',
          confirmButtonColor: '#2563eb'
        }).then(() => { window.location.href = 'index.php'; });
      </script>
    <?php else: ?>
      <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-xl font-semibold mb-3">Erros de validação</h1>
        <ul class="list-disc pl-6 space-y-1 text-rose-700">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-6">
          <a href="edit.php?id=<?= $id ?>" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300">Voltar</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
