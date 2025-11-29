<?php
declare(strict_types=1);
require __DIR__ . '/_bootstrap.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$success = false;

try {
    $parking = $repository->getById($id);
    if ($parking) {
        $repository->delete($id);
        $success = true;
    }
} catch (Exception $e) {
    $success = false;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Excluir Registro</title>
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
          title: 'Excluído',
          text: 'Registro excluído com sucesso.',
          confirmButtonColor: '#2563eb'
        }).then(() => { window.location.href = 'index.php'; });
      </script>
    <?php else: ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Registro não encontrado.',
          confirmButtonColor: '#2563eb'
        }).then(() => { window.location.href = 'index.php'; });
      </script>
    <?php endif; ?>
  </div>
</body>
</html>
