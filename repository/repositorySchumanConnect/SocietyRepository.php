<?php
include_once '../../utils/Bdd.php';
include_once '../../../projetLPRS/models/Society.php';
include '../../init.php';
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

                $insert_society = $my_bdd->prepare('INSERT INTO `society`(`nom_society`, `adress_society`, `website`, `mail`, `password`, motif_register, ref_users) VALUES (:name_society, :adress_society, :website, :mail, :password, :motif_register, :ref_users)');
                $insert_society->execute([
                    'name_society' => $the_society->get_name_society(),
                    'adress_society' => $the_society->get_adress_society(),
                    'website' => $the_society->get_website(),
                    'mail' => $the_society->get_mail(),
                    'password' => $mdp_hash,
                    'motif_register' => $_POST['motif_register'],
                    'ref_users' => $_SESSION['id_users']
                ]);

                // Flash message en cas de succès
                set_flash_message("Votre compte entreprise a été créé !", "success");
                header('Location: ../../view/view_business/accueil_business.php');
                exit();
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    // Fonction statique pour connecter une entreprise
    public static function login_society($mail, $password)
    {
        // Vérification des champs vides
        if (empty($mail) || empty($password)) 
        {
            // Flash message en cas d'erreur
            set_flash_message("Email ou mot de passe incorrect.", "error");
            header('Location: ../../view/view_business/connexion_business.php');
            exit();
        }

        // Connexion à la base de données
        $my_bdd = Bdd::my_bdd();

        // Préparer et exécuter la requête
        $req_connect = $my_bdd->prepare("SELECT * FROM society WHERE mail = :email_society");
        $req_connect->execute(array(
            "email_society" => $mail,
        ));
        
        // Récupérer les données
        $data = $req_connect->fetch(PDO::FETCH_ASSOC);

        // Vérification des données de connexion
        if ($data && password_verify($password, $data['password']))
        {
            // Si la connexion est réussie, définir les sessions
            $_SESSION['id_society'] = $data['id_society'];
            $_SESSION['nom_society'] = $data['nom_society'];
            $_SESSION['website'] = $data['website'];
            $_SESSION['ref_users'] = $data['ref_users'];

            // Gestion des cookies
            if (isset($_POST['accept_cookies']) && $_POST['accept_cookies'] == 'yes') 
            {
                setcookie('society_id', $data['id_society'], time() + (86400 * 30), "/");
                setcookie('society_name', $data['nom_society'], time() + (86400 * 30), "/");
            }

            // Flash message en cas de succès
            set_flash_message("Connexion réussie !", "success");
            header('Location: ../../view/view_business/accueil_business.php');
            exit();
        } 
        else 
        {
            // Flash message en cas d'erreur
            set_flash_message("Email ou mot de passe incorrect.", "error");
            header('Location: ../../view/view_business/connexion_business.php');
            exit();
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

            $req_findById = $my_bdd->prepare("SELECT `nom_society`, `adress_society`, `website`, `mail` FROM `society` WHERE ref_users = :ref_users_society");
            $req_findById->execute(
                array(
                    'ref_users_society' => $_SESSION['ref_users']
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

            $delete_society = $my_bdd->prepare("DELETE FROM `society` WHERE ref_users = :ref_users");
            $delete_society->execute(
                array(
                    "ref_users" => $_SESSION['ref_users']
                )
            );
            $perfect_delete = $delete_society;

            if($perfect_delete)
            {
                session_destroy();
                set_flash_message("Votre compte a été supprimé avec succès.", "success");
                header('Location: ../../view/view_etudiants/connexion.html');
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
}