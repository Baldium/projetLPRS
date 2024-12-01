<?php

require __DIR__ . '../../../utils/mailjet.php';
include_once '../../utils/flash.php';
include_once '../../init.php';

// Récupération des données du formulaire 
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

if (!empty($name) && !empty($email) && !empty($message)) 
{
    $subject = "Nouveau message de $name";
    $result = send_email("zelloufi.soulaimane@gmail.com", $subject, $message);
    
    if ($result === true) 
    {
        set_flash_message("Votre message a bien été envoyé.", "success");
    } else {
        set_flash_message("Erreur lors de l'envoi du message", "error");
    }

    header('Location: ../../view/view_etudiants/accueil.php');
    exit(); 
} 
else 
{
    set_flash_message("Tous les champs sont requis.", "error");
    header('Location: ../../view/view_etudiants/accueil.php');
    exit(); 
}
?>
