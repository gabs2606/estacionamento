<?php

namespace App\Aplicacao\Servico;

use App\Aplicacao\DTO\RegistroEntradaRequest;
use App\Aplicacao\Excecao\VeiculoJaEstacionadoExcecao;
use App\Dominio\Repositorio\VeiculoRepositorioInterface;
use App\Dominio\Repositorio\SessaoEstacionamentoRepositorioInterface;
use App\Dominio\Entidade\Veiculo;
use DateTimeImmutable;

final class RegistrarEntradaServico
{
    public function __construct(
        private VeiculoRepositorioInterface $veiculoRepo,
        private SessaoEstacionamentoRepositorioInterface $sessaoRepo
    ) {}

    public function executar(RegistroEntradaRequest $request): void
    {
        $placa = strtoupper(trim($request->placa()));

        if ($this->sessaoRepo->buscarAtivaPorPlaca($placa) !== null) {
            throw new VeiculoJaEstacionadoExcecao('Veículo já está estacionado.');
        }

        $veiculo = $this->veiculoRepo->buscarPorPlaca($placa);
        if ($veiculo === null) {
            $this->veiculoRepo->salvar($placa, $request->tipo());
        }

        $this->sessaoRepo->criarSessao($placa, new DateTimeImmutable(), $request->tipo()->value);
    }
}
