<?php

namespace App\Aplicacao\Servico;

use App\Dominio\Repositorio\SessaoEstacionamentoRepositorioInterface;
use App\Dominio\Relatorio\RelatorioEstacionamento;

final class GerarRelatorioServico
{
    public function __construct(
        private SessaoEstacionamentoRepositorioInterface $sessaoRepo
    ) {}

    public function executar(): array
    {
        $sessoes = $this->sessaoRepo->listarTodas();
        return RelatorioEstacionamento::consolidar($sessoes);
    }
}
