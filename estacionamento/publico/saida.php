<?php
// saida.php
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Registrar Saída - Estacionamento</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-xl bg-white shadow-md rounded-2xl p-6">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Registrar Saída</h1>
      <nav class="text-sm">
        <a href="entrada.php" class="text-blue-600 hover:underline mr-4">Registrar Entrada</a>
        <a href="relatorio.php" class="text-blue-600 hover:underline">Relatório</a>
      </nav>
    </header>

    <form id="form-saida" action="registrar_saida.php" method="post" class="grid grid-cols-1 gap-4">
      <div>
        <label for="placa" class="block text-sm text-gray-600 mb-1">Placa</label>
        <input id="placa" name="placa" type="text" maxlength="8" placeholder="Ex: ABC1D23" required
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" />
      </div>

      <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
          Registrar Saída
        </button>
        <button type="button" id="limpar-saida" class="px-4 py-3 border rounded-lg text-gray-700 hover:bg-gray-100">
          Limpar
        </button>
      </div>

      <p class="text-sm text-gray-500 mt-2">
        Ao registrar a saída o valor será calculado e exibido em seguida.
      </p>
    </form>
  </div>

  <script src="assets/main.js"></script>
  <script>
    (function () {
      const form = document.getElementById('form-saida');
      const limpar = document.getElementById('limpar-saida');

      form.addEventListener('submit', function (ev) {
        const placa = document.getElementById('placa').value.trim();
        if (!placa) {
          ev.preventDefault();
          Swal.fire({ icon: 'warning', title: 'Placa inválida', text: 'Informe a placa do veículo.' });
          return;
        }

        document.getElementById('placa').value = placa.toUpperCase();

        Swal.fire({
          title: 'Processando saída...',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 900,
          didOpen: () => { Swal.showLoading(); }
        });
      });

      limpar.addEventListener('click', () => { form.reset(); });
    })();
  </script>
</body>
</html>
