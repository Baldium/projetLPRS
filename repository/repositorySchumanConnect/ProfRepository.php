<?php
include_once '../../init.php';
include_once '../../models/Prof.php';
include_once '../../utils/Bdd.php';


class ProfRepository
{
    public static function connexionProf($mail, $password)
    {


        // Connexion à la base de données
        $bdd = Bdd::my_bdd();

        // Préparer et exécuter la requête
        $req = $bdd->prepare("SELECT * FROM users WHERE mail = :mail and role = 'professeur'");
        $req->execute(array(
            ':mail' => $mail
        ));


        // Récupérer les données
        $user_exist = $req->fetch(PDO::FETCH_ASSOC);

        // Vérification des données de connexion
        if ($user_exist && password_verify($password, $user_exist['password'])) {

            // Si la connexion est réussie, définir les sessions
            $_SESSION['id_users'] = $user_exist['id_users'];
            $_SESSION['role'] = $user_exist['role'];
            $_SESSION['nom'] = $user_exist['nom'];
            $_SESSION['prenom'] = $user_exist['prenom'];
            $_SESSION['mail'] = $user_exist['mail'];
            $_SESSION['matiere'] = $user_exist['matiere'];
            header('Location: ../../view/view_etudiants/accueil.php');
            exit();
        }
         /*else {
            // Flash message en cas d'erreur
            set_flash_message("Email ou mot de passe incorrect.", "error");
            header('Location: ../../view/view_prof/connexion_prof.php');
            exit();
        }   */
    }

    public function inscriptionProf($last_name, $first_name, $mail, $password, $matiere)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        try {

            $bdd = Bdd::my_bdd();
            $req = $bdd->prepare("INSERT INTO users (role, nom, prenom, mail, password, matiere) VALUES ('professeur',:last_name, :first_name, :mail, :password, :matiere)");
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

    public static function getProfById ($id) {
        try {
            $bdd = Bdd::my_bdd();
            $req = $bdd->prepare("SELECT nom, prenom, mail, profile_picture FROM users WHERE id_users = :id");
            $req->execute(['id' => $id]);
            $prof = $req->fetch(PDO::FETCH_ASSOC);
            return $prof;

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }


}
