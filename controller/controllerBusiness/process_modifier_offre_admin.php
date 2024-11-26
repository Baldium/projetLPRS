<?php
include '../../repository/repositorySchumanConnect/OffersRepository.php';

if (isset($_POST['edit_offer'])) 
{
    // Recuperation des données avec $_POST
    $id_offers_update = $_POST['id_offers_update'];
    $new_title_offers = $_POST['title_offers'];
    $new_describe_offers = $_POST['describe_offers'];
    $new_mission = $_POST['mission'];
    $new_type_offers = $_POST['type_offers'];
    $new_salary = $_POST['salary'];
    $new_degrees = $_POST['degrees'];
    $new_disponible = $_POST['disponible'];

    // Appel static de la methode update_offers
    OffersRepository::update_offers_admin($id_offers_update, $new_title_offers,$new_describe_offers,$new_mission,
    $new_type_offers,$new_salary,$new_degrees,$new_disponible);
}
?>
