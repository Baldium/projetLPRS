<?php

include '../../models/Users.php';
include '../../utils/Bdd.php';

class UserRepository
{
    public static function connexion_user($email, $password)
    {
        $my_bdd = Bdd::my_bdd();

        $stmt = $my_bdd->prepare("SELECT * FROM users WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user_exist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_exist) {
            if (password_verify($password, $user_exist['password'])) {
                include_once '../../init.php';
                $_SESSION['id_users'] = $user_exist['id_users'];
                $_SESSION['prenom'] = $user_exist['prenom'];
                $_SESSION['nom'] = $user_exist['nom'];
                $_SESSION['mail'] = $user_exist['mail'];
                $_SESSION['role'] = $user_exist['role'];
                $_SESSION['promo'] = $user_exist['promo'];
                $_SESSION['profile_picture'] = $user_exist['profile_picture'];
                $_SESSION['CV'] = $user_exist['CV'];
                $_SESSION['cover_letter'] = $user_exist['cover_letter'];
                $_SESSION['level'] = $user_exist['level'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // Fonction statique pour inserer un utilisateur
    public static function register_user(Users $user)
    {
        $my_bdd = Bdd::my_bdd();

        $verif_user_mail = $my_bdd->prepare('SELECT mail FROM users WHERE mail = :mail');
        $verif_user_mail->execute(['mail' => $user->getMail()]);
        $response_data = $verif_user_mail->fetch(PDO::FETCH_ASSOC);

        if (isset($response_data['mail'])) 
        {
            header('Location: ../../view/inscription.php');
            exit();
        } 
        else 
        {
            try {
                $mdp_hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);

                // Préparation des fichiers pour le stockage en base de données
                $cv_blob = file_get_contents($user->getCv()['tmp_name']);
                $cover_letter_blob = file_get_contents($user->getCoverLetter()['tmp_name']);
                $profile_picture_blob = file_get_contents($user->getProfilPicture()['tmp_name']);

                $insert_society = $my_bdd->prepare('INSERT INTO `users`(
                    `role`, 
                    `promo`, 
                    `nom`, 
                    `prenom`, 
                    `mail`, 
                    `password`, 
                    `CV`, 
                    `cover_letter`, 
                    `profile_picture`, 
                    `level`
                ) VALUES (
                    :roles, 
                    :promo, 
                    :nom, 
                    :prenom, 
                    :mail, 
                    :passworde, 
                    :CV, 
                    :cover_letter, 
                    :profile_picture, 
                    :levele
                )');

                $insert_society->execute([
                    'roles' => $user->getRole(),
                    'promo' => $user->getPromo(),
                    'nom' => $user->getLastName(),
                    'prenom' => $user->getFirstName(),
                    'mail' => $user->getMail(),
                    'passworde' => $mdp_hash,
                    'CV' => $cv_blob,
                    'cover_letter' => $cover_letter_blob,
                    'profile_picture' => $profile_picture_blob,
                    'levele' => $user->getLevel(),
                ]);

                // Flash message en cas de succès
                header('Location: ../../view/connexion.php');
                exit();
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    public function hasAlreadyApplied($userId, $offerId) 
    {
        $my_bdd = Bdd::my_bdd();
        
        $stmt = $my_bdd->prepare('
            SELECT COUNT(*) as count 
            FROM inscription_offers 
            WHERE ref_users = :user_id AND ref_offers = :offer_id
        ');
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0; 
    }


    public function applyToOffer($userId, $offerId, $societyId, $status, $dateInscription) 
    {
        $my_bdd = Bdd::my_bdd();
        
        $insert_inscription_offers = $my_bdd->prepare('INSERT INTO inscription_offers 
        (ref_users, ref_offers, ref_society, statuts_candidat, date_inscriptions) 
        VALUES (:user_id, :offer_id, :society_id, :status, :date_inscription)');
        $insert_inscription_offers->execute(array(
            ':user_id' => $userId,
            ':offer_id' => $offerId,
            ':society_id' => $societyId,
            ':status' => $status,
            ':date_inscription' => $dateInscription
        ));   
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