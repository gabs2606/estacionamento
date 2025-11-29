<?php

$path = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';

$pdo = new PDO('sqlite:' . $path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name IN ('veiculos','sessoes')");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "Arquivo DB: $path\n";
echo "Tabelas encontradas:\n";
var_dump($tables);
