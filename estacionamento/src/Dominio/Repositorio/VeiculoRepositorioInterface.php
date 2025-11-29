<?php

namespace App\Dominio\Repositorio;

use App\Dominio\Entidade\Veiculo;
use App\Dominio\Enum\TipoVeiculo;

interface VeiculoRepositorioInterface
{
    public function salvar(string $placa, TipoVeiculo $tipo): Veiculo;

    public function buscarPorPlaca(string $placa): ?Veiculo;
}
