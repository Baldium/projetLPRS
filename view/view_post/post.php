<?php

require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../utils/Bdd.php';

// Récupérer l'ID du post depuis l'URL
$postId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si l'ID est valide
if ($postId === 0) {
    die("ID de post invalide.");
}

// Récupérer le post depuis la base de données
$postModel = new Post();
$post = $postModel->getById($postId);

// Vérifier si le post existe
if (!$post) {
    die("Le post n'existe pas.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="../public/css/post.css">  </head>
<body>

<article>
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>

    <?php if (!empty($post['image_video'])): ?>
        <img src="<?= htmlspecialchars($post['image_video']) ?>" alt="Image/Vidéo du post">
    <?php endif; ?>

    <p class="post-meta">
        Publié le <?= $post['date_created'] ?>
        <!-- nom de lauteur  plus tard aussi -->
    </p>

    <!--
         les sections pour les commentaires, les likes, etc. pour plus tard
    -->

</article>

</body>
</html>