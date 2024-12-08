<?php

require_once __DIR__ . '/../utils/Bdd.php';

class Post {
    private $db;

    public function __construct() {
        $this->db = Bdd::my_bdd(); // Établir la connexion à la base de données
    }

    public function create($title, $description, $image_video, $ref_users) {
        $view = 0; // Par défaut, la vue du post est à 0
    
        // Insertion du post dans la base de données
        $sql = "INSERT INTO posts (title, description, image_video, date_created, ref_users, view_post) 
                VALUES (:title, :description, :image_video, NOW(), :ref_users, :view)";
        
        $req = $this->db->prepare($sql);
        
        try {
            // Exécution de la requête
            $req->execute([
                ':title' => $title,
                ':description' => $description,
                ':image_video' => $image_video, // Le contenu du fichier
                ':ref_users' => $ref_users,
                ':view' => $view
            ]);
        } catch (PDOException $e) {
            // En cas d'erreur, on retourne false
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    
        // Retourner l'ID du post inséré
        return $this->db->lastInsertId();
    }
    
    
    // Récupérer un post avec son ID
    public function getById($id_post) {
        $sql = "SELECT * FROM posts WHERE id_post = :id_post";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    // Affichage du post
    public function affichagePost($post) {
        if ($post) {
            echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($post['description'])) . "</p>";

            // Affichage vidéo et image
            if (!empty($post['image_video'])) {
                echo "<img src='" . htmlspecialchars($post['image_video']) . "' alt='Image/Vidéo du post'>";
            }

            echo "<p>Publié le " . htmlspecialchars($post['date_created']) . "</p>";
        } else {
            echo "<p>Aucun post trouvé.</p>";
        }
    }

    // Récupération des posts et rangement dans l'ordre décroissant
    public function getAll() {
        $sql = "SELECT * FROM posts ORDER BY date_created DESC"; // desc pour le sens
        $req = $this->db->prepare($sql);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>