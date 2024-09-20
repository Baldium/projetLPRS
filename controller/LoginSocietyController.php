<?php
include '../error.php';

include __DIR__ . '/../repository/SocietyRepository.php';
include __DIR__ . '/../models/Society.php';
include __DIR__ . '/../models/Bdd.php';

session_start();
SocietyRepository::login_society($_POST['email_society'], $_POST['password_society']);
?>
