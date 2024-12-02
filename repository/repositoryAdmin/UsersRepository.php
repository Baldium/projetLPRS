<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class UsersRepository
{
    public static function getAllUsersNotAccepted()
    {
        $my_bdd = Bdd::my_bdd();
        $reqGetUsers = $my_bdd->query("SELECT * FROM `users` WHERE accepted IS NULL LIMIT 5");
        $data = $reqGetUsers->fetchAll();
        if($data){
            return $data;
        }
        else {
            return "Aucun nouveaux utilisateurs";
        }
    }

    public static function rejectOrAcceptedCandidat($id, $response)
    {
        $my_bdd = Bdd::my_bdd();
        $update = $my_bdd->prepare("UPDATE `users` SET `accepted`= :response WHERE id_users = :id");
        $update->execute(array( 
            'response' => $response,
            'id' => $id
        ));
    }

    public static function getUsers() {
        $bdd = Bdd::my_bdd();
        $selection = $bdd->prepare("SELECT * FROM users;");
        $selection->execute();
        return $selection->fetchAll();
    }

    public static function getUserById($id) {
        $bdd = Bdd::my_bdd();
        $user = $bdd->prepare("SELECT * FROM users WHERE id_users = :id;");
        $user->execute(array(
            "id" => $id
        ));
        return $user->fetch();
    }

    public static function updateUser($id, $nom, $prenom, $mail, $role, $profile_picture = null) {
        $bdd = Bdd::my_bdd();

        if($profile_picture) {
            $update = $bdd->prepare("UPDATE users SET nom = :nom, prenom = :prenom, mail = :mail, role = :role, profile_picture = :profile_picture WHERE id_users = :id;");
            $update->execute(array(
                "id" => $id,
                "nom" => $nom,
                "prenom" => $prenom,
                "mail" => $mail,
                "role" => $role,
                "profile_picture" => $profile_picture
            ));
        }
        else {
            $update = $bdd->prepare("UPDATE users SET nom = :nom, prenom = :prenom, mail = :mail, role = :role WHERE id_users = :id;");
            $update->execute(array(
                "id" => $id,
                "nom" => $nom,
                "prenom" => $prenom,
                "mail" => $mail,
                "role" => $role
            ));
        }
    }

    public static function deleteUser($id) {
        $bdd = Bdd::my_bdd();
        $delete = $bdd->prepare("DELETE FROM users WHERE id_users = :id;");
        $delete->execute(array(
            "id" => $id
        ));
    }

    public static function getUsersNumber() {
        $bdd = Bdd::my_bdd();
        $count = $bdd->prepare("SELECT COUNT(*) as nbUsers FROM users;");
        $count->execute();
        $nbUsers = $count->fetch();
        return $nbUsers["nbUsers"];
    }

    public static function addUser($nom, $prenom, $email, $password, $role, $promo, $level, $cv, $cover_letter, $profile_picture) {
        $my_bdd = Bdd::my_bdd();

        $verif_user_mail = $my_bdd->prepare('SELECT mail FROM users WHERE mail = :mail');
        $verif_user_mail->execute(['mail' => $email]);
        $response_data = $verif_user_mail->fetch(PDO::FETCH_ASSOC);

        if(isset($response_data['mail'])) {
            throw new Exception("Email déjà utilisé.");
        }

        try {
            $mdp_hash = password_hash($password, PASSWORD_DEFAULT);
            $cv_blob = null;
            $cover_letter_blob = null;
            $profile_picture_blob = null;

            if(isset($cv['tmp_name']) && !empty($cv['tmp_name'])) {
                $cv_blob = file_get_contents($cv['tmp_name']);
            }
            if(isset($cover_letter['tmp_name']) && !empty($cover_letter['tmp_name'])) {
                $cover_letter_blob = file_get_contents($cover_letter['tmp_name']);
            }
            if(isset($profile_picture['tmp_name']) && !empty($profile_picture['tmp_name'])) {
                $profile_picture_blob = file_get_contents($profile_picture['tmp_name']);
            }

            $insert_user = $my_bdd->prepare('
                INSERT INTO `users`(
                    `role`, 
                    `promo`, 
                    `nom`, 
                    `prenom`, 
                    `mail`, 
                    `password`, 
                    `CV`, 
                    `cover_letter`, 
                    `profile_picture`, 
                    `level`,
                    `accepted`
                ) VALUES (
                    :role, 
                    :promo, 
                    :nom, 
                    :prenom, 
                    :mail, 
                    :password, 
                    :CV, 
                    :cover_letter, 
                    :profile_picture, 
                    :level,
                    :accepted
                )
            ');

            $insert_user->execute([
                'role' => $role,
                'promo' => $promo,
                'nom' => $nom,
                'prenom' => $prenom,
                'mail' => $email,
                'password' => $mdp_hash,
                'CV' => $cv_blob,
                'cover_letter' => $cover_letter_blob,
                'profile_picture' => $profile_picture_blob,
                'level' => $level,
                'accepted' => 1
            ]);

        }
        catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
        }
    }

    public static function addAdmin($nom, $prenom, $email, $password, $role, $promo, $level, $cv, $cover_letter, $profile_picture) {
        $my_bdd = Bdd::my_bdd();

        $verif_user_mail = $my_bdd->prepare('SELECT mail FROM users WHERE mail = :mail');
        $verif_user_mail->execute(['mail' => $email]);
        $response_data = $verif_user_mail->fetch(PDO::FETCH_ASSOC);

        if(isset($response_data['mail'])) {
            throw new Exception("Email déjà utilisé.");
        }

        try {
            $mdp_hash = password_hash($password, PASSWORD_DEFAULT);
            $cv_blob = null;
            $cover_letter_blob = null;
            $profile_picture_blob = null;

            if(isset($cv['tmp_name']) && !empty($cv['tmp_name'])) {
                $cv_blob = file_get_contents($cv['tmp_name']);
            }
            if(isset($cover_letter['tmp_name']) && !empty($cover_letter['tmp_name'])) {
                $cover_letter_blob = file_get_contents($cover_letter['tmp_name']);
            }
            if(isset($profile_picture['tmp_name']) && !empty($profile_picture['tmp_name'])) {
                $profile_picture_blob = file_get_contents($profile_picture['tmp_name']);
            }

            $insert_user = $my_bdd->prepare('
                INSERT INTO `users`(
                    `role`, 
                    `promo`, 
                    `nom`, 
                    `prenom`, 
                    `mail`, 
                    `password`, 
                    `CV`, 
                    `cover_letter`, 
                    `profile_picture`, 
                    `level`,
                    `type`,
                    `accepted`
                ) VALUES (
                    :role, 
                    :promo, 
                    :nom, 
                    :prenom, 
                    :mail, 
                    :password, 
                    :CV, 
                    :cover_letter, 
                    :profile_picture, 
                    :level,
                    :type,
                    :accepted
                )
            ');

            $insert_user->execute([
                'role' => $role,
                'promo' => $promo,
                'nom' => $nom,
                'prenom' => $prenom,
                'mail' => $email,
                'password' => $mdp_hash,
                'CV' => $cv_blob,
                'cover_letter' => $cover_letter_blob,
                'profile_picture' => $profile_picture_blob,
                'level' => $level,
                'type' => 1,
                'accepted' => 1
            ]);

        }
        catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
        }
    }
}

?>
