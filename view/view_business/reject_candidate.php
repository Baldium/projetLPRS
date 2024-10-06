<?php
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
//include_once '../../error.php';

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) && isset($_GET['offer_id']) && is_numeric($_GET['offer_id'])) 
{
    $id_reject_candidat_user_id = $_GET['user_id'];
    $id_reject_candidat_offer_id = $_GET['offer_id'];

    $delete_offers = OffersRepository::reject_candidat($id_reject_candidat_user_id, $id_reject_candidat_offer_id);
}
else
{
    echo 'Veuillez ne pas jouer au hacker svp !';
}