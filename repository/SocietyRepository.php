<?php

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

                $insert_society = $my_bdd->prepare('INSERT INTO `society`(`nom_society`, `adress_society`, `website`, `mail`, `password`) VALUES (:name_society, :adress_society, :website, :mail, :password)');
                $insert_society->execute([
                    'name_society' => $the_society->get_name_society(),
                    'adress_society' => $the_society->get_adress_society(),
                    'website' => $the_society->get_website(),
                    'mail' => $the_society->get_mail(),
                    'password' => $mdp_hash
                ]);

                echo "Mettre un flash : Votre compte entreprise a été crée !";
                header('Location: ../view/accueil.html');
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
            $_SESSION['society_id'] = $data['id'];
            $_SESSION['nom_society'] = $data['name_society'];
            $_SESSION['society_email'] = $data['mail'];

            if (isset($_POST['accept_cookies']) && $_POST['accept_cookies'] == 'yes') 
            {
                setcookie('society_id', $data['id'], time() + (86400 * 30), "/");
                setcookie('society_name', $data['name_society'], time() + (86400 * 30), "/");
            }
            sleep(1.5);
            header('Location: ../view/accueil_business.html');
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

    // Fonction statique pour afficher une entreprise
    public static function find_society()
    {

    }
    

    // Fonction statique pour supprimer une entreprise
    public static function delete_society()
    {

    }
}