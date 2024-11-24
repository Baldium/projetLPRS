<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function send_email($to_email, $subject, $message)
{
    $api_key = $_ENV['DB_API_KEY'];
    $api_secret = $_ENV['DB_SECRET_KEY'];

    $data = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "zelloufi.soulaimane@gmail.com",
                    'Name' => "SchumanConnect | Emplois"
                ],
                'To' => [
                    [
                        'Email' => $to_email,
                        'Name' => "Candidat"
                    ]
                ],
                'Subject' => $subject,
                'TextPart' => strip_tags($message),
                'HTMLPart' => "<h3>" . nl2br(htmlspecialchars($message)) . "</h3>",
                'CustomID' => "AppGettingStartedTest"
            ]
        ]
    ];

    // Initialisation de cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pour récupérer la réponse sous forme de chaîne
    curl_setopt($ch, CURLOPT_POST, true); // Requête POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Envoyer les données
    curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret"); // Authentification
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json" // Type de contenu
    ]);

    // Exécution de la requête cURL
    $result = curl_exec($ch);

    // Gestion des erreurs cURL
    if (curl_errno($ch)) {
        return 'Erreur cURL : ' . curl_error($ch);
    } else {
        // Récupération du code HTTP de la réponse
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 200) {
            return true; // Email envoyé avec succès
        } else {
            return "Code HTTP: $http_code. Réponse de Mailjet : $result";
        }
    }

    // Fermeture de la connexion cURL
    curl_close($ch);
}

?>
