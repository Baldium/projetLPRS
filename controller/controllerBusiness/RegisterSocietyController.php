<?php
include '../../error.php';

include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../../projetLPRS/models/Society.php';


include_once '../../init.php';

if(isset($_POST['register_society'])) 
{
    $password_confirm = $_POST['confirm_password'];
    // Creation d'une instance de Society
    $the_society_register = new Society(
        $_POST['name_society'],
        $_POST['adress_society'],
        $_POST['website_society'],
        $_POST['email_society'],
        $_POST['password']
    );
    
    // Appel static de la methode register_society
    SocietyRepository::register_society($the_society_register);
}
?>
