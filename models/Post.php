<?php

require_once __DIR__ . '/../utils/Bdd.php';
class Post {

    private $db;

    public function __construct($db) {
        $this->db = Bdd::my_bdd();
    }

    // creation nv post
    public function create($title, $description, $image_video, $ref_users, $ref_society, $ref_prof) {
        $sql = "INSERT INTO posts (title, description, image_video, date_created, ref_users, ref_society, ref_prof) 
                VALUES (?, ?, ?, NOW(), ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $description, $image_video, $ref_users, $ref_society, $ref_prof]);

        return $this->db->lastInsertId(); // Retourne l'ID du post créé
    }

    // recuperer un post avec son id getID
    public function getById($id_post) {
        $sql = "SELECT * FROM posts WHERE id_post = :id_post";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // affichage du post
    public function affichagePost($post) {
        if ($post) {
            echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($post['description'])) . "</p>";

            // affichage video et image
            if (!empty($post['image_video'])) {
                echo "<img src='" . htmlspecialchars($post['image_video']) . "' alt='Image/Vidéo du post'>";
            }

            echo "<p>Publié le " . $post['date_created'] . "</p>";
            // information sur le post
        } else {
            echo "<p>Aucun post trouvé.</p>";
        }
    }

    // recuperation des posts et ranger dans lordre decroissants
    public function getAll() {
        $sql = "SELECT * FROM posts ORDER BY date_created DESC"; // desc pour le sens
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?>