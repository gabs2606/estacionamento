<?php

namespace App\Dominio\Precificacao;

use App\Dominio\Enum\TipoVeiculo;

interface EstrategiaPrecificacaoInterface
{
    public function suporta(TipoVeiculo $tipo): bool;

    public function valorHora(): float;
}
