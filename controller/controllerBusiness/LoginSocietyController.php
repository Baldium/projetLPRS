<?php
include '../../error.php';
include '../../repository/repositorySchumanConnect/SocietyRepository.php';

// Appel static de la methode login_society
SocietyRepository::login_society($_POST['email_society'], $_POST['password_society']);

?>
