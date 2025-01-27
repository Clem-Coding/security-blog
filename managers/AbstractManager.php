<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */



require_once 'vendor/autoload.php';  // N'oublie pas d'inclure l'autoloader de Composer

use Dotenv\Dotenv;

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        try {

            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();

            $dbInfo = [
                'user' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                'host' => $_ENV['DB_HOST'],
                'db_name' => $_ENV['DB_NAME'],
            ];


            $connexion = "mysql:host=" . $dbInfo["host"] . ";port=3306;charset=utf8;dbname=" . $dbInfo["db_name"];
            $this->db = new PDO(
                $connexion,
                $dbInfo["user"],
                $dbInfo["password"]
            );

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {

            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
