<?php

namespace App\Dominio\Precificacao;

use App\Dominio\Enum\TipoVeiculo;

final class CarroEstrategia implements EstrategiaPrecificacaoInterface
{
    public function suporta(TipoVeiculo $tipo): bool
    {
        return $tipo === TipoVeiculo::CARRO;
    }

    public function valorHora(): float
    {
        return 5.0;
    }
}
