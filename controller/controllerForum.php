<?php


namespace controller;
require_once 'app/Models/Post.php';
require_once 'app/Models/ReponsePost.php';
class controllerForum
{
    private $db;
    private $postModel;
    private $reponseModel;

    public function __construct($db) {
        $this->db = $db;
        $this->postModel = new Post($db);
        $this->reponseModel = new ReponsePost($db);
    }

    // Afficher tous les posts
    public function index() {
        $posts = $this->postModel->getAllPosts();
        include 'views/forum/index.php'; // Charger la vue
    }

    // Afficher un post spécifique avec ses réponses
    public function show($id) {
        $post = $this->postModel->getPostById($id);
        $reponses = $this->reponseModel->getRepliesByPostId($id);
        include 'views/forum/show.php'; // Charger la vue
    }

    // Afficher le formulaire de création de post
    public function create() {
        include 'views/forum/create.php'; // Charger la vue de création
    }

    // Enregistrer un nouveau post
    public function store($request) {
        // Gérer le téléchargement de l'image
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imagePath = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        // Créer le post
        $this->postModel->createPost($request['title'], $request['description'], $imagePath);
        header('Location: /public/index.php'); // Rediriger vers la liste des posts
    }

    // Enregistrer une réponse à un post
    public function reply($postId, $request) {
        $this->reponseModel->createReply($postId, $request['text']);
        header('Location: /public/show.php?id=' . $postId); // Rediriger vers le post
    }
}