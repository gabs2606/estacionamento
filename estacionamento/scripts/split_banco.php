<?php
declare(strict_types=1);

// Script para dividir banco.sql em arquivos separados por tabela
// Gera arquivos em `var/split_sql/{tabela}.sql`

$raiz = dirname(__DIR__);
$arquivoSql = $raiz . DIRECTORY_SEPARATOR . 'banco.sql';
$outDir = $raiz . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'split_sql';

if (!file_exists($arquivoSql)) {
    echo "Arquivo banco.sql não encontrado em: {$arquivoSql}\n";
    exit(1);
}

$sql = file_get_contents($arquivoSql);
if ($sql === false) {
    echo "Falha ao ler {$arquivoSql}\n";
    exit(1);
}

if (!is_dir($outDir)) {
    if (!mkdir($outDir, 0777, true) && !is_dir($outDir)) {
        echo "Não foi possível criar diretório: {$outDir}\n";
        exit(1);
    }
}

$tables = [];

// Encontrar blocos CREATE TABLE ... ;
preg_match_all('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`\"]?([a-zA-Z0-9_]+)[`\"]?.*?;/is', $sql, $creates, PREG_SET_ORDER);
foreach ($creates as $m) {
    $nome = $m[1];
    $tables[$nome] = ['create' => $m[0], 'inserts' => []];
}

// Encontrar INSERT INTO ... ; e associar por tabela
preg_match_all('/INSERT\s+INTO\s+[`\"]?([a-zA-Z0-9_]+)[`\"]?.*?;/is', $sql, $inserts, PREG_SET_ORDER);
foreach ($inserts as $m) {
    $nome = $m[1];
    if (!isset($tables[$nome])) {
        // Caso não exista CREATE no sql, ainda criaremos um arquivo somente com inserts
        $tables[$nome] = ['create' => null, 'inserts' => []];
    }
    $tables[$nome]['inserts'][] = $m[0];
}

if (count($tables) === 0) {
    echo "Nenhuma tabela identificada no arquivo SQL.\n";
    exit(0);
}

$summary = [];
foreach ($tables as $nome => $data) {
    $outFile = $outDir . DIRECTORY_SEPARATOR . $nome . '.sql';
    $content = "-- Arquivo gerado automaticamente para tabela `{$nome}`\n";
    $content .= "-- Fonte: banco.sql\n\n";
    if ($data['create'] !== null) {
        $content .= $data['create'] . "\n\n";
    }
    if (!empty($data['inserts'])) {
        foreach ($data['inserts'] as $ins) {
            $content .= $ins . "\n";
        }
    }

    file_put_contents($outFile, $content);
    $summary[] = $nome;
}

echo "Arquivos gerados em: {$outDir}\n";
echo "Tabelas processadas: " . implode(', ', $summary) . "\n";

exit(0);
