<?php

namespace App\Infra\Repositorio;

use App\Dominio\Repositorio\SessaoEstacionamentoRepositorioInterface;
use App\Dominio\Entidade\SessaoEstacionamento;
use App\Dominio\Enum\TipoVeiculo;
use DateTimeImmutable;
use PDO;

final class SQLiteSessaoEstacionamentoRepositorio implements SessaoEstacionamentoRepositorioInterface
{
    public function __construct(private PDO $pdo) {}

    public function criarSessao(string $placa, DateTimeImmutable $entrada, string $tipo): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO sessoes (placa, entrada, ativa) VALUES (:placa, :entrada, 1)');
        $stmt->execute([':placa' => $placa, ':entrada' => $entrada->format('Y-m-d H:i:s')]);
    }

    public function buscarAtivaPorPlaca(string $placa): ?SessaoEstacionamento
    {
        $stmt = $this->pdo->prepare('SELECT * FROM sessoes WHERE placa = :placa AND ativa = 1 ORDER BY id DESC LIMIT 1');
        $stmt->execute([':placa' => $placa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        // tipo não está na tabela sessoes; buscar veiculo para obter tipo seria ideal
        // para simplicidade, tentamos inferir do veiculo
        $tipo = TipoVeiculo::fromString($this->buscarTipoVeiculo($placa));
        return new SessaoEstacionamento(
            $row['placa'],
            new DateTimeImmutable($row['entrada']),
            $row['saida'] ? new DateTimeImmutable($row['saida']) : null,
            $row['valor'] !== null ? (float)$row['valor'] : null,
            (bool)$row['ativa'],
            $tipo
        );
    }

    private function buscarTipoVeiculo(string $placa): string
    {
        $stmt = $this->pdo->prepare('SELECT tipo FROM veiculos WHERE placa = :placa');
        $stmt->execute([':placa' => $placa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['tipo'] ?? 'carro';
    }

    public function finalizarSessao(string $placa, DateTimeImmutable $saida, float $valor): void
    {
        $stmt = $this->pdo->prepare('UPDATE sessoes SET saida = :saida, valor = :valor, ativa = 0 WHERE placa = :placa AND ativa = 1');
        $stmt->execute([':saida' => $saida->format('Y-m-d H:i:s'), ':valor' => $valor, ':placa' => $placa]);
    }

    public function listarTodas(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM sessoes ORDER BY id DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $tipo = TipoVeiculo::fromString($this->buscarTipoVeiculo($row['placa']));
            $result[] = new SessaoEstacionamento(
                $row['placa'],
                new DateTimeImmutable($row['entrada']),
                $row['saida'] ? new DateTimeImmutable($row['saida']) : null,
                $row['valor'] !== null ? (float)$row['valor'] : null,
                (bool)$row['ativa'],
                $tipo
            );
        }
        return $result;
    }
}
