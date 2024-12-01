<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Bdd
{
    public static function my_bdd()
    {
        try {
            $port = '3306'; 
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=$port;dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            return new PDO($dsn, $username, $password);
        } 
        catch (PDOException $e) 
        {
            // Retourner une réponse JSON avec le message d'erreur
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => "Erreur de connexion à la base de données : " . $e->getMessage()]);
            exit; // Arrêtez l'exécution du script
        }
    }
}

