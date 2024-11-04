<?php

include '../../models/Prof.php';
include '../../utils/Bdd.php';

class ProfRepository
{
    public static function connexionProf($mail, $password)
    {


        // Connexion à la base de données
        $bdd = Bdd::my_bdd();

        // Préparer et exécuter la requête
        $req = $bdd->prepare("SELECT * FROM prof WHERE mail = :mail");
        $req->execute(array(
            ':mail' => $mail
        ));


        // Récupérer les données
        $user_exist = $req->fetch(PDO::FETCH_ASSOC);

        // Vérification des données de connexion
        if ($user_exist && password_verify($password, $user_exist['mdp'])) {

            // Si la connexion est réussie, définir les sessions
            $_SESSION['id_prof'] = $user_exist['id_prof'];
            $_SESSION['nom'] = $user_exist['nom'];
            $_SESSION['prenom'] = $user_exist['prenom'];
            $_SESSION['mail'] = $user_exist['mail'];
            $_SESSION['matiere'] = $user_exist['matiere'];
            header('Location: ../../view/view_etudiants/accueil.php');
            exit();
        }
        else {
            // Flash message en cas d'erreur
            set_flash_message("Email ou mot de passe incorrect.", "error");
            header('Location: ../../view/view_prof/connexion_prof.php');
            exit();
        }
    }

    public function inscriptionProf($last_name, $first_name, $mail, $password, $matiere)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        try {

            $bdd = Bdd::my_bdd();
            $req = $bdd->prepare("INSERT INTO prof (nom, prenom, mail, mdp, matiere) VALUES (:last_name, :first_name, :mail, :password, :matiere)");
            $req->execute([
                'last_name' => $last_name,
                'first_name' => $first_name,
                'mail' => $mail,
                'password' => $password,
                'matiere' => $matiere
            ]);
            header('Location: ../../view/view_prof/connexion_prof.php');

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }

    }
}