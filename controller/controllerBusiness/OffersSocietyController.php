<?php
include '../../error.php';
include '../../repository/repositorySchumanConnect/OffersRepository.php';
require_once '../../utils/flash.php';
display_flash_message();

if(isset($_POST['insert_offers_submit']))
{
    // Appel static de la methode insert_offers
    OffersRepository::insert_offers();
}
else
{
    set_flash_message('Erreur : Aucune soumission détectée.', 'error');
    header('Location: ../../view/view_business/accueil_business.php');
    exit();
}
?>
