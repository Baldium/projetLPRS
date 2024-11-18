<?php

require_once __DIR__ . '/../utils/Bdd.php';

class ReponsePost
{
    private $db;

    public function __construct() {
        $this->db = Bdd::my_bdd();
    }

    // Récupérer les réponses par ID de post
    public function getByPostId($postId) {
        $sql = "SELECT * FROM reponse_posts WHERE post_id = :post_id ORDER BY date_created DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle réponse
    public function create($postId, $text) {
        $sql = "INSERT INTO reponse_posts (post_id, text, date_created) VALUES (?, ?, NOW())";

}
}
