<?php

namespace App\Infra\Banco;

use PDO;

final class FabricaConexao
{
    public static function criar(string $path = __DIR__ . '/../../../banco.db'): PDO
    {
        $pdo = new PDO('sqlite:' . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
