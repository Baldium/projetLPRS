<?php

require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/ReponsePost.php';

class ControllerPost
{
    private $postModel;


    public function __construct()
    {
        $pdo = Bdd::my_bdd();
        $this->postModel = new Post($pdo);
    }

    // Méthode pour afficher la liste des posts
    public function liste()
    {
        $posts = $this->postModel->getTous();
        require_once __DIR__ . '/../../view/view_post/liste.php';
    }

    // Méthode pour afficher le formulaire de création de post
    public function creer()
    {
        require_once __DIR__ . '/../../view/view_post/creation.php';
    }

    // Méthode pour traiter la création d'un nouveau post
    public function stocker()
    {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['title'];
            $description = $_POST['description'];
            $ref_utilisateur = $_POST['ref_users'];
            $ref_societe = $_POST['ref_society'];
            $ref_professionnel = $_POST['ref_prof'];

            // Validation des données
            if (empty($titre)) {
                $erreurs[] = "Le titre est obligatoire.";
            }
            if (empty($description)) {
                $erreurs[] = "La description est obligatoire.";
            }

            // Gestion de l'upload de l'image/vidéo
            $image_video = null;
            if (isset($_FILES['image_video']) && $_FILES['image_video']['error'] === UPLOAD_ERR_OK) {
                $typesAutorises = ['jpg', 'jpeg', 'png', 'gif', 'mp4'];
            }
        }
    }
}