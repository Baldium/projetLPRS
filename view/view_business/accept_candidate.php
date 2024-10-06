<?php
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) && isset($_GET['offer_id']) && is_numeric($_GET['offer_id'])) 
{
    $id_accept_candidat = $_GET['user_id'];
    $id_accept_candidat_ref_offer = $_GET['offer_id'];

    OffersRepository::accept_candidat($id_accept_candidat, $id_accept_candidat_ref_offer);
}
else
{
    echo 'Veuillez ne pas jouer au hacker svp !';
}