<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

// Traduções dos tipos de veículos
$vehicleTypeLabels = [
    'car' => 'Carro',
    'motorcycle' => 'Moto',
    'truck' => 'Caminhão'
];

$parkings = $repository->all();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Registros de Estacionamento</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 text-slate-800">
  <div class="max-w-6xl mx-auto p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Registros de Estacionamento</h1>
      <a href="create.php"
         class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2 hover:bg-blue-700 transition">
        + Novo Registro
      </a>
    </header>

    <div class="bg-white shadow rounded-xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-slate-100 text-slate-700 text-sm">
            <tr>
              <th class="px-4 py-3">ID</th>
              <th class="px-4 py-3">Placa</th>
              <th class="px-4 py-3">Tipo de Veículo</th>
              <th class="px-4 py-3">Entrada</th>
              <th class="px-4 py-3">Saída</th>
              <th class="px-4 py-3">Preço Total</th>
              <th class="px-4 py-3">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <?php if (empty($parkings)): ?>
              <tr>
                <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                  Nenhum registro encontrado.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($parkings as $p): ?>
                <tr class="hover:bg-slate-50">
                  <td class="px-4 py-3"><?= $p->getId() ?></td>
                  <td class="px-4 py-3"><?= htmlspecialchars((string)$p->getPlate()) ?></td>
                  <td class="px-4 py-3"><?= htmlspecialchars($vehicleTypeLabels[$p->getVehicleType()->value] ?? $p->getVehicleType()->value) ?></td>
                  <td class="px-4 py-3"><?= htmlspecialchars($p->getStartTime()->format('d/m/Y H:i:s')) ?></td>
                  <td class="px-4 py-3">
                    <?= $p->getEndTime() ? htmlspecialchars($p->getEndTime()->format('d/m/Y H:i:s')) : '-' ?>
                  </td>
                  <td class="px-4 py-3 font-semibold">
                    <?php if ($p->getTotalPrice()): ?>
                      R$ <?= number_format($p->getTotalPrice()->getCents() / 100, 2, ',', '.') ?>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                      <a href="edit.php?id=<?= $p->getId() ?>"
                         class="px-3 py-1.5 rounded-md bg-amber-500 text-white text-sm hover:bg-amber-600">Editar</a>
                      <button
                        data-id="<?= $p->getId() ?>"
                        class="btn-delete px-3 py-1.5 rounded-md bg-rose-600 text-white text-sm hover:bg-rose-700">
                        Excluir
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        Swal.fire({
          title: 'Excluir registro?',
          text: 'Esta ação não pode ser desfeita.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sim, excluir',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#6b7280'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'delete.php?id=' + encodeURIComponent(id);
          }
        });
      });
    });
  </script>
</body>
</html>
