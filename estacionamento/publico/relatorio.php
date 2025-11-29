<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Infra\Banco\FabricaConexao;
use App\Infra\Repositorio\SQLiteSessaoEstacionamentoRepositorio;
use App\Aplicacao\Servico\GerarRelatorioServico;

$pdo = FabricaConexao::criar(__DIR__ . '/../banco.db');
$sessaoRepo = new SQLiteSessaoEstacionamentoRepositorio($pdo);
$servico = new GerarRelatorioServico($sessaoRepo);
$rel = $servico->executar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Relatório - Estacionamento</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Relatório Consolidado</h1>
      <nav class="text-sm">
        <a href="entrada.php" class="text-blue-600 hover:underline mr-4">Registrar Entrada</a>
        <a href="saida.php" class="text-blue-600 hover:underline">Registrar Saída</a>
      </nav>
    </header>

    <section class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tipo</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Quantidade</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Faturamento (R$)</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          <?php foreach ($rel['por_tipo'] as $tipo => $dados): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars(ucfirst($tipo)); ?></td>
              <td class="px-6 py-4 text-right"><?php echo (int)$dados['quantidade']; ?></td>
              <td class="px-6 py-4 text-right"><?php echo number_format($dados['faturamento'], 2, ',', '.'); ?></td>
            </tr>
          <?php endforeach; ?>

          <tr class="bg-gray-50">
            <td class="px-6 py-4 font-semibold">Total geral</td>
            <td class="px-6 py-4"></td>
            <td class="px-6 py-4 text-right font-semibold"><?php echo number_format($rel['total_geral'], 2, ',', '.'); ?></td>
          </tr>
        </tbody>
      </table>
    </section>

    <footer class="mt-6 text-sm text-gray-500">
      Relatório gerado a partir do histórico de sessões. Valores já estão em reais.
    </footer>
  </div>
</body>
</html>
