<?php
// trait_post.php

require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../utils/Bdd.php';

// initialisation message d'erreurs
$errors = [];

// verifier si le formulaire a ete soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Récupérer les données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ref_users = $_POST['ref_users'];
    $ref_society = $_POST['ref_society'];
    $ref_prof = $_POST['ref_prof'];

    // Validation des données
    if (empty($title)) {
        $errors[] = "Le titre est obligatoire.";
    }
    if (empty($description)) {
        $errors[] = "La description est obligatoire.";
    }


    // Gestion de l'upload de l'image/vidéo
    $image_video = null;
    if (isset($_FILES['image_video']) && $_FILES['image_video']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
        $uploadDir = __DIR__ . '/../uploads/';
        $fileName = $_FILES['image_video']['name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileSize = $_FILES['image_video']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Type de fichier non autorisé.";
        }
        if ($fileSize > 5000000) {
            $errors[] = "La taille du fichier est trop volumineuse.";
        }

        if (empty($errors)) {
            $uploadFile = $uploadDir . basename($fileName);
            if (move_uploaded_file($_FILES['image_video']['tmp_name'], $uploadFile)) {
                $image_video = '/uploads/' . basename($fileName);
            } else {
                $errors[] = "Erreur lors de l'upload du fichier.";
            }
        }
    }

    // enregistrer le post en base de données si 0 errors
    if (empty($errors)) {
        $postModel = new Post();
        $postId = $postModel->create($title, $description, $image_video, $ref_users, $ref_society, $ref_prof, date('Y-m-d'));

        if ($postId) {
            header('Location: ../view/view_post/list.php'); // Redirige vers la liste des posts
            exit;
        } else {
            $errors[] = "Erreur lors de la création du post.";
        }
    }

    // Si erreurs lors de l'enregistrement
    if (!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;

        header('Location: ../view/view_post/creation.php');
        exit;
    }
} else {
    // Si le formulaire n'a pas été soumis, rediriger vers le formulaire
    header('Location: ../view/view_post/creation.php');
    exit;
}
?>