<?php

include '../../models/Prof.php';
include '../../utils/Bdd.php';

class ProfRepository
{
    public static function connexionProf($mail, $password)
    {
        $bdd = Bdd::my_bdd();

        $req_conn = $bdd->query("SELECT * FROM users WHERE mail = '$mail'");
        $user_exist = $req_conn->fetch(PDO::FETCH_ASSOC);

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