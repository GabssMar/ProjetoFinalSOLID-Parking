<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$id = (int)($_GET['id'] ?? 0);
$parking = $repository->getById($id);
if (!$parking) {
    http_response_code(404);
    echo '<!doctype html><meta charset="utf-8">Registro não encontrado. <a href="index.php">Voltar</a>';
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Editar Registro #<?= $parking->getId() ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-3xl mx-auto p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Editar Registro #<?= $parking->getId() ?></h1>
      <a href="index.php" class="text-blue-700 hover:underline">Voltar</a>
    </header>

    <div class="bg-white shadow rounded-xl p-6">
      <form method="post" action="update.php" class="space-y-5">
        <input type="hidden" name="id" value="<?= $parking->getId() ?>" />

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Placa</label>
          <input name="plate" value="<?= htmlspecialchars((string)$parking->getPlate()) ?>" required
                 class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Tipo de Veículo</label>
          <select name="vehicle_type" required
                  class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
            <?php foreach (['car' => 'Carro', 'motorcycle' => 'Moto', 'truck' => 'Caminhão'] as $value => $label): ?>
              <option value="<?= $value ?>" <?= $value === $parking->getVehicleType()->value ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Hora de Entrada</label>
            <input name="start_time" type="datetime-local" 
                   value="<?= htmlspecialchars($parking->getStartTime()->format('Y-m-d\TH:i')) ?>" required
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Hora de Saída</label>
            <input name="end_time" type="datetime-local" 
                   value="<?= $parking->getEndTime() ? htmlspecialchars($parking->getEndTime()->format('Y-m-d\TH:i')) : '' ?>"
                   class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Preço Total (R$)</label>
          <input name="total_price" type="number" step="0.01" min="0" readonly
                 value="<?= $parking->getTotalPrice() ? number_format($parking->getTotalPrice()->getCents() / 100, 2, '.', '') : '' ?>"
                 class="w-full rounded-lg border-slate-300 bg-slate-100 focus:border-blue-500 focus:ring-blue-500" />
          <p class="text-xs text-slate-500 mt-1">💡 O preço será calculado automaticamente ao definir a hora de saída</p>
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="inline-flex items-center rounded-lg bg-amber-500 text-white px-5 py-2.5 hover:bg-amber-600">
            Atualizar
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
