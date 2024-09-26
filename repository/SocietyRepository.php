<?php
session_start();
include '../utils/Bdd.php';
class SocietyRepository
{
    // Fonction statique pour inserer une entreprise
    public static function register_society(Society $the_society)
    {
        $my_bdd = Bdd::my_bdd();

        // Vérification de l'email
        $verif_society_mail = $my_bdd->prepare('SELECT mail FROM Society WHERE mail = :mail_society');
        $verif_society_mail->execute(['mail_society' => $the_society->get_mail()]);
        $response_data = $verif_society_mail->fetch(PDO::FETCH_ASSOC);

        if (isset($response_data['mail'])) {
            echo "Mettre un flash : Ce compte est déjà relié à une adresse mail !";
            exit();
        } else {
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

                echo "Mettre un flash : Votre compte entreprise a été crée !";
                header('Location: ../view/accueil_business.php');
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
            echo "Mettre un flash !";
            header('Location: ../view/connexion_business.html');
            exit();
        }
        $my_bdd = Bdd::my_bdd();

        $req_connect = $my_bdd->prepare("SELECT * FROM Society WHERE mail = :email_society");
        $req_connect->execute(array(
            "email_society" => $mail,
        ));
        $data = $req_connect->fetch(PDO::FETCH_ASSOC);

        if ($data && $data['mail'] == $mail && password_verify($password, $data['password']))
        {
            $_SESSION['id_society'] = $data['id_society'];
            $_SESSION['nom_society'] = $data['nom_society'];
            $_SESSION['ref_users'] = $data['ref_users'];

            if (isset($_POST['accept_cookies']) && $_POST['accept_cookies'] == 'yes') 
            {
                setcookie('society_id', $data['id'], time() + (86400 * 30), "/");
                setcookie('society_name', $data['name_society'], time() + (86400 * 30), "/");
            }
            sleep(1.5);
            header('Location: ../view/accueil_business.php');
            exit();
        } 
        else 
        {
            echo "Mettre un flash : Email ou mot de passe incorrect.";
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
                echo $data[$my_data];
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
            `nom_society`= :new_name_society ,`adress_society`= :new_adress_society,`website`= :new_website WHERE ref_users = :ref_users_society");
            $req_editById->execute(
                array(
                    'new_name_society' => $new_name,
                    'new_adress_society' => $new_adress,
                    'new_website' => $new_website,
                    'ref_users_society' => $_SESSION['ref_users']
                )
            );
            $perfect_update = $req_editById;

            if($perfect_update)
            {
                echo "Modif well done";
                header('Location: ../view/modification_profil_business.php');
            }
            else
            {
                echo "c la merde !";
                header('Location: ../view/modification_profil_business.php');
            }
        }
        catch (PDOException $e) 
        {
            echo "Erreur PDO : " . $e->getMessage();
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
                header('Location: ../view/connexion.html');
                exit();
            }
            else
            {
                echo "Une erreur est survenue";
                header('Location: ../view/profil_entreprise.php');
            }

        }
        catch (PDOException $e) 
        {
            echo "Erreur PDO : " . $e->getMessage();
        }


    }
}