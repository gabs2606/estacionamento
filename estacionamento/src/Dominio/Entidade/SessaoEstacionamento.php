<?php

namespace App\Dominio\Entidade;

use DateTimeImmutable;
use App\Dominio\Enum\TipoVeiculo;

final class SessaoEstacionamento
{
    public function __construct(
        private string $placa,
        private DateTimeImmutable $entrada,
        private ?DateTimeImmutable $saida,
        private ?float $valor,
        private bool $ativa,
        private TipoVeiculo $tipo
    ) {}

    public function placa(): string { return $this->placa; }
    public function entrada(): DateTimeImmutable { return $this->entrada; }
    public function saida(): ?DateTimeImmutable { return $this->saida; }
    public function valor(): ?float { return $this->valor; }
    public function ativa(): bool { return $this->ativa; }
    public function tipo(): TipoVeiculo { return $this->tipo; }
}
