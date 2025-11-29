<?php

namespace App\Dominio\Precificacao;

use App\Dominio\Enum\TipoVeiculo;
use RuntimeException;

final class ServicoPrecificacao
{
    /**
     * @param EstrategiaPrecificacaoInterface[] $estrategias
     */
    public function __construct(
        private array $estrategias
    ) {}

    public function calcular(TipoVeiculo $tipo, int $horas): float
    {
        foreach ($this->estrategias as $estrategia) {
            if ($estrategia->suporta($tipo)) {
                return $horas * $estrategia->valorHora();
            }
        }

        throw new RuntimeException('Nenhuma estratégia de precificação compatível encontrada.');
    }
}
