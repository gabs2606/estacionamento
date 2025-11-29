<?php

namespace App\Dominio\Enum;

enum TipoVeiculo: string
{
    case CARRO = 'carro';
    case MOTO = 'moto';
    case CAMINHAO = 'caminhao';

    public static function fromString(string $value): self
    {
        return match (strtolower($value)) {
            'carro' => self::CARRO,
            'moto' => self::MOTO,
            'caminhao', 'caminhão' => self::CAMINHAO,
            default => throw new \InvalidArgumentException("Tipo inválido: {$value}")
        };
    }
}
