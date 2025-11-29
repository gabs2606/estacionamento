<?php
$dbFile = __DIR__ . '/../var/database.sqlite';
$sqlFile = __DIR__ . '/../schema.sql';
$pdo = new PDO('sqlite:' . $dbFile);
$schema = file_get_contents($sqlFile);
$pdo->exec($schema);
echo "Schema aplicado\n";
