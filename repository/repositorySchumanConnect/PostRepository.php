<?php
include_once '../../utils/Bdd.php';
include '../../init.php';
include_once '../../utils/flash.php';

//session_start();
class PostRepository
{
    public static function nb_post_published()
    {
        $my_bdd = Bdd::my_bdd();

        $req_nb_post = $my_bdd->prepare('SELECT COUNT(*)AS nb_posts FROM `post` WHERE `ref_society` = :ref_users');
        $req_nb_post->execute(array(
            "ref_users" => $_SESSION['id_society']
        ));
        $data = $req_nb_post->fetch(PDO::FETCH_ASSOC);

        if($data)
        {
            if($data['nb_posts'] <= 1)
            {  
                return $data['nb_posts'];
            }
            else
            {
                return $data['nb_posts'];
            }
        }
        else
        {
            return "Une erreur est survenue";
        }
    }

    public static function insert_post_society($title, $description, $image_video = null)
    {
        $my_bdd = Bdd::my_bdd();
    
        $req_insert_post_society = $my_bdd->prepare('
            INSERT INTO `post` (`title`, `description`, `image_video`, `date_created`, `ref_society`, view_post) 
            VALUES (:title, :descri, :img, :date_created, :ref_society, :view_initial)
        ');
        $result = $req_insert_post_society->execute(array(
            'title' => $title,
            'descri' => $description,
            'img' => $image_video, 
            'date_created' => date('Y-m-d'), // Format ISO 8601
            'ref_society' => $_SESSION['id_society'],
            'view_initial' => 0
        ));
        
        if ($result)
        {
            set_flash_message('Le post a bien été inséré.', 'success');
            header('Location: ../../view/view_business/accueil_business.php');
        } else 
        {
            set_flash_message('Erreur lors de l\'insertion du post.', 'error');
            header('Location: ../../view/view_business/post_business.html');
        }
    }

    public static function insert_post_societyEtudiant($title, $canal, $description, $image_video = null)
    {
        $my_bdd = Bdd::my_bdd();
    
        $req_insert_post_society = $my_bdd->prepare('
            INSERT INTO `post` (`canal`, `title`, `description`, `image_video`, `date_created`, `ref_users`, view_post) 
            VALUES (:canal, :title, :descri, :img, :date_created, :ref_users, :view_initial)
        ');
        $result = $req_insert_post_society->execute(array(
            'canal' => $canal,
            'title' => $title,
            'descri' => $description,
            'img' => $image_video, 
            'date_created' => date('Y-m-d'), // Format ISO 8601
            'ref_users' => $_SESSION['id_users'],
            'view_initial' => 0
        ));
        
        if ($result)
        {
            set_flash_message('Le post a bien été inséré.', 'success');
            header('Location: ../../view/view_etudiants/accueil.php');
        } else 
        {
            set_flash_message('Erreur lors de l\'insertion du post.', 'error');
            header('Location: ../../view/view_etudiants/accueil.php');
        }
    }
    

    
    // Fonction pour afficher le nb entier de post d'une entreprise
    public static function find_all_posts_by_company()
    {
        $my_bdd = Bdd::my_bdd();

        $req_find_posts = $my_bdd->prepare("SELECT * FROM post WHERE ref_society = :ref_society");
        $req_find_posts->execute(
            array(
                "ref_society" => $_SESSION['id_society']
            )
        );

        $data = $req_find_posts->fetchAll(PDO::FETCH_ASSOC);

        if ($data) 
        {
            echo '<div class="offers-container">';
            foreach ($data as $element) 
            {
                echo '<div class="offer-card">';
                echo '<h3 class="offer-title">' . htmlspecialchars($element['title']) . '</h3>'; 
                echo '<p class="offer-description"><strong>Description :</strong> ' . htmlspecialchars($element['description']) . '</p>';

                if (!empty($element['image_video'])) 
                {
                    echo '<p><strong>Votre image :</strong></p>';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($element['image_video']) . '" alt="Votre image" />';
                } 
                echo '<br>';
                echo '<p class="offer-description"> <stron></strong> <i class="fas fa-eye"></i> ' . htmlspecialchars($element['view_post']) . '</p>';
                echo '<div class="offer-actions">';
                echo '<a href="modifer_post_business.php?id=' . htmlspecialchars($element['id_post']) . '" class="btn modify-btn">Modifier</a>';
                echo '<a href="supprimer_post_business.php?id=' . htmlspecialchars($element['id_post']) . '" class="btn delete-btn">Supprimer</a>';
                echo '</div>';

                echo '</div>';  
            }
            echo '</div>';  
        } else 
        {
            echo '<p>Aucune offre trouvée pour cette entreprise.</p>';
        }
    }

    public static function find_post_by_id($id) 
    {
        $my_bdd = Bdd::my_bdd();
    
        $req_find_post = $my_bdd->prepare("SELECT * FROM post WHERE id_post = :id");
        $req_find_post->execute(array('id' => $id));
    
        return $req_find_post->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function update_post($id_post_update, $new_title_post, $new_describe_post, $new_image)
    {
        $my_bdd = Bdd::my_bdd();

        $req_update = $my_bdd->prepare('UPDATE `post` SET `title`= :new_title, `description`= :new_description,
        `image_video`= :new_image WHERE id_post = :id_post');
        $req_update->execute(array(
            'new_title' => $new_title_post,
            'new_description' => $new_describe_post,
            'new_image' => $new_image,
            'id_post' => $id_post_update,
        ));
        $perfet_update = $req_update;

        if($perfet_update)
        {
            set_flash_message('Le post a été mis à jour avec succès.', 'success');
            header('Location: ../../view/view_business/mes_posts_business.php');
            exit();

        }
        else
        {
            set_flash_message('Erreur lors de la mise à jour du post.', 'error');
            header('Location: ../../view/view_business/mes_posts_business.php');
            exit();
        }
    }

    public static function delete_post($id_post)
    {
        $my_bdd = Bdd::my_bdd();

        $req_delete = $my_bdd->prepare('DELETE FROM `post` WHERE id_post = :id_post');
        
        $result = $req_delete->execute(array(
            'id_post' => $id_post,
        ));

        if ($result) {
            
            set_flash_message('Le post a bien été supprimé.', 'success');
            header('Location: ../../view/view_business/mes_posts_business.php');
            exit();
        } else 
        {
            set_flash_message('Erreur lors de la suppression du post.', 'error'); 
            header('Location: ../../view/view_business/mes_posts_business.php');
            exit();
        }
    }

}
?>