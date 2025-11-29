<?php

namespace App\Dominio\ValorObjeto;

final class Dinheiro
{
    public function __construct(private float $valor) {}

    public function valor(): float
    {
        return round($this->valor, 2);
    }

    public function __toString(): string
    {
        return number_format($this->valor(), 2, ',', '.');
    }
}
