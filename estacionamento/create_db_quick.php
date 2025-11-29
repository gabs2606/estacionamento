<?php
declare(strict_types=1);

// Script rápido para criar banco.db a partir de banco.sql sem usar autoload
$arquivoSql = __DIR__ . DIRECTORY_SEPARATOR . 'banco.sql';
$arquivoDb  = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';

if (!file_exists($arquivoSql)) {
    echo "Arquivo banco.sql não encontrado em: {$arquivoSql}\n";
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $arquivoDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents($arquivoSql);
    if ($sql === false) {
        throw new RuntimeException("Não foi possível ler o arquivo SQL em {$arquivoSql}");
    }

    $pdo->exec($sql);

    echo "Schema criado/atualizado com sucesso em {$arquivoDb}\n";
} catch (Throwable $e) {
    echo "Erro ao criar schema: " . $e->getMessage() . "\n";
    exit(1);
}
