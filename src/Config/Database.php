<?php

namespace Root\MvcApi\Config;

use Exception;
use PDO;
use PDOException;

class Database
{

    private PDO $pdo;

    public function __construct()
    {
        $databaseConfig = [
            'host' => $_ENV['db_host'],
            'user' => $_ENV['db_user'],
            'password' => $_ENV['db_password'],
            'database' => $_ENV['db_database'],
        ];
        try {
            $db = new PDO(
                "mysql:host={$databaseConfig['host']};dbname={$databaseConfig['database']}",
                $databaseConfig['user'],
                $databaseConfig['password']
            );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $db;
        } catch (PDOException $e) {
            error_log("Erro no banco de dados: " . $e->getMessage());
            exit("Erro no banco de dados: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("Erro: " . $e->getMessage());
            exit("Server Error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
