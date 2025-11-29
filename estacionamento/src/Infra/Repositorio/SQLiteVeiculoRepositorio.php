<?php

namespace App\Infra\Repositorio;

use App\Dominio\Repositorio\VeiculoRepositorioInterface;
use App\Dominio\Entidade\Veiculo;
use App\Dominio\Enum\TipoVeiculo;
use PDO;

final class SQLiteVeiculoRepositorio implements VeiculoRepositorioInterface
{
    public function __construct(private PDO $pdo) {}

    public function salvar(string $placa, TipoVeiculo $tipo): Veiculo
    {
        $stmt = $this->pdo->prepare('INSERT OR IGNORE INTO veiculos (placa, tipo) VALUES (:placa, :tipo)');
        $stmt->execute([':placa' => $placa, ':tipo' => $tipo->value]);

        return new Veiculo($placa, $tipo);
    }

    public function buscarPorPlaca(string $placa): ?Veiculo
    {
        $stmt = $this->pdo->prepare('SELECT placa, tipo FROM veiculos WHERE placa = :placa');
        $stmt->execute([':placa' => $placa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Veiculo($row['placa'], TipoVeiculo::fromString($row['tipo']));
    }
}
