<!DOCTYPE html>
<html>
<head>
    <title>Créer un post</title>
    <link rel="stylesheet" href="/../../public/css/post_creation.css">
    <link rel="stylesheet" href="/../../erreur_post.css">
</head>
<body>

<h1>Créer un nouveau post</h1>

<!-- afficher les erreurs ->
<?php
session_start();
if (isset($_SESSION['errors'])): ?>
    <div class="errors">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="../controller/controllerPost/trait_post.php" method="POST" enctype="multipart/form-data">
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="image_video">Image/Vidéo :</label>
        <input type="file" id="image_video" name="image_video">
    </div>

    <!-- Champs cachés pour ref_users, ref_society, ref_prof -->
    <input type="hidden" name="ref_users" value="...">
    <input type="hidden" name="ref_society" value="...">
    <input type="hidden" name="ref_prof" value="...">

    <button type="submit">Publier</button>
</form>

</body>
</html>