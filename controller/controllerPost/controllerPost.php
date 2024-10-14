<?php

require_once __DIR__ . '/../../models/Post.php';
class controllerPost
{

    private $postModel; // Propriété pour stocker l'instance du modèle Post

    public function __construct()
    {
        $this->postModel = new Post(); // Créer une instance du modèle Post
    }

    // Méthode pour afficher la liste des posts
    public function list()
    {
        // recuperation des posts
        $posts = $this->postModel->getAll();

        // Passer les posts à la vue pour l'affichage
        require_once __DIR__ . '/../../view/view_post/list.php';
    }

    // Méthode pour afficher le formulaire de création de post
    public function create()
    {
        // Afficher le formulaire de création de post
        require_once __DIR__ . '/../../view/view_post/creation.php';
    }

    // Méthode pour traiter la création d'un nouveau post
    public function store()
    {

    }
}
?>