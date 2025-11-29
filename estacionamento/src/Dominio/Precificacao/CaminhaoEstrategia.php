<?php

namespace App\Dominio\Precificacao;

use App\Dominio\Enum\TipoVeiculo;

final class CaminhaoEstrategia implements EstrategiaPrecificacaoInterface
{
    public function suporta(TipoVeiculo $tipo): bool
    {
        return $tipo === TipoVeiculo::CAMINHAO;
    }

    public function valorHora(): float
    {
        return 10.0;
    }
}
