<?php
include '../../error.php';
include '../../repository/repositorySchumanConnect/UserRepository.php';

session_start();


if (isset($_POST['login'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (UserRepository::connexion_users($email, $password)) {
        header("Location: ../../view/view_etudiants/accueil.php");  
        exit();
    } else {

        header("Location: ../../view/view_etudiants/connexion.html");  


        exit();
    }
} 
else 
{
    header("Location: '../../view/view_etudiants/connexion.html"); 
    exit();
}
