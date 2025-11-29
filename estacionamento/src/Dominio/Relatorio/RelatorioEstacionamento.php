<?php

namespace App\Dominio\Relatorio;

use App\Dominio\Entidade\SessaoEstacionamento;
use App\Dominio\Enum\TipoVeiculo;

final class RelatorioEstacionamento
{
    /**
     * @param SessaoEstacionamento[] $sessoes
     */
    public static function consolidar(array $sessoes): array
    {
        $resumo = [
            TipoVeiculo::CARRO->value => ['quantidade' => 0, 'faturamento' => 0.0],
            TipoVeiculo::MOTO->value => ['quantidade' => 0, 'faturamento' => 0.0],
            TipoVeiculo::CAMINHAO->value => ['quantidade' => 0, 'faturamento' => 0.0],
        ];

        foreach ($sessoes as $s) {
            $tipo = $s->tipo()->value;
            $resumo[$tipo]['quantidade']++;
            $resumo[$tipo]['faturamento'] += (float) ($s->valor() ?? 0.0);
        }

        $total = array_sum(array_map(fn($v) => $v['faturamento'], $resumo));

        return [
            'por_tipo' => $resumo,
            'total_geral' => $total
        ];
    }
}
