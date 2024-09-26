<?php
include '../error.php';
include '../repository/SocietyRepository.php';

SocietyRepository::login_society($_POST['email_society'], $_POST['password_society']);
?>
