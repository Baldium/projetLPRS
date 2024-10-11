<?php
include_once '../../utils/Bdd.php';
include_once '../../models/Offers.php';
include_once '../../utils/mailjet.php';
include '../../init.php';
include_once '../../utils/flash.php';

//session_start();

class OffersRepository
{
    // Fonction pour afficher les offres des entreprises 
    public static function find_offers()
    {

    }

    // Fonction pour les dernieres offres de l'entreprise
    public static function find_offers_by_desc()
    {
        $my_bdd = Bdd::my_bdd();

        $req_find_offers_by_desc = $my_bdd->prepare(" SELECT id_offers, title_offers, type_offers, degrees, disponible 
        FROM `offers` WHERE ref_society = :ref_society ORDER BY id_offers DESC LIMIT 3");
        $req_find_offers_by_desc->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );
        $data = $req_find_offers_by_desc->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            echo '<table class="appointments-table">';
            echo '<thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contrat</th>
                        <th>Diplome</th>
                        <th>Statut</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            foreach ($data as $element) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($element['title_offers']) . '</td>';  
                echo '<td>' . htmlspecialchars($element['type_offers']) . '</td>';   
                echo '<td>' . htmlspecialchars($element['degrees']) . '</td>';       
                
                echo '<td>' . ($element['disponible'] == 1 ? 'Ouvert ✅' : 'Fermé ❌') . '</td>';
                
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucune offre disponible.</p>';
        }
    }

    // Fonction pour afficher le nb entier d'offres d'une entreprise
    public static function find_all_offers_by_company()
    {
        $my_bdd = Bdd::my_bdd();

        $req_find_offers = $my_bdd->prepare("SELECT * FROM offers WHERE ref_society = :ref_society");
        $req_find_offers->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );

        $data = $req_find_offers->fetchAll(PDO::FETCH_ASSOC);

        if ($data) 
        {
            echo '<div class="offers-container">';
            foreach ($data as $element) 
            {
                echo '<div class="offer-card">';
                echo '<h3 class="offer-title">' . htmlspecialchars($element['title_offers']) . '</h3>'; 
                echo '<p class="offer-description"><strong>Description :</strong> ' . htmlspecialchars($element['describe_offers']) . '</p>';  
                echo '<p><strong>Mission :</strong> ' . htmlspecialchars($element['mission'] ?? 'Non spécifiée') . '</p>';  
                echo '<p><strong>Contrat :</strong> ' . htmlspecialchars($element['type_offers']) . '</p>';  
                echo '<p><strong>Salaire :</strong> ' . ($element['salary'] ? htmlspecialchars($element['salary']) . ' €' : 'Non spécifié') . '</p>';  
                echo '<p><strong>Diplôme requis :</strong> ' . htmlspecialchars($element['degrees']) . '</p>';  
                echo '<p><strong>Cible :</strong> ' . htmlspecialchars($element['target_offers']) . '</p>';  
                echo '<p><strong>Status :</strong> ' . ($element['disponible'] == 1 ? 'Ouvert ✅' : 'Fermé ❌') . '</p>';
                echo '<p class="offer-description"> <stron></strong> <i class="fas fa-eye"></i> ' . htmlspecialchars($element['view']) . '</p>';

                echo '<div class="offer-actions">';
                echo '<a href="candidats_business.php?id=' . htmlspecialchars($element['id_offers']) . '" class="btn modify-btn">Voir les Candidats</a>';
                echo '</div>';
                echo '<div class="offer-actions">';
                echo '<a href="modifier_offre.php?id=' . htmlspecialchars($element['id_offers']) . '" class="btn modify-btn">Modifier</a>';
                echo '<a href="supprimer_offre.php?id=' . htmlspecialchars($element['id_offers']) . '" class="btn delete-btn">Supprimer</a>';
                echo '</div>';

                echo '</div>';  
            }
            echo '</div>';  
        } else 
        {
            echo '<p>Aucune offre trouvée pour cette entreprise.</p>';
        }
    }




    // Fonction pour afficher le nombre d'offres d'une entreprises 
    public static function number_offers()
    {
        $my_bdd = Bdd::my_bdd();

        $nb_my_offers = $my_bdd->prepare("SELECT COUNT(*)AS nb_offers FROM `offers` WHERE ref_society = :ref_society");
        $nb_my_offers->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );
        $data = $nb_my_offers->fetch(PDO::FETCH_ASSOC);

        if($data)
        {
            if($data['nb_offers'] <= 0)
            {                
                return $data['nb_offers'];
            }
            else
            {
                return $data['nb_offers'];
            }
        }
        else
        {
            return "Une erreur est survenue";
        }

    }


    // Fonction pour inserer une offre 
    public static function insert_offers()
    {
        try
        {
            $my_bdd = Bdd::my_bdd();
            
            $offers = new Offers($_POST['title_offers'], $_POST['description'], $_POST['mission'],$_POST['type_offers'], $_POST['salaire'],
            $_POST['niveau-etudes'], $_POST['filiere'], 1);
            $req_insert_offers = $my_bdd->prepare('INSERT INTO offers (title_offers, describe_offers, mission, type_offers, salary, degrees, target_offers, 
            disponible, view, ref_society, date_created) VALUES (:title_offers, :describe_offers, :mission, :type_offers, :salary, :degrees, :target_offers, :disponible, :view, :ref_society, :date_created)');
            $perfet_insert = $req_insert_offers->execute(array(
                'title_offers' => $offers->get_title_offers(),
                'describe_offers' => $offers->get_describe_offers(),
                'mission' => $offers->get_mission(),
                'type_offers' => $offers->get_type_offers(),
                'salary' => $offers->get_salary(),
                'degrees' => $offers->get_degrees(),
                'target_offers' => $offers->get_target_offers(),
                'disponible' => $offers->get_disponible(),
                'view' => 0,
                'ref_society' => $_SESSION['id_society'],
                'date_created' => date('Y-m-d') // Format ISO 8601 (YYYY-MM-DD)
            ));
            if($perfet_insert)
            {
                set_flash_message("L'offre a été ajoutée avec succès.", "success");
                header('Location: ../../view/view_business/accueil_business.php');
                exit();
            }
            else
            {
                set_flash_message("Une erreur est survenue lors de l'ajout de l'offre.", "error");
                header('Location: ../../view/view_business/accueil_business.php');
                exit();
            }

        }
        catch (PDOException $e) 
        {
            set_flash_message("Erreur PDO : " . $e->getMessage(), "error");
            header('Location: ../../view/view_business/accueil_business.php');
            exit();
        }
    }

    // Fonction pour modifier une offre
    public static function update_offers($id_offers_update, $new_title_offers, $new_describe_offers, $new_mission, $new_type_offers, $new_salary, $new_degrees, $new_disponible)
    {
        $my_bdd = Bdd::my_bdd();

        $req_update = $my_bdd->prepare('UPDATE offers SET title_offers = :new_title_offers,
        describe_offers = :new_describe_offers , mission = :new_mission ,type_offers = :new_type_offers ,
        salary = :new_salary, degrees = :new_degrees , disponible = :new_disponible
        WHERE id_offers = :id_offers_update');
        $req_update->execute(array(
            'new_title_offers' => $new_title_offers,
            'new_describe_offers' => $new_describe_offers,
            'new_mission' => $new_mission,
            'new_type_offers' => $new_type_offers,
            'new_salary' => $new_salary,
            'new_degrees' => $new_degrees,
            'new_disponible' => $new_disponible,
            'id_offers_update' => $id_offers_update
        ));
        $perfet_update = $req_update;

        if($perfet_update)
        {
            set_flash_message("L'offre a été mise à jour avec succès.", "success");
            header('Location: ../../view/view_business/mes_offres_business.php');
            exit();

        }
        else
        {
            set_flash_message("Une erreur est survenue lors de la mise à jour de l'offre.", "error");
            header('Location: ../../view/view_business/mes_offres_business.php');
            exit();
        }
    }

    // Fonction pour supprimer une offre
    public static function delete_offers($id_offers)
    {
        $my_bdd = Bdd::my_bdd();

        $req_delete = $my_bdd->prepare('DELETE FROM `offers` WHERE id_offers = :this_id');
        $req_delete->execute(array(
            "this_id" => $id_offers
        ));
        $perfet_delete = $req_delete;

        if($perfet_delete)
        {
            set_flash_message("L'offre a été supprimée avec succès.", "success");
            header('Location: ../../view/view_business/mes_offres_business.php');
            exit();

        }
        else
        {
            set_flash_message("Une erreur est survenue lors de la suppression de l'offre.", "error");
            header('Location: ../../view/view_business/mes_offres_business.php');
            exit();
        }
    }

    public static function find_offer_by_id($id_offers)
    {
        $my_bdd = Bdd::my_bdd();

        $req_by_id = $my_bdd->prepare('SELECT * FROM offers WHERE id_offers = :id_offers');
        $req_by_id->execute(array(
             'id_offers' => $id_offers
        ));
        return $req_by_id->fetch(PDO::FETCH_ASSOC);
    }

    public static function find_nb_offers_postule()
    {
        $my_bdd = Bdd::my_bdd();

        $req_nb_postule = $my_bdd->prepare("SELECT COUNT(*) as nb_post_offers FROM `inscription_offers` WHERE ref_society = :ref_users");
        $req_nb_postule->execute(array(
            "ref_users" => $_SESSION['ref_users']
        ));
        $data = $req_nb_postule->fetch(PDO::FETCH_ASSOC);

        return $data['nb_post_offers'];
    }


     // Fonction pour voir les candidats d'une offre spécifique
     public static function find_all_candidates_by_offer($id_offer)
    {
        $my_bdd = Bdd::my_bdd();

        $req_find_candidats = $my_bdd->prepare("SELECT i.ref_users, i.ref_offers, i.statuts_candidat, u.* 
            FROM inscription_offers i JOIN users u ON i.ref_users = u.id_users 
            WHERE i.ref_offers = :ref_offers AND (i.statuts_candidat = :accepted OR i.statuts_candidat IS NULL)");

        $req_find_candidats->execute(array(
            'ref_offers' => $id_offer,
            'accepted' => 1,
        ));

        return $req_find_candidats->fetchAll(PDO::FETCH_ASSOC);
    }



    public static function reject_candidat($id_ref_users, $id_ref_offers)
    {
        $my_bdd = Bdd::my_bdd();

        $req_reject = $my_bdd->prepare("UPDATE `inscription_offers` SET `statuts_candidat`= :new_statuts WHERE ref_users = :ref_users AND ref_offers = :ref_offers");
        $req_reject->execute(array(
            'new_statuts' => 0,
            'ref_users' => $id_ref_users,
            'ref_offers' => $id_ref_offers
        ));

        $req_select_for_email = $my_bdd->prepare("SELECT u.mail AS user_mail, s.mail AS society_mail, o.*, u.*, s.*
            FROM inscription_offers AS i 
            INNER JOIN users AS u ON i.ref_users = u.id_users 
            INNER JOIN offers AS o ON i.ref_offers = o.id_offers 
            INNER JOIN society AS s ON s.ref_users = i.ref_society   
            WHERE i.ref_users = :ref_user AND i.ref_offers = :ref_offer");
        $req_select_for_email->execute(array(
            "ref_user" => $id_ref_users,
            "ref_offer" =>  $id_ref_offers
        ));
        $data_for_mail = $req_select_for_email->fetch(PDO::FETCH_ASSOC);

        if($data_for_mail) 
        {
            $email = $data_for_mail['user_mail']; 
            $subject = 'Retour sur votre candidature';
            $message = 'Bonjour ' . htmlspecialchars($data_for_mail['prenom']) . ',

            Nous vous remercions pour l\'intérêt porté à ' . htmlspecialchars($data_for_mail['nom_society']) . '.
            
            Nous avons bien reçu votre candidature pour le poste de ' . htmlspecialchars($data_for_mail['title_offers']) . ' (' . htmlspecialchars($data_for_mail['type_offers']) . '), mais malheureusement, ce poste vient d\'être pourvu.
            
            Nous vous informons, sauf avis contraire de votre part, que nous allons conserver votre dossier. N’hésitez pas à visiter régulièrement notre site ' . htmlspecialchars($data_for_mail['website']) . ' afin de consulter nos futures opportunités.

            Nous vous souhaitons une bonne continuation dans vos recherches et espérons qu\'elles puissent aboutir rapidement.

            Cordialement,

            L\'équipe Recrutement ' . htmlspecialchars($data_for_mail['nom_society']);


            send_email($email, $subject, $message);


            set_flash_message("La candidature a été rejetée et l'email a été envoyé avec succès.", "success");
            header('Location: ../../view/view_business/mes_offres_business.php');
        } else 
        {
            set_flash_message("Une erreur est survenue lors du rejet de la candidature.", "error");
            header('Location: ../../view/view_business/mes_offres_business.php');
        }
    }

    public static function accept_candidat($id_ref_users, $id_ref_offers)
    {
        $my_bdd = Bdd::my_bdd();

        $req_reject = $my_bdd->prepare("UPDATE `inscription_offers` SET `statuts_candidat`= :new_statuts WHERE ref_users = :ref_users AND ref_offers = :ref_offers");
        $req_reject->execute(array(
            'new_statuts' => 1,
            'ref_users' => $id_ref_users,
            'ref_offers' => $id_ref_offers
        ));

        $req_select_for_email = $my_bdd->prepare("SELECT u.mail AS user_mail, s.mail AS society_mail, o.*, u.*, s.*
            FROM inscription_offers AS i 
            INNER JOIN users AS u ON i.ref_users = u.id_users 
            INNER JOIN offers AS o ON i.ref_offers = o.id_offers 
            INNER JOIN society AS s ON s.ref_users = i.ref_society   
            WHERE i.ref_users = :ref_user AND i.ref_offers = :ref_offer");
        $req_select_for_email->execute(array(
            "ref_user" => $id_ref_users,
            "ref_offer" =>  $id_ref_offers
        ));
        $data_for_mail = $req_select_for_email->fetch(PDO::FETCH_ASSOC);

        if($data_for_mail) 
        {
            $email = $data_for_mail['user_mail']; 
            $subject = 'Retour sur votre candidature';
            $message = 'Bonjour ' . htmlspecialchars($data_for_mail['prenom']) . ',

            Nous vous remercions pour l\'intérêt que vous avez porté à ' . htmlspecialchars($data_for_mail['nom_society']) . ' et sommes ravis de vous informer que votre candidature pour le poste de ' . htmlspecialchars($data_for_mail['title_offers']) . ' (' . htmlspecialchars($data_for_mail['type_offers']) . ') a retenu toute notre attention.
            
            Nous avons le plaisir de vous inviter à un entretien d\'embauche afin de mieux connaître vos motivations et discuter des prochaines étapes. Nous vous contacterons très prochainement pour convenir d\'une date.
            
            Cordialement,
            
            L\'équipe Recrutement ' . htmlspecialchars($data_for_mail['nom_society']) . '.';
            


            send_email($email, $subject, $message);


            set_flash_message("La candidature a été acceptée et un email a été envoyé avec succès.", "success");
            header('Location: ../../view/view_business/mes_offres_business.php');
        } else 
        {
            set_flash_message("Une erreur est survenue lors de l'acceptation de la candidature.", "error");
            header('Location: ../../view/view_business/mes_offres_business.php');
        }
    }


    public static function nb_candidats_await($id)
    {
        $my_bdd = Bdd::my_bdd();

        $req_nb_candidats_await = $my_bdd->prepare("SELECT COUNT(*) as nb  FROM `inscription_offers` WHERE 
        ref_offers = :ref_offers AND statuts_candidat IS NULL");
        $req_nb_candidats_await->execute(array(
            "ref_offers" => $id
        ));
        $data = $req_nb_candidats_await->fetch(PDO::FETCH_ASSOC);

        if($data['nb'] > 1)
        {
            $nb = $data['nb'];
            echo "Vous avez <span>$nb</span> candidatures en attente de décision !";
        }
        elseif($data['nb'] == 1)
        {
            $nb = $data['nb'];
            echo "Vous avez <span>$nb</span> candidature en attente de décision !";
        }
        else
        {
            $nb = $data['nb'];
            echo "Vous n'avez plus de candidature en attente de décision !";
        }
    }

    public function getAllOffers() 
    {
          
          $my_bdd = Bdd::my_bdd();

          $sql = $my_bdd->prepare("SELECT * FROM offers");
          $sql->execute();
          return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchOffers($search_term, $filters = [])
    {
          $my_bdd = Bdd::my_bdd();

          try 
          {
                $query = 'SELECT * FROM offers WHERE title_offers LIKE :search';

               // Options de filtrage (chatGPT)
               if (!empty($filters['formation'])) 
               {
                    $query .= ' AND target_offers IN (' . implode(',', array_map(function ($f) { return '"' . $f . '"'; }, $filters['formation'])) . ')';
               }
               if (!empty($filters['role'])) 
               {
                    $query .= ' AND  `type_offers` IN (' . implode(',', array_map(function ($s) { return '"' . $s . '"'; }, $filters['role'])) . ')';
               }
               if (!empty($filters['level'])) 
               {
                    $query .= ' AND  `degrees` IN (' . implode(',', array_map(function ($p) { return '"' . $p . '"'; }, $filters['level'])) . ')';
               }

               $query .= ' ORDER BY id_offers DESC'; 

               $req_select_offers = $my_bdd->prepare($query);
               $req_select_offers->execute(['search' => '%' . $search_term . '%']);
               $offers = $req_select_offers->fetchAll(PDO::FETCH_ASSOC);

               return $offers;
          } 
          catch (PDOException $e) 
          {
               echo "Erreur PDO : " . $e->getMessage();
               return [];
          }
    }

    public static function the_website($id)
    {
        $my_bdd = Bdd::my_bdd();

        $req_website = $my_bdd->prepare("SELECT website FROM `society` WHERE id_society = :id");
        $req_website->execute(array("id" => $id));
        return $req_website->fetch(PDO::FETCH_ASSOC);
    }

    public function getOfferById($id)
    {
        $my_bdd = Bdd::my_bdd();

        $req_by_id = $my_bdd->prepare('SELECT * FROM offers WHERE id_offers = :id_offers');
        $req_by_id->execute(array(
            'id_offers' => $id
        ));
        return $req_by_id->fetch(PDO::FETCH_ASSOC);
    }

    public function getSocietyUserIdByOfferId($offerId) 
    {
        $my_bdd = Bdd::my_bdd();
        
        $stmt = $my_bdd->prepare('
            SELECT s.ref_users 
            FROM offers o
            INNER JOIN society s ON o.ref_society = s.id_society 
            WHERE o.id_offers = :offer_id
        ');
        
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['ref_users'] : null; // Ternaire pour le resultat
    }

    public static function addOfferToFavorites($userId, $offerId)
    {
        $my_bdd = Bdd::my_bdd();

        $req_favorite = $my_bdd->prepare('SELECT * FROM favorites WHERE ref_users = :user_id AND ref_offers = :offer_id');
        $req_favorite->execute([
            'user_id' => $userId,
            'offer_id' => $offerId,
        ]);

        $favoriteExist = $req_favorite->fetch(PDO::FETCH_ASSOC);

        if ($favoriteExist) 
        {
            set_flash_message("Cette offre est déjà dans vos favoris.", "error");
            return false;
        }


        $req_favorite_insert = $my_bdd->prepare('INSERT INTO favorites (ref_users, ref_offers, date_added) VALUES (:user_id, :offer_id, :date_added)');
        $req_favorite_insert->execute([
            'user_id' => $userId,
            'offer_id' => $offerId,
            'date_added' => date('Y-m-d H:i:s'),
        ]);

        set_flash_message("L'offre a été ajoutée à vos favoris avec succès.", "success");
        return true;
    }

    public function getFavoritesByUserId($userId)
    {
        $my_bdd = Bdd::my_bdd();
        $my_req_favorite = $my_bdd->prepare('
            SELECT o.id_offers, o.title_offers, o.describe_offers, o.type_offers
            FROM favorites f
            INNER JOIN offers o ON f.ref_offers = o.id_offers
            WHERE f.ref_users = :user_id
        ');
        $my_req_favorite->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $my_req_favorite->execute();
        return $my_req_favorite->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeOfferFromFavorites($userId, $offerId)
    {
        $my_bdd = Bdd::my_bdd();
        $my_req_favorite = $my_bdd->prepare('
            DELETE FROM favorites WHERE ref_users = :user_id AND ref_offers = :offer_id
        ');
        $my_req_favorite->execute([
            'user_id' => $userId,
            'offer_id' => $offerId
        ]);
    }

    public static function viewAddOffers($id_offer)
    {
        $my_bdd = Bdd::my_bdd();

        $select_view_now = $my_bdd->prepare("SELECT view from offers where id_offers = :id_offers");
        $select_view_now->execute(array("id_offers" => $id_offer));
        $data = $select_view_now->fetch(PDO::FETCH_ASSOC);

        $nb_after_view = $data['view'] + 1;
        $insert_view = $my_bdd->prepare("UPDATE offers SET view = :view_now WHERE id_offers = :id_offers");
        $insert_view->execute(array(
            "view_now" => $nb_after_view,
            "id_offers" => $id_offer
        ));
    }
    
}