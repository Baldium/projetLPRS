<?php
session_start();
include_once '../../repository/repositorySchumanConnect/UserRepository.php';
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
include_once '../../utils/flash.php';

$userRepo = new UserRepository();
$offersRepo = new OffersRepository();

if (!isset($_SESSION['id_users'])) 
{
    header('Location: ../../view/connexion.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $offerId = (int)$_GET['id'];
    $userId = $_SESSION['id_users'];
    
    $societyId = $offersRepo->getSocietyUserIdByOfferId($offerId);
    
    if ($societyId === null) 
    {
        set_flash_message("Aucune entreprise trouvée pour cette offre.", "error");
        header('Location: ../view_etudiants/offres_emplois.php');
        exit();
    }
    if ($userRepo->hasAlreadyApplied($userId, $offerId)) 
    {
        set_flash_message("Vous avez déjà postulé à cette offre.", "error");
        header('Location: ../view_etudiants/offres_emplois.php');
        exit();
    }
    
    $status = null; 
    $dateInscription = date('Y-m-d H:i:s'); 

    $applicationSuccess = $userRepo->applyToOffer($userId, $offerId, $societyId, $status, $dateInscription);

    header('Location: ../view_etudiants/offres_emplois.php');
    exit();
} 
else {
    set_flash_message("ID d'offre invalide.", "error");
    header('Location: ../view_etudiants/offres_emplois.php');
    exit();
}
