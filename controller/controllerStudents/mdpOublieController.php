<?php
require 'vendor/autoload.php';
use \Mailjet\Resources;
include_once '../../repository/repositorySchumanConnect/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $user = User::findByEmail($email);

    if ($user) {
        $resetToken = bin2hex(random_bytes(16));
        User::storeResetToken($user['id'], $resetToken);

        $mj = new \Mailjet\Client('bd1e534fe6806cbeecc5175d7ddf6223', 'a9d272be201d1a8c43873cfe7db06fa0', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "zelloufi.soulaimane@gmail.com",
                        'Name' => "Robert Schuman"
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => $user['name']
                        ]
                    ],
                    'Subject' => "Réinitialisation de mot de passe",
                    'TextPart' => "Cliquez sur ce lien pour réinitialiser votre mot de passe : /localhost/projetLPRS/view/reset_password.php?token=$resetToken",
                    'HTMLPart' => "<h3>Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href='/localhost/projetLPRS/view/reset_password.php?token=$resetToken'>Réinitialiser le mot de passe</a></h3>"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()) {
            echo "Un e-mail de réinitialisation a été envoyé.";
        } else {
            echo "Erreur lors de l'envoi de l'e-mail.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet e-mail.";
    }
}
?>