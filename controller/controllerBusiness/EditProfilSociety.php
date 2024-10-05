<?php
include '../../error.php';
include '../../repository/repositorySchumanConnect/SocietyRepository.php';
require_once '../../utils/flash.php';
display_flash_message();

if(isset($_POST['edit_society']))
{
    // Appel static de la methode edit_my_profil_society
    SocietyRepository::edit_my_profil_society($_POST['nom_society'], $_POST['adress_society'], $_POST['website_society']);
}
else
{
    set_flash_message('Erreur : Aucune soumission détectée.', 'error');
    header('Location: ../../view/view_business/modification_profil_business.php');
    exit();
}