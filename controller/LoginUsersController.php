<?php

// LoginController.php
include '../error.php';
include '../repository/UserRepository.php';

session_start();


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Appel de la méthode de connexion de l'utilisateur
    if (UserRepository::connexion_users($email, $password)) {
        // Redirection après connexion réussie
        header("Location: ../view/accueil.php");  // Rediriger vers le tableau de bord ou autre page après connexion
        exit();
    } else {
        // Redirection en cas d'échec de connexion
        //header("Location: ../view/connexion.html");  // Ajoute un message d'erreur à la page de connexion
        var_dump($_POST);

        exit();
    }
} else {
    // Si le formulaire n'est pas soumis correctement, renvoyer à la page de connexion
    //header("Location: ../view/connexion.html");  // Ajoute un message d'erreur à la page de connexion
    var_dump($_POST);
    var_dump("test");

    exit();
}
