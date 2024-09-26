<?php
include '../error.php';

include __DIR__ . '/../repository/SocietyRepository.php';
include __DIR__ . '/../models/Society.php';

session_start();

if(isset($_POST['register_society'])) {
    $password_confirm = $_POST['confirm_password'];
    $the_society_register = new Society(
        $_POST['name_society'],
        $_POST['adress_society'],
        $_POST['website_society'],
        $_POST['email_society'],
        $_POST['password']
    );
    
    SocietyRepository::register_society($the_society_register);
}
?>
