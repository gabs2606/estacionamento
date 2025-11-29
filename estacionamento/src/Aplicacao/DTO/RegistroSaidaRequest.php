<?php

namespace App\Aplicacao\DTO;

final class RegistroSaidaRequest
{
    public function __construct(
        private string $placa
    ) {}

    public function placa(): string
    {
        return $this->placa;
    }
}
