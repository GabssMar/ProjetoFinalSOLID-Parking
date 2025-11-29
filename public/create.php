<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Novo Registro de Estacionamento</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-3xl mx-auto p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Novo Registro</h1>
      <a href="index.php" class="text-blue-700 hover:underline">Voltar</a>
    </header>

    <div class="bg-white shadow rounded-xl p-6">
      <form method="post" action="store.php" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Placa</label>
          <input name="plate" placeholder="ABC-1234" required
                 class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Tipo de Veículo</label>
          <select name="vehicle_type" required
                  class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="car">Carro</option>
            <option value="motorcycle">Moto</option>
            <option value="truck">Caminhão</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Hora de Entrada</label>
          <input name="start_time" type="datetime-local" value="<?= htmlspecialchars(date('Y-m-d\TH:i')) ?>" required
                 class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="inline-flex items-center rounded-lg bg-blue-600 text-white px-5 py-2.5 hover:bg-blue-700">
            Salvar
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
