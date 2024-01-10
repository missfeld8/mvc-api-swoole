<?php

$databaseConfig = [
    'host' => 'localhost',
    'user' => 'mateus',
    'password' => 'Mm@#91284025',
    'database' => 'articlesTable',
];

try {
    $db = new PDO(
        "mysql:host={$databaseConfig['host']};dbname={$databaseConfig['database']}",
        $databaseConfig['user'],
        $databaseConfig['password']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Erro no banco de dados: " . $e->getMessage());
    exit("Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Erro: " . $e->getMessage());
    exit("Server Error: " . $e->getMessage());
}
