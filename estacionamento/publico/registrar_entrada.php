<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infra\Banco\FabricaConexao;
use App\Infra\Repositorio\SQLiteVeiculoRepositorio;
use App\Infra\Repositorio\SQLiteSessaoEstacionamentoRepositorio;
use App\Aplicacao\Servico\RegistrarEntradaServico;
use App\Aplicacao\DTO\RegistroEntradaRequest;
use App\Dominio\Enum\TipoVeiculo;

$placa = $_POST['placa'] ?? '';
$tipo = $_POST['tipo'] ?? 'carro';

try {
    $pdo = FabricaConexao::criar(__DIR__ . '/../banco.db');

    $veiculoRepo = new SQLiteVeiculoRepositorio($pdo);
    $sessaoRepo = new SQLiteSessaoEstacionamentoRepositorio($pdo);

    $servico = new RegistrarEntradaServico($veiculoRepo, $sessaoRepo);

    $req = new RegistroEntradaRequest($placa, TipoVeiculo::fromString($tipo));
    $servico->executar($req);

    header('Location: entrada.php?sucesso=1');
    exit;
} catch (Throwable $e) {
    echo "<p>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="entrada.php">Voltar</a></p>';
}
