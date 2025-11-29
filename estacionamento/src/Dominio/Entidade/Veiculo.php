<?php

namespace App\Dominio\Entidade;

use App\Dominio\Enum\TipoVeiculo;

final class Veiculo
{
    private string $placa;
    private TipoVeiculo $tipo;

    public function __construct(string $placa, TipoVeiculo $tipo)
    {
        $placa = strtoupper(trim($placa));
        if ($placa === '') {
            throw new \InvalidArgumentException('Placa inválida.');
        }

        $this->placa = $placa;
        $this->tipo = $tipo;
    }

    public static function fromStrings(string $placa, string $tipo): self
    {
        $tipoEnum = TipoVeiculo::fromString($tipo);
        return new self($placa, $tipoEnum);
    }

    public function placa(): string
    {
        return $this->placa;
    }

    public function tipo(): TipoVeiculo
    {
        return $this->tipo;
    }
}
