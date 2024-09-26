<?php
include '../error.php';
include '../repository/SocietyRepository.php';

if(isset($_POST['edit_society']))
{
    SocietyRepository::edit_my_profil_society($_POST['nom_society'], $_POST['adress_society'], $_POST['website_society']);
}
else
{
    echo "Une erreur est survenue !";
}