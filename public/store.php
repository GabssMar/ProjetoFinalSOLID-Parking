<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

use App\Domain\Entity\Parking;
use App\Domain\Entity\VehicleType;
use App\Domain\ValueObject\Plate;

$errors = [];
$success = false;

try {
    $plate = new Plate($_POST['plate'] ?? '');
    $vehicleType = VehicleType::from($_POST['vehicle_type'] ?? '');
    $startTime = new DateTimeImmutable($_POST['start_time'] ?? 'now');
    
    $parking = Parking::start($plate, $vehicleType);
    $repository->save($parking);
    
    $success = true;
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Salvar Registro</title>
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
          text: 'Registro criado com sucesso.',
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
        <div class="mt-6 flex gap-3">
          <a href="create.php" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300">Voltar</a>
          <a href="index.php" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Lista</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
