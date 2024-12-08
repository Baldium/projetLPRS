<?php
include_once '../../repository/repositorySchumanConnect/ProfilRepository.php';
include_once '../../utils/flash.php';
include_once '../../init.php';

$userId = $_SESSION['id_users']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ProfilRepository::deleteProfil($userId);

    session_destroy();
    set_flash_message("Votre compte a été supprimé avec succès à bientôt chez SchumanConnect", "success");
    header("Location: ../connexion.php"); 
    exit();
}
?>
