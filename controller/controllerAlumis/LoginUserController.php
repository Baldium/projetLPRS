<?php
include '../../init.php';
include_once '../../repository/repositorySchumanConnect/UserRepository.php';
include_once '../../utils/flash.php';

// Login user
if (isset($_POST['login_user'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Appel à la méthode de connexion dans le UserRepository
    $is_authenticated = UserRepository::connexion_user($email, $password);

    if ($is_authenticated) {
        set_flash_message("Vous vous êtes connecté(é) avec succes.", "success");
        header('Location: ../../view/view_etudiants/accueil.php');
        exit();
    } else {
        // Rediriger avec un message d'erreur si la connexion échoue
        set_flash_message("Email ou mot de passe incorrect.", "error");
        header('Location: ../../view/connexion.php');
        exit();
    }
}
?>
