<?php
ob_start();
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Bdd
{
    public static function my_bdd()
    {
        try {
            // 3306 pour le vps
            $port = '8889'; 
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=$port;dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            return new PDO($dsn, $username, $password);
        } 
        catch (PDOException $e) 
        {
            // Vérification si la sortie est déjà envoyée
            if (headers_sent()) {
                echo "Les en-têtes ont déjà été envoyés avant : " . $e->getMessage();
            } else {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => "Erreur de connexion à la base de données : " . $e->getMessage()]);
            }
            exit; // Arrête l'exécution du script après la gestion de l'erreur
        }
    }
}

ob_end_flush();
?>
