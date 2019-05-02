<?php

namespace App\Utils;

use PDO;
use PDOException;

class Database
{
    /**
     * Try to connect to database.
     *
     * @param array $config
     * @return PDO
     */
    public function connect($config)
    {
        try {
            $connectionString = $config['driver'] .
                ':host=' . $config['host'] .
                ';dbname=' . $config['name'] .
                ';charset=' . $config['charset'];
            $db = new PDO($connectionString, $config['user'], $config['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $error = $_ENV['APP_DEBUG'] === "true" ?
                "Error: " . $e->getMessage() : "Error: Can't connect to database.";
            die($error);
        }

        return $db;
    }
}
