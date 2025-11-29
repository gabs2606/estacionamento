<?php

namespace App\Aplicacao\Servico;

use App\Aplicacao\DTO\RegistroSaidaRequest;
use App\Aplicacao\Excecao\SessaoEstacionamentoNaoEncontradaExcecao;
use App\Dominio\Repositorio\SessaoEstacionamentoRepositorioInterface;
use App\Dominio\Precificacao\ServicoPrecificacao;
use DateTimeImmutable;

final class RegistrarSaidaServico
{
    public function __construct(
        private SessaoEstacionamentoRepositorioInterface $sessaoRepo,
        private ServicoPrecificacao $precificacao
    ) {}

    public function executar(RegistroSaidaRequest $request): float
    {
        $placa = strtoupper(trim($request->placa()));
        $sessao = $this->sessaoRepo->buscarAtivaPorPlaca($placa);

        if ($sessao === null) {
            throw new SessaoEstacionamentoNaoEncontradaExcecao('Sessão ativa não encontrada para a placa informada.');
        }

        $entrada = $sessao->entrada();
        $saida = new DateTimeImmutable();

        $segundos = $saida->getTimestamp() - $entrada->getTimestamp();

        // Regras: arredondar para cima (hora cheia). mínimo 1 hora.
        $horas = (int) ceil($segundos / 3600);
        $horas = max(1, $horas);

        $valor = $this->precificacao->calcular($sessao->tipo(), $horas);

        $this->sessaoRepo->finalizarSessao($placa, $saida, $valor);

        return $valor;
    }
}
