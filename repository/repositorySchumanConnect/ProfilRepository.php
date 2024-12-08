<?php
include_once '../../utils/Bdd.php';

class ProfilRepository {
    public static function deleteProfil($id) {
        $my_bdd = Bdd::my_bdd();
        $req_delete = $my_bdd->prepare('DELETE FROM `users` WHERE `id_users` = ?');
        $req_delete->execute([$id]);
    }

    public static function getById($id_user) {
        $my_bdd = Bdd::my_bdd();
        $reqGetUser = $my_bdd->prepare("SELECT * FROM `users` WHERE `id_users` = ?");
        $reqGetUser->execute([$id_user]);
        return $reqGetUser->fetch(PDO::FETCH_ASSOC);
    }

    public static function changePassword($id, $oldPassword, $newPassword) {
        $my_bdd = Bdd::my_bdd();
        
        try {
            $reqCheckPwd = $my_bdd->prepare("SELECT password FROM users WHERE id_users = ?");
            $reqCheckPwd->execute([$id]);
            $user = $reqCheckPwd->fetch(PDO::FETCH_ASSOC);
            
            if (!$user || !password_verify($oldPassword, $user['password'])) {
                return 'Ancien mot de passe incorrect';
            }
    
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_])[A-Za-z\d_]{8,}$/', $newPassword)) {
                return 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial (_).';
            }
    
            if ($oldPassword === $newPassword) {
                return 'Le nouveau mot de passe ne peut pas être identique à l\'ancien.';
            }
    
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $query = "UPDATE `users` SET password = ? WHERE id_users = ?";
            $reqUpdate = $my_bdd->prepare($query);
            $reqUpdate->execute([$hashedPassword, $id]);
    
            return true; 
        } catch (PDOException $e) {
            error_log('Erreur SQL: ' . $e->getMessage());
            return false;
        }
    }
    
    public static function editProfilWithoutPassword($id, $nom, $prenom, $cv, $profilePicture, $coverLetter) {
        $my_bdd = Bdd::my_bdd();
    
        try {
            $query = "UPDATE `users` SET nom = ?, prenom = ?, CV = ?, profile_picture = ?, cover_letter = ? WHERE id_users = ?";
            $reqUpdate = $my_bdd->prepare($query);
            $reqUpdate->execute([
                $nom,
                $prenom,
                $cv,
                $profilePicture,
                $coverLetter,
                $id
            ]);
            return true; 
        } catch (PDOException $e) {
            error_log('Erreur SQL: ' . $e->getMessage());
            return false;
        }
    }
}
?>
