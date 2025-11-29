<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infra\Banco\FabricaConexao;
use App\Infra\Repositorio\SQLiteSessaoEstacionamentoRepositorio;
use App\Dominio\Precificacao\ServicoPrecificacao;
use App\Dominio\Precificacao\CarroEstrategia;
use App\Dominio\Precificacao\MotoEstrategia;
use App\Dominio\Precificacao\CaminhaoEstrategia;
use App\Aplicacao\Servico\RegistrarSaidaServico;
use App\Aplicacao\DTO\RegistroSaidaRequest;

$placa = $_POST['placa'] ?? '';

try {
    $pdo = FabricaConexao::criar(__DIR__ . '/../banco.db');

    $sessaoRepo = new SQLiteSessaoEstacionamentoRepositorio($pdo);

    $estrategias = [
        new CarroEstrategia(),
        new MotoEstrategia(),
        new CaminhaoEstrategia()
    ];
    $precificacao = new ServicoPrecificacao($estrategias);
    $servico = new RegistrarSaidaServico($sessaoRepo, $precificacao);

    $req = new RegistroSaidaRequest($placa);
    $valor = $servico->executar($req);

    echo "<p>Saída registrada. Valor a pagar: R$ " . number_format($valor, 2, ',', '.') . "</p>";
    echo '<p><a href="saida.php">Voltar</a></p>';
} catch (Throwable $e) {
    echo "<p>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="saida.php">Voltar</a></p>';
}
