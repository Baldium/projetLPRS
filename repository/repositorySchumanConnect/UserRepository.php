<?php

include '../../models/Users.php';
include '../../utils/Bdd.php';

class UserRepository
{
    public static function connexion_users($email, $password)
    {
        // Connexion à la base de données
        $pdo = Bdd::my_bdd();
        
        // Préparer la requête pour trouver l'utilisateur par email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Récupérer l'utilisateur
        $user_exist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_exist) {
            // Comparer le mot de passe
            if ($user_exist['password'] == $password) {
                session_start();
                $_SESSION['id_users'] = $user_exist['id_users'];
                $_SESSION['prenom'] = $user_exist['prenom'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Fonction statique pour inserer un utilisateurs
    public static function register_users()
    {

        //En cours
    }

    // Fonction statique pour modifier un utilisateur
    public static function uptade_users()
    {

    }

    // Fonction statique pour supprimer un utilisateur
    public static function delete_users()
    {

    }
}