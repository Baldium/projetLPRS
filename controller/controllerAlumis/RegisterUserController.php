<?php
include '../../error.php';

include_once '../../repository/repositorySchumanConnect/UserRepository.php';
include_once '../../../projetLPRS/models/Users.php';




include_once '../../init.php';

if(isset($_POST['register_user'])) 
{
    //$password_confirm = $_POST['confirm_password'];
    // Creation d'une instance de Society
    $the_user_register = new Users(
        $_POST['role'],
        $_POST['promo'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['password'],
        $_FILES['CV'],
        $_FILES['profile_picture'],
        $_FILES['cover_letter'],
        $_POST['level'],
    );
    
    // Appel static de la methode register_society
    UserRepository::register_user($the_user_register);
}
?>
