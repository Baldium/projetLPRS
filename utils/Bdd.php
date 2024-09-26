<?php

// Inclure le fichier autoload de Composer pour charger les classes automatiquement
require __DIR__ . '/../vendor/autoload.php';

// Utilisation de PHP dotenv pour charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Bdd
{
    public static function my_bdd()
    {
        try 
        {
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            return new PDO($dsn, $username, $password);
        } 
        catch (PDOException $e) 
        {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
