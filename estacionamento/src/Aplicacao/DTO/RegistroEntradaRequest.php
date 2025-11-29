<?php

namespace App\Aplicacao\DTO;

use App\Dominio\Enum\TipoVeiculo;

final class RegistroEntradaRequest
{
    public function __construct(
        private string $placa,
        private TipoVeiculo $tipo
    ) {}

    public function placa(): string
    {
        return $this->placa;
    }

    public function tipo(): TipoVeiculo
    {
        return $this->tipo;
    }
}
