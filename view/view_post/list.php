<?php
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des posts</title>
    <link rel="stylesheet" href="../../public/css/post_list.css"> </head>
<body>
<h1>Liste des posts</h1>

<?php if (!empty($posts)): ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <h2>
                    <a href="post.php?id=<?= $post['id_post'] ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                </h2>
                <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>
                <p>Publié le <?= $post['date_created'] ?></p>
                <!-- Ajoute ici les informations sur l'auteur, les likes, etc. -->
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun post pour le moment.</p>
<?php endif; ?>

</body>
</html>