<?php
include '../../repository/repositorySchumanConnect/OffersRepository.php';

if (!isset($_SESSION['id_society'])) {
    set_flash_message("Ne jouez pas au hackeur svp !", "error");
    header("Location: ../connexion.php");
    exit;
}

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id_delete = $_GET['id'];

    $delete_offers = OffersRepository::delete_offers($id_delete);

}
else
{
    echo 'Veuillez ne pas jouer svp !';
}
?>