<?php
include_once '../../utils/Bdd.php';
include_once '../../../projetLPRS/models/Society.php';
include_once '../../init.php';
include_once '../../utils/flash.php';

//session_start();

class SocietyRepository
{
    // Fonction statique pour inserer une entreprise
    public static function register_society(Society $the_society)
    {
        $my_bdd = Bdd::my_bdd();

        // Vérification de l'email
        $verif_society_mail = $my_bdd->prepare('SELECT mail FROM society WHERE mail = :mail_society');
        $verif_society_mail->execute(['mail_society' => $the_society->get_mail()]);
        $response_data = $verif_society_mail->fetch(PDO::FETCH_ASSOC);

        if (isset($response_data['mail'])) 
        {
            // Flash message en cas d'erreur d'email
            set_flash_message("Ce compte est déjà relié à une adresse mail !", "error");
            header('Location: ../../view/view_business/inscription_business.php');
            exit();
        } 
        else 
        {
            try {
                $mdp_hash = password_hash($the_society->get_password(), PASSWORD_DEFAULT);

                $insert_society = $my_bdd->prepare('INSERT INTO `society`(`nom_society`, `adress_society`, `website`, `mail`, `password`, motif_register, ref_users, nb_view_company) VALUES (:name_society, :adress_society, :website, :mail, :password, :motif_register, :ref_users, :nb)');
                $insert_society->execute([
                    'name_society' => $the_society->get_name_society(),
                    'adress_society' => $the_society->get_adress_society(),
                    'website' => $the_society->get_website(),
                    'mail' => $the_society->get_mail(),
                    'password' => $mdp_hash,
                    'motif_register' => $_POST['motif_register'],
                    'ref_users' => $_SESSION['id_users'],
                    'nb' => 0
                ]);

                // Flash message en cas de succès
                set_flash_message("Votre compte entreprise a été créé !", "success");
                header('Location: ../../view/view_business/connexion_business.php');
                exit();
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    // Fonction statique pour connecter une entreprise
    public static function login_society($mail, $password)
    {
        if (empty($mail) || empty($password)) 
        {
            set_flash_message("Email ou mot de passe incorrect.", "error");
            header('Location: ../../view/view_business/connexion_business.php');
            exit();
        }
        $my_bdd = Bdd::my_bdd();
    
        $req_society = $my_bdd->prepare("SELECT * FROM society WHERE mail = :email_society");
        $req_society->execute(array("email_society" => $mail));
        $society_data = $req_society->fetch(PDO::FETCH_ASSOC);
    
        if ($society_data) 
        {
            if (password_verify($password, $society_data['password'])) 
            {
                if ($_SESSION['id_users'] != $society_data['ref_users']) 
                {
                    set_flash_message("Pour se connecter à cette societé il vous faut le compte associé.", "error");
                    header('Location: ../../view/view_business/connexion_business.php');
                    exit();
                }

                $_SESSION['id_society'] = $society_data['id_society'];
                $_SESSION['nom_society'] = $society_data['nom_society'];
                $_SESSION['website'] = $society_data['website'];
                $_SESSION['ref_users'] = $society_data['ref_users'];

    
                if (isset($society_data['ref_users'])) 
                {
                    $_SESSION['ref_users'] = $society_data['ref_users'];
                }
    
                // Gestion des cookies
                if (isset($_POST['accept_cookies']) && $_POST['accept_cookies'] == 'yes') {
                    setcookie('society_id', $society_data['id_society'], time() + (86400 * 30), "/");
                    setcookie('society_name', $society_data['nom_society'], time() + (86400 * 30), "/");
                }
    
                set_flash_message("Connexion réussie en tant que société !", "success");
                header('Location: ../../view/view_business/accueil_business.php');
                exit();
            } else {
                set_flash_message("Email ou mot de passe incorrect.", "error");
                header('Location: ../../view/view_business/connexion_business.php');
                exit();
            }
        } 
        else 
        {    
            $req_user = $my_bdd->prepare("SELECT * FROM users WHERE mail = :email_user");
            $req_user->execute(array("email_user" => $mail));
            $user_data = $req_user->fetch(PDO::FETCH_ASSOC);
    
            if ($user_data) 
            {
                if (password_verify($password, $user_data['password'])) 
                {
                    $society_id = $user_data['ref_society'];
    
                    $req_society_info = $my_bdd->prepare("SELECT * FROM society WHERE id_society = :society_id");
                    $req_society_info->execute(array('society_id' => $society_id));
                    $society_info = $req_society_info->fetch(PDO::FETCH_ASSOC);
    
                    $_SESSION['id_society'] = $user_data['id_society'];
                    $_SESSION['id_users'] = $user_data['id_users'];
                    $_SESSION['nom'] = $user_data['nom'];
                    $_SESSION['prenom'] = $user_data['prenom'];
                    $_SESSION['email'] = $user_data['mail'];
                    $_SESSION['role'] = $user_data['role']; 
                    $_SESSION['id_society'] = $society_info['id_society'];
                    $_SESSION['nom_society'] = $society_info['nom_society'];
                    $_SESSION['website'] = $society_info['website'];
                    $_SESSION['ref_users'] = $society_info['ref_users'];

    
                    if (isset($user_data['ref_users'])) {
                        $_SESSION['ref_users'] = $user_data['ref_users'];
                    }
    
                    if (isset($_POST['accept_cookies']) && $_POST['accept_cookies'] == 'yes') {
                        setcookie('society_id', $society_id, time() + (86400 * 30), "/");
                        setcookie('society_name', $society_info['nom_society'], time() + (86400 * 30), "/");
                    }
    
                    set_flash_message("Connexion réussie en tant qu'employé !", "success");
                    header('Location: ../../view/view_business/accueil_business.php');
                    exit();
                } else {
                    set_flash_message("Email ou mot de passe incorrect.", "error");
                    header('Location: ../../view/view_business/connexion_business.php');
                    exit();
                }
            } 
            else 
            {
                set_flash_message("Email ou mot de passe incorrect.", "error");
                header('Location: ../../view/view_business/connexion_business.php');
                exit();
            }
        }
    }
    


    // Fonction statique pour modifier une entreprise
    public static function uptade_society()
    {

    }

    // Fonction statique pour afficher le profil d'une entreprise
    public static function my_profil_society($my_data)
    {
        try
        {
            $my_bdd = Bdd::my_bdd();

            $req_findById = $my_bdd->prepare("SELECT `nom_society`, `adress_society`, `website`, `mail` FROM `society` WHERE id_society = :id_society");
            $req_findById->execute(
                array(
                    'id_society' => $_SESSION['id_society']
                )
            );
            $data = $req_findById->fetch(PDO::FETCH_ASSOC);

            if($data)
            {
                return $data[$my_data];
            }
            else
            {
                echo "ERREUR VEUILLEZ CONTACTER LE SUPPORT SVP !";
            }
        }
    catch (PDOException $e) 
        {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }

    public static function edit_my_profil_society($new_name, $new_adress, $new_website)
    {
        try
        {
            $my_bdd = Bdd::my_bdd();

            $req_editById = $my_bdd->prepare("UPDATE `society` SET 
            `nom_society`= :new_name_society ,`adress_society`= :new_adress_society,`website`= :new_website WHERE id_society = :ref_users_society");
            $req_editById->execute(
                array(
                    'new_name_society' => $new_name,
                    'new_adress_society' => $new_adress,
                    'new_website' => $new_website,
                    'ref_users_society' => $_SESSION['id_society']
                )
            );
            $perfect_update = $req_editById;

            if($perfect_update)
            {
                set_flash_message("Votre profil a été mis à jour avec succès !", "success");
                header('Location: ../../view/view_business/modification_profil_business.php');
                exit();
            }
            else
            {
                set_flash_message("Aucune modification apportée. Veuillez vérifier les données.", "warning");
                header('Location: ../../view/view_business/modification_profil_business.php');
                exit();
            }
        }
        catch (PDOException $e) 
        {
            set_flash_message("Erreur lors de la mise à jour du profil : " . $e->getMessage(), "error");
            header('Location: ../../view/view_business/modification_profil_business.php');
            exit();        
        }
    }
    

    // Fonction statique pour supprimer une entreprise
    public static function delete_society()
    {
        try
        {
            $my_bdd = Bdd::my_bdd();

            $delete_society = $my_bdd->prepare("DELETE FROM `society` WHERE id_society = :id");
            $delete_society->execute(
                array(
                    "id" => $_SESSION['id_society']
                )
            );
            $perfect_delete = $delete_society;

            if($perfect_delete)
            {
                session_destroy();
                set_flash_message("Votre compte a été supprimé avec succès.", "success");
                header('Location: ../../view/connexion.php');
                exit();
            }
            else
            {
                set_flash_message("Une erreur est survenue lors de la suppression de votre compte.", "error");
                header('Location: ../../view/view_business/profil_entreprise.php');
                exit();
            }

        }
        catch (PDOException $e) 
        {
            set_flash_message("Erreur lors de la suppression : " . $e->getMessage(), "error");
            header('Location: ../../view/view_business/profil_entreprise.php');
            exit();;
        }
    }

    public static function number_view_profil()
    {
        $my_bdd = Bdd::my_bdd();

        $nb_my_view = $my_bdd->prepare("SELECT nb_view_company  FROM `society` WHERE id_society = :ref_society");
        $nb_my_view->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );
        $data = $nb_my_view->fetch(PDO::FETCH_ASSOC);

        if($data)
        {
            if($data['nb_view_company'] >= 0)
            {                
                return $data['nb_view_company'];
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return "Une erreur est survenue";
        }
    }

    public static function getUserRoleInSociety($userId, $bdd) 
    {
        $query = $bdd->prepare("
            SELECT s.nom_society, sr.role_name 
            FROM society_roles sr
            JOIN society s ON sr.ref_society = s.id_society
            WHERE sr.ref_user = :userId
        ");
        $query->execute(['userId' => $userId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function joinStudentSociety($student_id)
    {
        $my_bdd = Bdd::my_bdd();
        $req_join_student = $my_bdd->prepare("SELECT * FROM users WHERE id_users = :id");
        $req_join_student->execute([':id' => $student_id]);
        $student = $req_join_student->fetch(PDO::FETCH_ASSOC);
    
        if ($student) 
        {
            $id_society = $_SESSION['id_society'];
            $req_join_student = $my_bdd->prepare("
                INSERT INTO society_roles (ref_society, ref_user, role_name) 
                VALUES (:ref_society, :ref_user, 'etudiant')
            ");
            $req_join_student->execute([
            ':ref_society' => $id_society,
            ':ref_user' => $student_id
            ]);

            $req_update_join_student = $my_bdd->prepare("UPDATE users SET ref_society = :ref_society WHERE id_users = :id");
            $req_update_join_student->execute([
              ':ref_society' => $id_society,
               ':id' => $student_id
            ]);
        }
    }

    public static function existJoinStudentSociety($id_society, $student_id)
    {
        $my_bdd = Bdd::my_bdd();
        $reqExistJoinStudentSociety = $my_bdd->prepare("SELECT * FROM society_roles WHERE ref_society = :ref_society AND ref_user = :ref_user");
        $reqExistJoinStudentSociety->execute([':ref_society' => $id_society, ':ref_user' => $student_id]);
        $role = $reqExistJoinStudentSociety->fetch(PDO::FETCH_ASSOC);
        if ($role)
        {
            set_flash_message("Cette utilisateur est déjà parmis vos employés", "error");
            header('Location: ../../view/view_business/accueil_business.php');
            exit();
        }
    }

    public static function getAllSociety()
    {
        $my_bdd = Bdd::my_bdd();
        $req_all_society = $my_bdd->query("SELECT * FROM society where accepted = 1 OR accepted is null");
        return $req_all_society->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSocietyById($id)
    {
        $my_bdd = Bdd::my_bdd();
        $req_society_id = $my_bdd->prepare("SELECT * FROM society WHERE id_society = ? and accepted = 1");
        $req_society_id->execute([$id]);
        return $req_society_id->fetch(PDO::FETCH_ASSOC);
    }

    public static function deleteSocietyAdmin($id_society)
    {
        try {
            $my_bdd = Bdd::my_bdd();

            $delete_society = $my_bdd->prepare("DELETE FROM `society` WHERE id_society = :id");
            $delete_society->execute(array(
                'id' => $id_society
            ));

            if ($delete_society->rowCount() > 0) {
                set_flash_message("L'entreprise a été supprimée avec succès.", "success");
                header('Location: ../../view/view_admin/society_partner.php'); 
                exit();
            } else {
                set_flash_message("Erreur lors de la suppression de l'entreprise. Cette société n'existe peut-être plus.", "error");
                header('Location: ../../view/view_admin/society_partner.php');
                exit();
            }
        } catch (PDOException $e) {
            set_flash_message("Erreur lors de la suppression : " . $e->getMessage(), "error");
            header('Location: ../../view/view_admin/society_partner.php');
            exit();
        }
    }


    public static function rejectOrAcceptedSociety($id, $response)
    {
        $my_bdd = Bdd::my_bdd();
        $update = $my_bdd->prepare("UPDATE `society` SET `accepted`= :response WHERE id_society = :id");
        $update->execute(array( 
            'response' => $response,
            'id' => $id
        ));
    }

    public static function getAllSocietyForUser()
    {
        $my_bdd = Bdd::my_bdd();
        $req_all_society = $my_bdd->query("SELECT * FROM society where accepted = 1");
        return $req_all_society->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addViewSociety($id_society)
    {
        $my_bdd = Bdd::my_bdd();
        $req = $my_bdd->prepare("UPDATE `society` SET `nb_view_company` = nb_view_company + 1 WHERE id_society = :id_society");
        $req->execute(['id_society' => $id_society]);
    }




}