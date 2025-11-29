<?php

namespace App\Dominio\Precificacao;

use App\Dominio\Enum\TipoVeiculo;

final class MotoEstrategia implements EstrategiaPrecificacaoInterface
{
    public function suporta(TipoVeiculo $tipo): bool
    {
        return $tipo === TipoVeiculo::MOTO;
    }

    public function valorHora(): float
    {
        return 3.0;
    }
}
