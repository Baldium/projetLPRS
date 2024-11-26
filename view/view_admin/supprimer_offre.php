<?php
include '../../repository/repositorySchumanConnect/OffersRepository.php';
require_once '../../utils/flash.php';
display_flash_message();

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id_delete = $_GET['id'];

    $delete_offers = OffersRepository::delete_offers_admin($id_delete);

}
else
{
    echo 'Veuillez ne pas jouer svp !';
}
?>