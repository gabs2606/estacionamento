<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infra\Banco\FabricaConexao;

// __DIR__ = .../src/Infra/Migracao
// Queremos a raiz do projeto (pasta onde está composer.json e banco.sql)
$raizProjeto = dirname(__DIR__, 3); // sobe 3 níveis: Migração -> Infra -> src -> raiz do projeto

$arquivoSql = $raizProjeto . DIRECTORY_SEPARATOR . 'banco.sql';
$arquivoDb  = $raizProjeto . DIRECTORY_SEPARATOR . 'banco.db';

if (!file_exists($arquivoSql)) {
    echo "Arquivo banco.sql não encontrado em: {$arquivoSql}\n";
    exit(1);
}

try {
    // Cria/abre o banco.db na raiz do projeto
    // FabricaConexao::criar espera um path opcional
    $pdo = FabricaConexao::criar($arquivoDb);

    $sql = file_get_contents($arquivoSql);
    if ($sql === false) {
        throw new \RuntimeException("Não foi possível ler o arquivo SQL em {$arquivoSql}");
    }

    $pdo->exec($sql);

    echo "Schema criado/atualizado com sucesso em {$arquivoDb}\n";
} catch (Throwable $e) {
    echo "Erro ao criar schema: " . $e->getMessage() . "\n";
    exit(1);
}
