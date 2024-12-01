<?php

require_once 'models/UserModel.php';
require_once 'vendor/autoload.php'; // Pour Mailjet

use \Mailjet\Resources;

class mdpOublieController
{
    public function resetRequest()
    {
        // Récupérer l'e-mail soumis par le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Vérifier si l'utilisateur existe dans la base de données
            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if ($user) {
                // Générer un jeton sécurisé
                $token = bin2hex(random_bytes(32));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Stocker le jeton dans la base de données
                $userModel->storeResetToken($user['id'], $token, $expiry);

                // Envoyer l'e-mail
                $this->sendResetEmail($email, $token);

                // Afficher un message de succès (rediriger ou inclure une vue)
                echo "Un e-mail de réinitialisation a été envoyé.";
            } else {
                // Gérer le cas où l'utilisateur n'existe pas
                echo "Cet e-mail n'est pas enregistré.";
            }
        }
    }

    private function sendResetEmail($email, $token)
    {
        // Configuration Mailjet
        $mj = new \Mailjet\Client('VOTRE_API_KEY', 'VOTRE_SECRET_KEY', true, ['version' => 'v3.1']);
        $link = "http://votre-site.com/password/reset-form?token=$token";

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "votre_email@mail.com",
                        'Name' => "Votre Site"
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => "Utilisateur"
                        ]
                    ],
                    'Subject' => "Réinitialisation de votre mot de passe",
                    'TextPart' => "Cliquez sur ce lien pour réinitialiser votre mot de passe : $link",
                    'HTMLPart' => "<h3>Réinitialisation de mot de passe</h3><p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p><a href='$link'>Réinitialiser mon mot de passe</a>"
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if (!$response->success()) {
            throw new Exception("Erreur lors de l'envoi de l'e-mail.");
        }
    }
}