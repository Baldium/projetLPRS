<?php
include '../error.php';

include '../repository/OffersRepository.php';

if(isset($_POST['insert_offers_submit']))
{
    OffersRepository::insert_offers();
}
else
{
    header('Location: ../view/accueil_business.php');
}
?>
