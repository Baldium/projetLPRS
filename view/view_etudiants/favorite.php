<?php
session_start();
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
include_once '../../utils/flash.php';

$offersRepo = new OffersRepository();

if (!isset($_SESSION['id_users'])) 
{
    header('Location: ../../view/connexion.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $offerId = (int)$_GET['id'];
    $userId = $_SESSION['id_users'];

    $addSuccess = $offersRepo->addOfferToFavorites($userId, $offerId);

    header('Location: ../view_etudiants/offres_emplois.php');
    exit();
} else 
{
    set_flash_message("ID d'offre invalide.", "error");
    header('Location: ../view_etudiants/offres_emplois.php');
    exit();
}
?>
