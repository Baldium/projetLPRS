<?php
include '../utils/Bdd.php';
include '../models/Offers.php';
session_start();
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
                        <th>Action</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            foreach ($data as $element) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($element['title_offers']) . '</td>';  
                echo '<td>' . htmlspecialchars($element['type_offers']) . '</td>';   
                echo '<td>' . htmlspecialchars($element['degrees']) . '</td>';       
                
                echo '<td>' . ($element['disponible'] == 1 ? 'Ouvert' : 'Fermé') . '</td>';
                
                echo '<td><a href="modifier_offre.php?id=' . htmlspecialchars($element['id_offers']) . '">Modifier</a></td>';
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

        $req_find_offers = $my_bdd->prepare("
            SELECT id_offers, title_offers, describe_offers, mission, type_offers, salary, degrees, target_offers, disponible 
            FROM `offers` 
            WHERE ref_society = :ref_society
        ");

        $req_find_offers->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );

        $data = $req_find_offers->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            echo '<div class="offers-container">';
            foreach ($data as $element) {
                echo '<div class="offer-card">';
                
                echo '<h3>' . htmlspecialchars($element['title_offers']) . '</h3>'; 
                echo '<p><strong>Description :</strong> ' . htmlspecialchars($element['describe_offers']) . '</p>';  
                echo '<p><strong>Mission :</strong> ' . htmlspecialchars($element['mission'] ?? 'Non spécifiée') . '</p>';  
                echo '<p><strong>Contrat :</strong> ' . htmlspecialchars($element['type_offers']) . '</p>';  
                echo '<p><strong>Salaire :</strong> ' . ($element['salary'] ? htmlspecialchars($element['salary']) . ' €' : 'Non spécifié') . '</p>';  
                echo '<p><strong>Diplôme requis :</strong> ' . htmlspecialchars($element['degrees']) . '</p>';  
                echo '<p><strong>Cible :</strong> ' . htmlspecialchars($element['target_offers']) . '</p>';  
                echo '<p><strong>Statut :</strong> ' . ($element['disponible'] == 1 ? 'Ouvert' : 'Fermé') . '</p>';  

                echo '<div class="offer-actions">';
                echo '<a href="modifier_offre.php?id=' . htmlspecialchars($element['id_offers']) . '" class="btn modify-btn">Modifier</a>';
                echo '<a href="supprimer_offre.php?id=' . htmlspecialchars($element['id_offers']) . '" class="btn delete-btn">Supprimer</a>';
                echo '</div>';
                
                echo '</div>';  
            }
            echo '</div>';  
        } else {
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
            disponible, ref_society) VALUES (:title_offers, :describe_offers, :mission, :type_offers, :salary, :degrees, :target_offers, :disponible, :ref_society)');
            $perfet_insert = $req_insert_offers->execute(array(
                'title_offers' => $offers->get_title_offers(),
                'describe_offers' => $offers->get_describe_offers(),
                'mission' => $offers->get_mission(),
                'type_offers' => $offers->get_type_offers(),
                'salary' => $offers->get_salary(),
                'degrees' => $offers->get_degrees(),
                'target_offers' => $offers->get_target_offers(),
                'disponible' => $offers->get_disponible(),
                'ref_society' => $_SESSION['id_society']
            ));
            if($perfet_insert)
            {
                echo "Parfait c bien rentrer en BDD";
                header('Location: ../view/accueil_business.php');
            }
            else
            {
                echo "Y a un ptit soucis la";
                header('Location: ../view/accueil_business.php');
            }

        }
        catch (PDOException $e) 
        {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }

    // Fonction pour modifier une offre
    public static function update_offers()
    {

    }

    // Fonction pour supprimer une offre
    public static function delete_offers()
    {

    }

   
}