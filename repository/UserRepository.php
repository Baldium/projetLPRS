<?php

include '../models/Users.php';
include '../utils/Bdd.php';

class UserRepository
{
    // CHATGPTEY
    public static function connexion_users($email, $password)
    {
        // Connexion à la base de données
        $pdo = Bdd::my_bdd();
        
        // Préparer la requête pour trouver l'utilisateur par email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Récupérer l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe
        if ($user) {
            // Comparaison du mot de passe sans hachage
            if ($user['password'] == $password) {
                session_start();
                $_SESSION['id_users'] = $user['id_users'];
                $_SESSION['prenom'] = $user['prenom'];
                return true;
            } else {
                // Mot de passe incorrect
                return false;
            }
        } else {
            // Utilisateur non trouvé
            return false;
        }
    }

    // Fonction statique pour inserer un utilisateurs
    public static function register_users()
    {


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
