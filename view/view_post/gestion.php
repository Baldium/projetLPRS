<?php
include_once __DIR__ . '/../../init.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Posts</title>
    <link rel="stylesheet" href="../../public/css/gestion.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="../../view/view_etudiants/accueil.php">Accueil</a></li>
        <li><a href="../../view/view_etudiants/qui-sommes-nous.html">Qui sommes-nous ?</a></li>
    </ul>
</nav>

<div class="container">
    <h1>Gestion des Posts</h1>
    <div class="button-container">
        <a href="../../view/view_post/creation.php?canal=general" class="button">Créer un Post</a>
        <?php
        if ($_SESSION['role'] === 'etudiant') {
            echo '<a href="../../view/view_post/creation.php?canal=etudiant_prof" class="button">Créer un post dans le canal etudiant prof</a>';
        }
        if ($_SESSION['role'] === 'alumni' || $_SESSION['role'] === 'pdg_entreprise') {
            echo '<a href="../../view/view_post/creation.php?canal=alumni_entreprise" class="button">Créer un post dans le canal alumni societé</a>';
        }
        ?>


        <a href="../../view/view_post/post.php?user_id=<?= $_SESSION['id_users'] ?>" class="button">Voir Mes Posts</a>
    </div>
</div>
</body>
</html>