<?php
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

if (isset($_GET['id'])) 
{
    $id_society = $_GET['id']; 
    SocietyRepository::deleteSocietyAdmin($id_society);
} 
else 
{
    set_flash_message("Aucune société spécifiée pour la suppression.", "error");
    header('Location: ../../view/view_admin/society_partner.php');
    exit();
}
