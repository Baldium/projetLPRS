<?php

require_once __DIR__ . '/../utils/Bdd.php';

class Post {
    private $db;

    public function __construct() {
        $this->db = Bdd::my_bdd(); // Établir la connexion à la base de données
    }

    // Création d'un nouveau post
    public function create($title, $description, $image_video, $ref_users, $ref_society, $ref_prof) {
        // Vérifiez si ref_users existe dans la table users
        $checkUserSql = "SELECT * FROM users WHERE id_users = :ref_users";
        $req = $this->db->prepare($checkUserSql);
        $req->bindParam(':ref_users', $ref_users, PDO::PARAM_INT);
        $req->execute();

        if ($req->rowCount() === 0) {
            throw new Exception("L'utilisateur avec l'ID $ref_users n'existe pas.");
        }

        // Vérifiez si ref_society existe dans la table society
        $checkSocietySql = "SELECT * FROM society WHERE id_society = :ref_society";
        $req = $this->db->prepare($checkSocietySql);
        $req->bindParam(':ref_society', $ref_society, PDO::PARAM_INT);
        $req->execute();

        if ($req->rowCount() === 0) {
            throw new Exception("La société avec l'ID $ref_society n'existe pas.");
        }

        // Vérifiez si ref_prof existe dans la table prof
        $checkProfSql = "SELECT * FROM prof WHERE id_prof = :ref_prof";
        $req = $this->db->prepare($checkProfSql);
        $req->bindParam(':ref_prof', $ref_prof, PDO::PARAM_INT);
        $req->execute();

        if ($req->rowCount() === 0) {
            throw new Exception("Le professionnel avec l'ID $ref_prof n'existe pas.");
        }

        // Si toutes les vérifications sont passées, procédez à l'insertion
        $sql = "INSERT INTO posts (title, description, image_video, date_created, ref_users, ref_society, ref_prof) 
                VALUES (?, ?, ?, NOW(), ?, ?, ?)";
        $req = $this->db->prepare($sql);





        try {
            $req->execute([$title, $description, $image_video, $ref_users, $ref_society, $ref_prof]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }

        return $this->db->lastInsertId(); // Retourne l'ID du post créé
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