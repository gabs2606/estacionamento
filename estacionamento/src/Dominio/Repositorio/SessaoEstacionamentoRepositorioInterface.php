<?php

namespace App\Dominio\Repositorio;

use App\Dominio\Entidade\SessaoEstacionamento;
use DateTimeImmutable;

interface SessaoEstacionamentoRepositorioInterface
{
    public function criarSessao(string $placa, DateTimeImmutable $entrada, string $tipo): void;

    public function buscarAtivaPorPlaca(string $placa): ?SessaoEstacionamento;

    public function finalizarSessao(string $placa, DateTimeImmutable $saida, float $valor): void;

    /**
     * Retorna todas as sessoes (finalizadas e ativas) para geração de relatório.
     * @return SessaoEstacionamento[]
     */
    public function listarTodas(): array;
}
